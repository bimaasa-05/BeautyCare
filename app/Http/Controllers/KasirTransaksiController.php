<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class KasirTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;

        $TotalTransaksi = Transaksi::count();
        $transaksi = Transaksi::with('pelanggan')
            ->when($search, function ($query, $search) {
                return $query->where('no_invoice', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })->orderBy('id_transaksi', 'desc')->paginate(10);

        return view('kasir.transaksi.index', compact('transaksi', 'TotalTransaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan = Layanan::where('status', 1)->get();
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
        ]);

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $data = [
            'id_booking' => $lastId,
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
            'status' => in_array($request->metode_byr, ['Tunai', 'E-Wallet']) ? 'Lunas' : 'Pending',
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

        $totalInvoice = Transaksi::count();
        $totalLunas = Transaksi::where('status', 'Lunas')->count();
        $totalPending = Transaksi::where('status', 'Pending')->count();

        $invoices = Transaksi::with('pelanggan')
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
        $layanan = Layanan::where('status', 1)->get();
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
        ]);

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
            'atas_nama' => $request->atas_nama,
            'dari_rekening' => $request->dari_rekening,
            'ke_rekening' => $request->ke_rekening,
            'bank_asal' => $request->bank_asal ?? $request->ewallet_type,
            'bank_tujuan' => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ];

        if (in_array($request->metode_byr, ['Tunai', 'E-Wallet'])) {
            $data['status'] = 'Lunas';
        }

        if ($request->hasFile('bukti_bayar')) {
            $transaksi = Transaksi::findOrFail($id);
            if ($transaksi->bukti_bayar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
            }
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        Transaksi::where('id_transaksi', $id)->update($data);

        if ($request->has('items') && is_array($request->items)) {
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
                }
            }
        }

        return redirect('kasir/transaksi')->with('message', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->bukti_bayar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
        }
        $transaksi->delete();
        return redirect('/kasir/transaksi')->with('message', 'Transaksi berhasil dihapus');
    }
}
