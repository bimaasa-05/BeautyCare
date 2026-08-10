<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Transaksi::with(['detail', 'pembayaran'])
            ->where('id_user', auth()->id())
            ->where('sumber', 'online')
            ->where('jenis_transaksi', '!=', 'TopUp Saldo')
            ->orderBy('id_transaksi', 'desc')
            ->get();

        return view('pelanggan.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['detail', 'pembayaran'])->findOrFail($id);

        abort_unless((int) $transaksi->id_user === (int) auth()->id() && $transaksi->sumber === 'online', 403);

        return view('pelanggan.pesanan.show', compact('transaksi'));
    }
}
