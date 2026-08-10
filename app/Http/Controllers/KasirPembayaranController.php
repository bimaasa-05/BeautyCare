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
            ->whereDoesntHave('transaksi')
            ->when($search, function ($query, $search) {
                return $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nm_pelanggan', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalTagihan = Booking::whereIn('status', ['diproses', 'selesai'])->whereDoesntHave('transaksi')
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
        $booking = Booking::with(['pelanggan', 'karyawan', 'detail.layanan'])->findOrFail($id);

        if (!in_array($booking->status, ['diproses', 'selesai'])) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking belum check-in, tidak bisa diproses');
        }

        if ($booking->transaksi()->exists()) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking ini sudah memiliki pembayaran');
        }

        $banks = \App\Models\Bank::active()->transfer()->get(['id', 'nama_bank', 'no_rekening', 'kode_bank', 'logo', 'atas_nama']);
        $ewallets = \App\Models\Bank::active()->ewallet()->get(['id', 'nama_bank', 'nomor_telepon', 'atas_nama']);

        return view('kasir.pembayaran.create', compact('booking', 'banks', 'ewallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_booking' => 'required|integer|exists:booking,id_booking',
            'metode_byr' => 'required|in:Transfer,E-Wallet',
            'total' => 'required|numeric|min:0',
            'dibayar' => 'required|numeric|min:0|gte:total',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'required_if:metode_byr,E-Wallet|string|max:50',
            'bank_id' => 'required_if:metode_byr,Transfer|integer|exists:banks,id',
        ]);

        $booking = Booking::with(['pelanggan', 'detail.layanan'])->findOrFail($request->id_booking);

        if ($booking->transaksi()->exists()) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking ini sudah memiliki pembayaran');
        }

        $total = $request->total;
        $dibayar = $request->dibayar;
        $kembali = max(0, $dibayar - $total);

        $statusPembayaran = $request->metode_byr === 'E-Wallet' ? 'Lunas' : 'Proses';

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $buktiBayar = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiBayar = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        $transaksi = Transaksi::create([
            'id_booking' => $request->id_booking,
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
            'catatan' => $request->catatan ?? '',
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

        Booking::where('id_booking', $request->id_booking)->update(['status' => 'selesai', 'jam_selesai_aktual' => now()]);

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
        $transaksi = Transaksi::with(['pelanggan', 'user', 'detail'])->findOrFail($id);
        return view('kasir.pembayaran.show', compact('transaksi'));
    }

    public function pesananOnline()
    {
        $pesanan = Transaksi::with(['pelanggan', 'user', 'detail', 'pembayaran'])
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

                $transaksi->update(['status' => 'Lunas', 'id_kasir' => auth()->id()]);

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
                        $pelanggan->id_member = $tier->id_member;
                        $pelanggan->tgl_mulai_member = now();
                        $pelanggan->save();

                        ActivityLogger::log('Mengubah', $transaksi->user->nama ?? 'Pelanggan' . ' membership diaktifkan ke level ' . $tier->tingkat . ' via pembayaran ' . $transaksi->no_invoice, 'Membership', $pelanggan->id_pelanggan);

                        buatNotif($transaksi->id_user, 'Membership Aktif', 'Selamat! Membership ' . $tier->tingkat . ' Anda telah aktif. Nikmati semua keuntungannya!', 'Membership', route('pelanggan.membership'));
                    }
                }
            });

            ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mengkonfirmasi pesanan ' . $transaksi->no_invoice . ' lunas', 'Transaksi', $transaksi->id_transaksi);

            if ($transaksi->jenis_transaksi === 'TopUp Saldo') {
                $nominalTopUp = number_format((float) $transaksi->total, 0, ',', '.');
                buatNotif($transaksi->id_user, 'Top Up Berhasil', 'Top up saldo ' . $transaksi->no_invoice . ' telah terverifikasi. Saldo Anda bertambah Rp ' . $nominalTopUp . '.', 'Saldo', route('pelanggan.saldo.index'));
            } else {
                buatNotif($transaksi->id_user, 'Pembayaran Diterima', 'Pesanan ' . $transaksi->no_invoice . ' telah diverifikasi dan berhasil.', 'Transaksi', route('pelanggan.pesanan.show', $transaksi->id_transaksi));
            }

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                buatNotif($admin->id, 'Pesanan Lunas', 'Pesanan ' . $transaksi->no_invoice . ' oleh ' . ($transaksi->user->nama ?? '') . ' dikonfirmasi lunas.', 'Transaksi', url('/admin/dashboard'));
            }

            return back()->with('message', 'Pesanan ' . $transaksi->no_invoice . ' dikonfirmasi lunas.');
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

        $pesanTolak = 'Pembayaran pesanan ' . $transaksi->no_invoice . ' ditolak oleh kasir.';
        if ($saldoTerpakai > 0) {
            $pesanTolak .= ' Saldo akun Rp ' . number_format($saldoTerpakai, 0, ',', '.') . ' telah dikembalikan ke saldo Anda.';
        }
        buatNotif($transaksi->id_user, 'Pembayaran Ditolak', $pesanTolak, 'Transaksi', route('pelanggan.pesanan.show', $transaksi->id_transaksi));

        return back()->with('message', 'Pesanan ' . $transaksi->no_invoice . ' ditolak.');
    }
}
