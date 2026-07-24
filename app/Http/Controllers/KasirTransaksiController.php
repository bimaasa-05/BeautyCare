<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Produk;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class KasirTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;
        $userId = auth()->id();

        $TotalTransaksi = Transaksi::where('id_user', $userId)->count();
        $transaksi = Transaksi::with('pelanggan')
            ->where('id_user', $userId)
            ->when($search, function ($query, $search) {
                return $query->where('no_invoice', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })->orderBy('id_transaksi', 'desc')->paginate(10);

        return view('kasir.transaksi.index', compact('transaksi', 'TotalTransaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        $produk = Produk::where('status', 1)->get();

        $bankTujuan = [
            'BRI' => '10101010',
            'BCA' => '20202020',
            'Mandiri' => '30303030',
            'BNI' => '40404040',
            'BSI' => '50505050',
        ];

        return view('kasir.transaksi.create', compact('pelanggan', 'layanan', 'produk', 'bankTujuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_byr' => 'required|in:Tunai,Transfer,Debit,E-Wallet',
            'dibayar' => 'required|numeric|min:0',
            'kembali' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'atas_nama' => 'nullable|string|max:100',
            'dari_rekening' => 'nullable|string|max:50',
            'ke_rekening' => 'nullable|string|max:50',
            'bank_asal' => 'nullable|string|max:50',
            'bank_tujuan' => 'nullable|string|max:50',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|string|max:50',
            'status' => 'nullable|in:Lunas,Proses,Batal,Pending',
        ]);

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $status = $request->status;
        if (!$status) {
            $status = in_array($request->metode_byr, ['Tunai', 'E-Wallet']) ? 'Lunas' : 'Pending';
        }

        $data = [
            'id_booking' => null,
            'id_pelanggan' => $request->id_pelanggan,
            'id_user' => auth()->user()->id,
            'no_invoice' => $no_invoice,
            'tanggal' => $request->tanggal,
            'subtotal' => $request->subtotal,
            'diskon' => $request->diskon ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $request->total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $request->dibayar,
            'kembali' => $request->kembali,
            'catatan' => $request->catatan ?? '',
            'status' => $status,
            'atas_nama' => $request->atas_nama,
            'dari_rekening' => $request->dari_rekening,
            'ke_rekening' => $request->ke_rekening,
            'bank_asal' => $request->bank_asal ?? $request->ewallet_type,
            'bank_tujuan' => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ];

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        $transaksi = Transaksi::create($data);

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
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $produk->decrement('stok', $item['qty'] ?? 1);
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
        $userId = auth()->id();

        $totalInvoice = Transaksi::where('id_user', $userId)->count();
        $totalLunas = Transaksi::where('id_user', $userId)->where('status', 'Lunas')->count();
        $totalPending = Transaksi::where('id_user', $userId)->where('status', 'Pending')->count();

        $invoices = Transaksi::with('pelanggan')
            ->where('id_user', $userId)
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
        $transaksi = Transaksi::with('pelanggan', 'detail', 'user')->findOrFail($id);
        return view('kasir.invoice.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        $produk = Produk::where('status', 1)->get();

        $bankTujuan = [
            'BRI' => '10101010',
            'BCA' => '20202020',
            'Mandiri' => '30303030',
            'BNI' => '40404040',
            'BSI' => '50505050',
        ];

        return view('kasir.transaksi.edit', compact('transaksi', 'pelanggan', 'layanan', 'produk', 'bankTujuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_byr' => 'required|in:Tunai,Transfer,Debit,E-Wallet',
            'dibayar' => 'required|numeric|min:0',
            'kembali' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'atas_nama' => 'nullable|string|max:100',
            'dari_rekening' => 'nullable|string|max:50',
            'ke_rekening' => 'nullable|string|max:50',
            'bank_asal' => 'nullable|string|max:50',
            'bank_tujuan' => 'nullable|string|max:50',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|string|max:50',
            'status' => 'nullable|in:Lunas,Proses,Batal,Pending',
        ]);

        $status = $request->status;
        if (!$status) {
            $status = in_array($request->metode_byr, ['Tunai', 'E-Wallet']) ? 'Lunas' : 'Pending';
        }

        $data = [
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal' => $request->tanggal,
            'subtotal' => $request->subtotal,
            'diskon' => $request->diskon ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $request->total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $request->dibayar,
            'kembali' => $request->kembali,
            'catatan' => $request->catatan ?? '',
            'status' => $status,
            'atas_nama' => $request->atas_nama,
            'dari_rekening' => $request->dari_rekening,
            'ke_rekening' => $request->ke_rekening,
            'bank_asal' => $request->bank_asal ?? $request->ewallet_type,
            'bank_tujuan' => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
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

        Transaksi::where('id_transaksi', $id)->update($data);

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah transaksi ' . $transaksiLama->no_invoice, 'Transaksi', $id, $dataLama, $data);

        if ($request->has('items') && is_array($request->items)) {
            $oldDetails = DetailTransaksi::where('id_transaksi', $id)->get();
            foreach ($oldDetails as $old) {
                if ($old->jenis === 'Produk') {
                    $produk = Produk::find($old->id_item);
                    if ($produk) {
                        $produk->increment('stok', $old->qty);
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
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $produk->decrement('stok', $item['qty'] ?? 1);
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
                    $produk->increment('stok', $detail->qty);
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
