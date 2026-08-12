<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Karyawan;
use App\Models\Bank;
use App\Models\Pembayaran;
use App\Helpers\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KasirTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;
        $status = $request->status;
        $metode = $request->metode;
        $userId = auth()->id();

        $TotalTransaksi = Transaksi::where('id_kasir', $userId)->count();
        $transaksi = Transaksi::with('pelanggan')
            ->where('id_kasir', $userId)
            ->when($search, function ($query, $search) {
                return $query->where('no_invoice', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($metode, function ($query, $metode) {
                if ($metode === 'non-tunai') {
                    return $query->where('metode_byr', '!=', 'Tunai');
                }
                return $query->where('metode_byr', $metode);
            })
            ->orderBy('id_transaksi', 'desc')->paginate(10);

        return view('kasir.transaksi.index', compact('transaksi', 'TotalTransaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        $produk = Produk::where('status', 'Tersedia')->get();
        $karyawan = Karyawan::with('user')->whereHas('user', fn ($q) => $q->where('role', 'beautycian'))->get();
        $banks = Bank::active()->transfer()->get(['id', 'nama_bank', 'no_rekening', 'kode_bank', 'logo', 'atas_nama']);
        $ewallets = Bank::active()->ewallet()->get(['id', 'nama_bank', 'nomor_telepon', 'atas_nama']);

        return view('kasir.transaksi.create', compact('pelanggan', 'layanan', 'produk', 'karyawan', 'banks', 'ewallets'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'bank_id' => $request->input('metode_byr') !== 'Transfer' ? null : $request->input('bank_id'),
            'ewallet_type' => $request->input('metode_byr') !== 'E-Wallet' ? null : $request->input('ewallet_type'),
        ]);

        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_byr' => 'required|in:Tunai,Transfer,E-Wallet',
            'dibayar' => 'required|numeric|min:0',
            'kembali' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|required_if:metode_byr,E-Wallet|string|max:50',
            'bank_id' => 'nullable|required_if:metode_byr,Transfer|integer|exists:banks,id',
            'status' => 'nullable|in:Lunas,Proses,Batal,Pending',
        ]);

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $status = $request->status;
        if (!$status) {
            $status = in_array($request->metode_byr, ['E-Wallet', 'Tunai']) ? 'Lunas' : 'Proses';
        }

        $total = (float) $request->total;
        $dibayar = (float) $request->dibayar;
        if ($request->metode_byr === 'Tunai' && $dibayar <= 0) {
            $dibayar = max(0, $total);
        }
        $kembali = max(0, $dibayar - $total);

        $data = [
            'id_booking' => null,
            'id_pelanggan' => $request->id_pelanggan,
            'id_user' => auth()->user()->id,
            'id_kasir' => auth()->user()->id,
            'jenis_transaksi' => 'Penjualan',
            'no_invoice' => $no_invoice,
            'tanggal' => $request->tanggal,
            'subtotal' => $request->subtotal,
            'diskon' => $request->diskon ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'catatan' => $request->catatan ?? '',
            'status' => $status,
            'no_referensi' => $request->no_referensi,
            'ewallet_type' => $request->ewallet_type,
        ];

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        $transaksi = Transaksi::create($data);

        // Get bank for Transfer
        $bank = null;
        if ($request->metode_byr === 'Transfer' && $request->bank_id) {
            $bank = Bank::find($request->bank_id);
        }

        // Create Pembayaran record for non-cash payments
        if ($request->metode_byr !== 'Tunai') {
            $pembayaranData = [
                'id_transaksi' => $transaksi->id_transaksi,
                'metode' => $request->metode_byr,
                'provider' => $request->metode_byr === 'E-Wallet' ? $request->ewallet_type : $request->metode_byr,
                'kode_pembayaran' => $this->generateKodePembayaran($request->metode_byr, $transaksi->id_transaksi, $bank),
                'nominal' => $total,
                'status' => $status === 'Lunas' ? 'Lunas' : 'Menunggu',
                'expires_at' => $request->metode_byr === 'QRIS'
                    ? now()->addMinutes(3)
                    : now()->addMinutes(15),
                'paid_at' => $status === 'Lunas' ? now() : null,
            ];

            if ($bank) {
                $pembayaranData['bank_id'] = $bank->id;
                $pembayaranData['no_rekening_tujuan'] = $bank->no_rekening;
                $pembayaranData['atas_nama_tujuan'] = $bank->atas_nama;
            }

            Pembayaran::create($pembayaranData);
        }

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan transaksi ' . $no_invoice, 'Transaksi', $transaksi->id_transaksi);

        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                if (!empty($item['id_item'])) {
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'jenis' => $item['jenis'] ?? 'Layanan',
                        'id_item' => $item['id_item'],
                        'nm_item' => $item['nm_item'] ?? '',
                        'qty' => $item['qty'] ?? 1,
                        'harga' => $item['harga'] ?? 0,
                        'diskon' => 0,
                        'subtotal' => $item['subtotal'] ?? 0,
                        'jam' => $item['jam'] ?? null,
                        'id_karyawan' => $item['id_karyawan'] ?? null,
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $stokLama = $produk->stok;
                            $produk->decrement('stok', $item['qty'] ?? 1);
                            catatStok($produk->id_produk, 'Keluar', $item['qty'] ?? 1, $stokLama, $produk->stok, 'Penjualan ' . $no_invoice, null, $transaksi->id_transaksi, 'Transaksi');
                        }
                    }
                }
            }
        }

        buatNotif(auth()->user()->id, 'Transaksi Baru', 'Transaksi ' . $no_invoice . ' berhasil dicatat', 'Transaksi', route('kasir.transaksi.show', $transaksi->id_transaksi));

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Transaksi Baru', 'Transaksi ' . $no_invoice . ' oleh ' . auth()->user()->nama, 'Transaksi', url('/admin/dashboard'));
        }

        $msg = in_array($request->metode_byr, ['Tunai', 'E-Wallet'])
            ? 'Pembayaran berhasil! Transaksi selesai.'
            : 'Pembayaran berhasil dicatat! Menunggu konfirmasi.';

        return redirect('kasir/transaksi')->with('message', $msg);
    }

    private function generateKodePembayaran($metode, $idTransaksi, $bank = null)
    {
        $digits = str_pad((string) $idTransaksi, 8, '0', STR_PAD_LEFT);

        if ($metode === 'Transfer') {
            if ($bank && $bank->kode_bank) {
                return $bank->kode_bank . $digits;
            }
            return '8802' . $digits; // fallback
        }
        if ($metode === 'QRIS') {
            return 'QR-' . $digits;
        }

        return 'EP-' . $digits;
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail')->findOrFail($id);
        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function invoiceIndex(Request $request)
    {
        $search = $request->keyword;
        $dari = $request->dari;
        $sampai = $request->sampai;
        $jenis = $request->jenis;
        $userId = auth()->id();

        $totalInvoice = Transaksi::where('id_kasir', $userId)
            ->when($jenis, fn($q, $j) => $q->where('jenis_transaksi', $j))
            ->count();
        $totalLunas = Transaksi::where('id_kasir', $userId)
            ->when($jenis, fn($q, $j) => $q->where('jenis_transaksi', $j))
            ->where('status', 'Lunas')
            ->count();
        $totalPending = Transaksi::where('id_kasir', $userId)
            ->when($jenis, fn($q, $j) => $q->where('jenis_transaksi', $j))
            ->where('status', 'Pending')
            ->count();

        $invoices = Transaksi::with('pelanggan')
            ->where('id_kasir', $userId)
            ->when($jenis, fn($q, $j) => $q->where('jenis_transaksi', $j))
            ->when($search, function ($query, $search) {
                return $query->where('no_invoice', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q) use ($search) {
                        $q->where('nm_pelanggan', 'like', "%{$search}%");
                    });
            })
            ->when($dari, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($sampai, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_transaksi', 'desc')
            ->paginate(10);

        return view('kasir.invoice.index', compact('invoices', 'totalInvoice', 'totalLunas', 'totalPending'));
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail', 'user', 'kasir')->findOrFail($id);
        return view('kasir.invoice.show', compact('transaksi'));
    }

    public function invoicePdf($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail', 'user', 'kasir')->findOrFail($id);
        $pdf = Pdf::loadView('kasir.invoice.pdf', compact('transaksi'));
        return $pdf->download('Invoice-' . $transaksi->no_invoice . '.pdf');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail', 'user', 'kasir')->findOrFail($id);
        return view('kasir.struk.index', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        $produk = Produk::where('status', 1)->get();
        $karyawan = Karyawan::with('user')->whereHas('user', fn ($q) => $q->where('role', 'beautycian'))->get();
        $banks = Bank::active()->transfer()->get(['id', 'nama_bank', 'no_rekening', 'kode_bank', 'logo', 'atas_nama']);
        $ewallets = Bank::active()->ewallet()->get(['id', 'nama_bank', 'nomor_telepon', 'atas_nama']);

        return view('kasir.transaksi.edit', compact('transaksi', 'pelanggan', 'layanan', 'produk', 'karyawan', 'banks', 'ewallets'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'bank_id' => $request->input('metode_byr') !== 'Transfer' ? null : $request->input('bank_id'),
            'ewallet_type' => $request->input('metode_byr') !== 'E-Wallet' ? null : $request->input('ewallet_type'),
        ]);

        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_byr' => 'required|in:Tunai,Transfer,E-Wallet',
            'dibayar' => 'required|numeric|min:0',
            'kembali' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|required_if:metode_byr,E-Wallet|string|max:50',
            'bank_id' => 'nullable|required_if:metode_byr,Transfer|integer|exists:banks,id',
            'status' => 'nullable|in:Lunas,Proses,Batal,Pending',
        ]);

        $status = $request->status;
        if (!$status) {
            $status = in_array($request->metode_byr, ['E-Wallet', 'Tunai']) ? 'Lunas' : 'Proses';
        }

        $total = (float) $request->total;
        $dibayar = (float) $request->dibayar;
        if ($request->metode_byr === 'Tunai' && $dibayar <= 0) {
            $dibayar = max(0, $total);
        }
        $kembali = max(0, $dibayar - $total);

        $data = [
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal' => $request->tanggal,
            'subtotal' => $request->subtotal,
            'diskon' => $request->diskon ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'catatan' => $request->catatan ?? '',
            'status' => $status,
            'no_referensi' => $request->no_referensi,
            'ewallet_type' => $request->ewallet_type,
        ];

        if ($request->hasFile('bukti_bayar')) {
            $transaksi = Transaksi::findOrFail($id);
            if ($transaksi->bukti_bayar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
            }
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        $transaksiLama = Transaksi::findOrFail($id);
        $dataLama = $transaksiLama->toArray();

        if (!$transaksiLama->id_kasir) {
            $data['id_kasir'] = auth()->id();
        }

        Transaksi::where('id_transaksi', $id)->update($data);

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah transaksi ' . $transaksiLama->no_invoice, 'Transaksi', $id, $dataLama, $data);

        if ($request->has('items') && is_array($request->items)) {
            $oldDetails = DetailTransaksi::where('id_transaksi', $id)->get();
            foreach ($oldDetails as $old) {
                if ($old->jenis === 'Produk') {
                    $produk = Produk::find($old->id_item);
                    if ($produk) {
                        $stokLama = $produk->stok;
                        $produk->increment('stok', $old->qty);
                        catatStok($produk->id_produk, 'Masuk', $old->qty, $stokLama, $produk->stok, 'Pengembalian stok dari perubahan transaksi', null, $id, 'Transaksi');
                    }
                }
            }

            DetailTransaksi::where('id_transaksi', $id)->delete();
            foreach ($request->items as $item) {
                if (!empty($item['id_item'])) {
                    DetailTransaksi::create([
                        'id_transaksi' => $id,
                        'jenis' => $item['jenis'] ?? 'Layanan',
                        'id_item' => $item['id_item'],
                        'nm_item' => $item['nm_item'] ?? '',
                        'qty' => $item['qty'] ?? 1,
                        'harga' => $item['harga'] ?? 0,
                        'diskon' => 0,
                        'subtotal' => $item['subtotal'] ?? 0,
                        'jam' => $item['jam'] ?? null,
                        'id_karyawan' => $item['id_karyawan'] ?? null,
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $stokLama = $produk->stok;
                            $produk->decrement('stok', $item['qty'] ?? 1);
                            catatStok($produk->id_produk, 'Keluar', $item['qty'] ?? 1, $stokLama, $produk->stok, 'Penjualan pada perubahan transaksi', null, $id, 'Transaksi');
                        }
                    }
                }
            }
        }

        return redirect('kasir/transaksi')->with('message', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);

        foreach ($transaksi->detail as $detail) {
            if ($detail->jenis === 'Produk') {
                $produk = Produk::find($detail->id_item);
                if ($produk) {
                    $stokLama = $produk->stok;
                    $produk->increment('stok', $detail->qty);
                    catatStok($produk->id_produk, 'Masuk', $detail->qty, $stokLama, $produk->stok, 'Pengembalian stok dari penghapusan transaksi', null, $transaksi->id_transaksi, 'Transaksi');
                }
            }
        }

        if ($transaksi->bukti_bayar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
        }
        $transaksi->delete();
        return redirect('/kasir/transaksi')->with('message', 'Transaksi berhasil dihapus');
    }
}
