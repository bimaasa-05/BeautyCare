<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Membership;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\DB;
use App\Services\SaldoAkunService;

class KasirPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;

        $reservasiSelesai = Booking::with(['pelanggan', 'detail.layanan'])
            ->whereIn('status', ['diproses', 'selesai'])
            ->where(function ($query) {
                $query->whereDoesntHave('transaksi')->orWhere('status_pembayaran', 'dp');
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nm_pelanggan', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_booking', 'desc')
            ->get();

        $totalTagihan = Booking::whereIn('status', ['diproses', 'selesai'])
            ->where(function ($query) {
                $query->whereDoesntHave('transaksi')->orWhere('status_pembayaran', 'dp');
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nm_pelanggan', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->count();

        $totalSudahDibayar = Transaksi::where('status', 'Lunas')->count();

        $pesananOnlineCount = Transaksi::where('sumber', 'online')
            ->whereIn('status', ['Menunggu Pembayaran', 'Sedang Diproses'])
            ->count();

        return view('kasir.pembayaran.index', compact('reservasiSelesai', 'totalTagihan', 'totalSudahDibayar', 'pesananOnlineCount'));
    }

    public function create($id)
    {
        $booking = Booking::with(['pelanggan', 'karyawan', 'detail.layanan', 'transaksi.pembayaran'])->findOrFail($id);

        if (!in_array($booking->status, ['diproses', 'selesai'])) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking belum check-in, tidak bisa diproses');
        }

        if ($booking->transaksi()->exists() && $booking->status_pembayaran !== 'dp') {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking ini sudah memiliki pembayaran');
        }

        $banks = \App\Models\Bank::active()->transfer()->get(['id', 'nama_bank', 'no_rekening', 'kode_bank', 'logo', 'atas_nama']);
        $ewallets = \App\Models\Bank::active()->ewallet()->get(['id', 'nama_bank', 'nomor_telepon', 'atas_nama']);

        $totalBayar = (int) $booking->detail->sum('subtotal');
        $dpPaid = 0;
        if ($booking->status_pembayaran === 'dp' && $booking->transaksi) {
            $dpPaid = (int) (($booking->transaksi->pembayaran->nominal ?? 0) + ($booking->transaksi->saldo_terpakai ?? 0));
        }
        $sisa = max(0, $totalBayar - $dpPaid);

        return view('kasir.pembayaran.create', compact('booking', 'banks', 'ewallets', 'totalBayar', 'dpPaid', 'sisa'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'bank_id' => $request->input('metode_byr') !== 'Transfer' ? null : $request->input('bank_id'),
            'ewallet_type' => $request->input('metode_byr') !== 'E-Wallet' ? null : $request->input('ewallet_type'),
        ]);

        $request->validate([
            'id_booking' => 'required|integer|exists:booking,id_booking',
            'metode_byr' => 'required|in:Tunai,Transfer,E-Wallet',
            'total' => 'required|numeric|min:0',
            'dibayar' => 'required|numeric|min:0|gte:total',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|required_if:metode_byr,E-Wallet|string|max:50',
            'bank_id' => 'nullable|required_if:metode_byr,Transfer|integer|exists:banks,id',
        ]);

        $booking = Booking::with(['pelanggan', 'detail.layanan'])->findOrFail($request->id_booking);

        if ($booking->transaksi()->exists() && $booking->status_pembayaran !== 'dp') {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking ini sudah memiliki pembayaran');
        }

        $isDpSisa = $booking->status_pembayaran === 'dp';

        $total = $request->total;
        $dibayar = $request->dibayar;
        $kembali = max(0, $dibayar - $total);

        $statusPembayaran = in_array($request->metode_byr, ['E-Wallet', 'Tunai']) ? 'Lunas' : 'Proses';

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $buktiBayar = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiBayar = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        $transaksi = Transaksi::create([
            'id_booking' => $isDpSisa ? null : $request->id_booking,
            'id_pelanggan' => $booking->id_pelanggan,
            'id_user' => auth()->id(),
            'id_kasir' => auth()->id(),
            'jenis_transaksi' => 'Booking',
            'no_invoice' => $no_invoice,
            'tanggal' => date('Y-m-d'),
            'subtotal' => $total,
            'diskon' => 0,
            'pajak' => 0,
            'total' => $total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'catatan' => ($isDpSisa ? 'Sisa DP booking #BK' . str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) . '. ' : '') . ($request->catatan ?? ''),
            'status' => $statusPembayaran,
            'bukti_bayar' => $request->bukti_bayar ? $buktiBayar : null,
            'no_referensi' => $request->no_referensi,
            'ewallet_type' => $request->ewallet_type,
        ]);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan pembayaran ' . $no_invoice, 'Pembayaran', $transaksi->id_transaksi);

        foreach ($booking->detail as $d) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis' => 'Layanan',
                'id_item' => $d->id_layanan,
                'nm_item' => $d->layanan->nm_layanan ?? 'Layanan',
                'qty' => 1,
                'harga' => $d->harga,
                'diskon' => $d->diskon ?? 0,
                'subtotal' => ($d->harga ?? 0) - ($d->diskon ?? 0),
            ]);
        }

        $bookingUpdate = ['status' => 'selesai', 'jam_selesai_aktual' => now()];
        if ($isDpSisa) {
            $bookingUpdate['status_pembayaran'] = 'lunas';
            Transaksi::where('id_booking', $request->id_booking)
                ->where('status', 'DP Dibayar')
                ->update(['status' => 'Lunas']);
        }
        Booking::where('id_booking', $request->id_booking)->update($bookingUpdate);

        // Proses saldo & cashback jika Lunas
        if ($statusPembayaran === 'Lunas') {
            $saldoService = new SaldoAkunService();
            $saldoService->prosesCheckout(
                $booking->id_pelanggan,
                $total,
                0, // kasir tidak pakai saldo pelanggan, hanya cashback
                $transaksi->id_transaksi
            );
        }

        buatNotif(auth()->user()->id, 'Pembayaran Berhasil', 'Pembayaran ' . $no_invoice . ' berhasil diproses (' . $request->metode_byr . ')', 'Transaksi', route('kasir.pembayaran.show', $transaksi->id_transaksi));

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Pembayaran Masuk', 'Pembayaran ' . $no_invoice . ' oleh ' . auth()->user()->nama . ' (' . $request->metode_byr . ')', 'Transaksi', url('/admin/dashboard'));
        }

        return redirect()->route('kasir.pembayaran.show', $transaksi->id_transaksi)
            ->with('message', 'Pembayaran berhasil diproses');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'user', 'kasir', 'detail', 'booking.detail.layanan'])->findOrFail($id);
        return view('kasir.pembayaran.show', compact('transaksi'));
    }

    public function pesananOnline()
    {
        $pesanan = Transaksi::with(['pelanggan', 'user', 'detail', 'pembayaran', 'booking.detail.layanan'])
            ->where('sumber', 'online')
            ->whereIn('status', ['Menunggu Pembayaran', 'Sedang Diproses'])
            ->orderBy('id_transaksi', 'desc')
            ->get();

        $demoMode = env('CHECKOUT_DEMO_MODE', false);

        return view('kasir.pembayaran.pesanan-online', compact('pesanan', 'demoMode'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:konfirmasi,tolak',
            'no_referensi' => 'nullable|string|max:50',
        ]);

        $transaksi = Transaksi::with(['detail', 'pembayaran'])->findOrFail($id);

        if ($transaksi->sumber !== 'online' || !in_array($transaksi->status, ['Sedang Diproses', 'Menunggu Pembayaran'])) {
            return back()->with('error', 'Status pesanan tidak valid untuk verifikasi.');
        }

        if ($request->aksi === 'konfirmasi') {
            foreach ($transaksi->detail as $d) {
                if ($d->jenis === 'Produk' && $d->id_item > 0) {
                    $produk = Produk::find($d->id_item);
                    if (!$produk || $produk->stok < $d->qty) {
                        return back()->with('error', 'Stok ' . ($produk->nm_produk ?? 'produk') . ' tidak mencukupi untuk dikonfirmasi.');
                    }
                }
            }

            DB::transaction(function () use ($transaksi, $request) {
                foreach ($transaksi->detail as $d) {
                    if ($d->jenis === 'Produk' && $d->id_item > 0) {
                        $produk = Produk::find($d->id_item);
                        if ($produk) {
                            $stokLama = $produk->stok;
                            $produk->decrement('stok', $d->qty);
                            $produk->refresh();
                            catatStok($produk->id_produk, 'Keluar', $d->qty, $stokLama, $produk->stok, 'Penjualan online (konfirmasi kasir) ' . $transaksi->no_invoice, null, $transaksi->id_transaksi, 'Transaksi');
                        }
                    }
                }

                $statusBaru = 'Lunas';
                if ($transaksi->id_booking) {
                    $bookingVerifikasi = Booking::find($transaksi->id_booking);
                    if ($bookingVerifikasi && $bookingVerifikasi->tipe_pembayaran === 'dp') {
                        $statusBaru = 'DP Dibayar';
                    }
                }

                $transaksi->update(['status' => $statusBaru, 'id_kasir' => auth()->id()]);

                if ($transaksi->id_booking && isset($bookingVerifikasi) && $bookingVerifikasi) {
                    $bookingVerifikasi->update([
                        'status' => 'dikonfirmasi',
                        'status_pembayaran' => $statusBaru === 'DP Dibayar' ? 'dp' : 'lunas',
                    ]);
                }

                if ($transaksi->pembayaran) {
                    $transaksi->pembayaran->update([
                        'status' => 'Dibayar',
                        'paid_at' => now(),
                        'no_referensi' => $request->no_referensi ?? $transaksi->pembayaran->kode_pembayaran,
                    ]);
                }

                // Proses saldo & cashback
                $saldoService = new SaldoAkunService();
                if ($transaksi->jenis_transaksi === 'TopUp Saldo') {
                    $saldoService->kreditTopUp($transaksi->id_pelanggan, (float) $transaksi->total, $transaksi->id_transaksi);
                } else {
                    $saldoService->prosesCheckout(
                        $transaksi->id_pelanggan,
                        (float) $transaksi->total,
                        0, // hanya cashback, tidak pakai saldo
                        $transaksi->id_transaksi,
                        $transaksi->detail->firstWhere('id_promo')?->id_promo
                    );
                }

                $detailMembership = $transaksi->detail->firstWhere('jenis', 'Membership');
                if ($detailMembership && $transaksi->id_pelanggan) {
                    $pelanggan = Pelanggan::find($transaksi->id_pelanggan);
                    $tier = Membership::find($detailMembership->id_item);

                    if ($pelanggan && $tier) {
                        // Perpanjang/Upgrade: extend from current expiry if still active, else from now
                        $currentExpiry = null;
                        if ($pelanggan->id_member && $pelanggan->tgl_mulai_member) {
                            $oldTier = Membership::find($pelanggan->id_member);
                            if ($oldTier) {
                                $currentExpiry = $oldTier->tanggalBerakhir($pelanggan->tgl_mulai_member);
                            }
                        }
                        $pelanggan->id_member = $tier->id_member;
                        $pelanggan->tgl_mulai_member = ($currentExpiry && $currentExpiry->isFuture())
                            ? $currentExpiry->copy()->startOfDay()
                            : now();
                        $pelanggan->save();

                        ActivityLogger::log('Mengubah', $transaksi->user->nama ?? 'Pelanggan' . ' membership diaktifkan ke level ' . $tier->tingkat . ' via pembayaran ' . $transaksi->no_invoice, 'Membership', $pelanggan->id_pelanggan);

                        buatNotif($transaksi->id_user, 'Membership Aktif', 'Selamat! Membership ' . $tier->tingkat . ' Anda telah aktif. Nikmati semua keuntungannya!', 'Membership', route('pelanggan.membership'));
                    }
                }
            });

            $konfirmasiLabel = $transaksi->status === 'DP Dibayar'
                ? 'DP booking ' . $transaksi->no_invoice
                : 'pesanan ' . $transaksi->no_invoice . ' lunas';
            ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mengkonfirmasi ' . $konfirmasiLabel, 'Transaksi', $transaksi->id_transaksi);

            if ($transaksi->jenis_transaksi === 'TopUp Saldo') {
                $nominalTopUp = number_format((float) $transaksi->total, 0, ',', '.');
                buatNotif($transaksi->id_user, 'Top Up Berhasil', 'Top up saldo ' . $transaksi->no_invoice . ' telah terverifikasi. Saldo Anda bertambah Rp ' . $nominalTopUp . '.', 'Saldo', route('pelanggan.saldo.index'));
            } else {
                $targetNotif = $transaksi->id_booking
                    ? route('pelanggan.pembayaran.berhasil', $transaksi->id_transaksi)
                    : route('pelanggan.pesanan.show', $transaksi->id_transaksi);
                if ($transaksi->status === 'DP Dibayar') {
                    $judulNotif = 'DP Booking Dikonfirmasi';
                    $isiNotif = 'DP booking ' . $transaksi->no_invoice . ' telah diverifikasi. Sisa tagihan dibayar di salon saat treatment selesai.';
                } else {
                    $judulNotif = 'Pembayaran Diterima';
                    $isiNotif = 'Pesanan ' . $transaksi->no_invoice . ' telah diverifikasi dan berhasil.';
                }
                buatNotif($transaksi->id_user, $judulNotif, $isiNotif, 'Transaksi', $targetNotif);
            }

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $judulAdmin = $transaksi->status === 'DP Dibayar' ? 'Booking DP Dikonfirmasi' : 'Pesanan Lunas';
                $isiAdmin = $transaksi->status === 'DP Dibayar'
                    ? 'DP booking ' . $transaksi->no_invoice . ' oleh ' . ($transaksi->user->nama ?? '') . ' dikonfirmasi.'
                    : 'Pesanan ' . $transaksi->no_invoice . ' oleh ' . ($transaksi->user->nama ?? '') . ' dikonfirmasi lunas.';
                buatNotif($admin->id, $judulAdmin, $isiAdmin, 'Transaksi', url('/admin/dashboard'));
            }

            $pesanKonfirmasi = $transaksi->status === 'DP Dibayar'
                ? 'DP booking ' . $transaksi->no_invoice . ' dikonfirmasi.'
                : 'Pesanan ' . $transaksi->no_invoice . ' dikonfirmasi lunas.';

            return back()->with('message', $pesanKonfirmasi);
        }

        $saldoTerpakai = (float) ($transaksi->saldo_terpakai ?? 0);
        if ($saldoTerpakai > 0 && $transaksi->id_pelanggan) {
            (new SaldoAkunService())->kreditRefund(
                $transaksi->id_pelanggan,
                $saldoTerpakai,
                $transaksi->id_transaksi,
                'Pengembalian saldo — pembayaran ditolak kasir (INV ' . $transaksi->no_invoice . ')'
            );
        }

        $transaksi->update(['status' => 'Gagal']);
        $transaksi->pembayaran?->update(['status' => 'Gagal']);

        if ($transaksi->id_booking) {
            Booking::where('id_booking', $transaksi->id_booking)->update(['status_pembayaran' => 'belum']);
        }

        $pesanTolak = 'Pembayaran pesanan ' . $transaksi->no_invoice . ' ditolak oleh kasir.';
        if ($saldoTerpakai > 0) {
            $pesanTolak .= ' Saldo akun Rp ' . number_format($saldoTerpakai, 0, ',', '.') . ' telah dikembalikan ke saldo Anda.';
        }
        buatNotif($transaksi->id_user, 'Pembayaran Ditolak', $pesanTolak, 'Transaksi', route('pelanggan.pesanan.show', $transaksi->id_transaksi));

        return back()->with('message', 'Pesanan ' . $transaksi->no_invoice . ' ditolak.');
    }
}
