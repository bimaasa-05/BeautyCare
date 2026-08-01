<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\FavoritProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class PelangganProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')
            ->where('status', 'Tersedia')
            ->orderBy('id_produk', 'desc')
            ->get();

        $favoritCounts = FavoritProduk::selectRaw('id_produk, COUNT(*) as total')
            ->groupBy('id_produk')
            ->pluck('total', 'id_produk');

        $beliCounts = DetailTransaksi::selectRaw('detail_transaksi.id_item, COALESCE(SUM(detail_transaksi.qty), 0) as total')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('detail_transaksi.jenis', 'Produk')
            ->where('transaksi.status', 'Lunas')
            ->groupBy('detail_transaksi.id_item')
            ->pluck('total', 'id_item');

        $favoritProdukIds = FavoritProduk::where('id_user', auth()->id())
            ->pluck('id_produk')
            ->toArray();

        $produks->each(function ($produk) use ($favoritCounts, $beliCounts) {
            $produk->favorit_count = (int) ($favoritCounts[$produk->id_produk] ?? 0);
            $produk->beli_count = (int) ($beliCounts[$produk->id_produk] ?? 0);
        });

        return view('pelanggan.produk.index', compact('produks', 'favoritProdukIds'));
    }
}
