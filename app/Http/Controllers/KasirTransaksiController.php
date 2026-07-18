<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Generator;

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
        $pelanggan = Pelanggan::all();
        $qrisGenerator = new Generator();
        $qrisCode = $qrisGenerator->size(170)->color(51, 51, 51)->margin(5)->generate('BeautyCare - Pembayaran QRIS');
        return view('kasir.transaksi.create', compact('pelanggan', 'qrisCode'));
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
            'metode_byr' => 'required|in:Tunai,Qris,Transfer,Debit,Kredit,E-Wallet',
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
        ]);

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $dibayar = $request->metode_byr === 'Qris' ? $request->total : $request->dibayar;
        $kembali = $request->metode_byr === 'Qris' ? 0 : $request->kembali;

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
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'catatan' => $request->catatan ?? '',
            'status' => in_array($request->metode_byr, ['Tunai', 'Qris', 'E-Wallet']) ? 1 : 0,
            'atas_nama' => $request->atas_nama,
            'dari_rekening' => $request->dari_rekening,
            'ke_rekening' => $request->ke_rekening,
            'bank_asal' => $request->bank_asal,
            'bank_tujuan' => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ];

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        Transaksi::create($data);

        $msg = $request->metode_byr === 'Tunai'
            ? 'Pembayaran tunai berhasil! Transaksi selesai.'
            : ($request->metode_byr === 'Qris'
                ? 'Pembayaran QRIS berhasil! Transaksi selesai.'
                : ($request->metode_byr === 'E-Wallet'
                    ? 'Pembayaran E-Wallet berhasil! Transaksi selesai.'
                    : 'Pembayaran berhasil dicatat! Menunggu konfirmasi.'));

        return redirect('kasir/transaksi')->with('message', $msg);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail')->findOrFail($id);
        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggan = Pelanggan::all();
        $qrisGenerator = new Generator();
        $qrisCode = $qrisGenerator->size(170)->color(51, 51, 51)->margin(1)->generate('BeautyCare - Pembayaran QRIS');
        return view('kasir.transaksi.edit', compact('transaksi', 'pelanggan', 'qrisCode'));
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
            'metode_byr' => 'required|in:Tunai,Qris,Transfer,Debit,Kredit,E-Wallet',
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
        ]);

        $dibayar = $request->metode_byr === 'Qris' ? $request->total : $request->dibayar;
        $kembali = $request->metode_byr === 'Qris' ? 0 : $request->kembali;

        $data = [
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal' => $request->tanggal,
            'subtotal' => $request->subtotal,
            'diskon' => $request->diskon ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $request->total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'catatan' => $request->catatan ?? '',
            'atas_nama' => $request->atas_nama,
            'dari_rekening' => $request->dari_rekening,
            'ke_rekening' => $request->ke_rekening,
            'bank_asal' => $request->bank_asal,
            'bank_tujuan' => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ];

        if (in_array($request->metode_byr, ['Tunai', 'Qris', 'E-Wallet'])) {
            $data['status'] = 1;
        }

        if ($request->hasFile('bukti_bayar')) {
            $transaksi = Transaksi::findOrFail($id);
            if ($transaksi->bukti_bayar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
            }
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        Transaksi::where('id_transaksi', $id)->update($data);

        return redirect('kasir/transaksi')->with('message', 'Transaksi berhasil diperbarui');
    }

    public function qrisCode()
    {
        $qrisGenerator = new Generator();
        $random = Str::random(8);
        $qrisCode = $qrisGenerator->size(170)->color(51, 51, 51)->margin(5)->generate('BC|' . $random . '|' . date('YmdHis'));
        return response()->json(['html' => $qrisCode]);
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
