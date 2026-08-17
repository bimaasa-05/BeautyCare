<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\FavoritProduk;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Rating;
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

        $ratingSummaries = Rating::where('tipe', Rating::TIPE_PRODUK)
            ->where('status', 'aktif')
            ->selectRaw('id_target, AVG(bintang) as rata, COUNT(*) as jumlah')
            ->groupBy('id_target')
            ->get()
            ->keyBy('id_target');

        $produks->each(function ($produk) use ($favoritCounts, $beliCounts, $ratingSummaries) {
            $produk->favorit_count = (int) ($favoritCounts[$produk->id_produk] ?? 0);
            $produk->beli_count = (int) ($beliCounts[$produk->id_produk] ?? 0);
            $produk->rating_rata = round((float) ($ratingSummaries[$produk->id_produk]->rata ?? 0), 1);
            $produk->rating_jumlah = (int) ($ratingSummaries[$produk->id_produk]->jumlah ?? 0);
        });

        return view('pelanggan.produk.index', compact('produks', 'favoritProdukIds'));
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')
            ->where('status', 'Tersedia')
            ->findOrFail($id);

        $favoritCount = FavoritProduk::where('id_produk', $produk->id_produk)->count();
        $isFavorit = FavoritProduk::where('id_user', auth()->id())
            ->where('id_produk', $produk->id_produk)
            ->exists();

        $beliCount = DetailTransaksi::join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('detail_transaksi.jenis', 'Produk')
            ->where('detail_transaksi.id_item', $produk->id_produk)
            ->where('transaksi.status', 'Lunas')
            ->sum('detail_transaksi.qty');

        $produkLainnya = Produk::with('kategori')
            ->where('status', 'Tersedia')
            ->where('id_produk', '!=', $produk->id_produk)
            ->where('id_kategori_produk', $produk->id_kategori_produk)
            ->limit(4)
            ->get();

        $ringkasan = Rating::ringkasan(Rating::TIPE_PRODUK, $produk->id_produk);
        $ulasans = Rating::terbaru(Rating::TIPE_PRODUK, $produk->id_produk, 20);

        $bisaRating = false;
        $ratingSaya = null;
        $pelanggan = Pelanggan::dariUser(auth()->user());
        if ($pelanggan) {
            $bisaRating = Rating::bisaRatingProduk($pelanggan->id_pelanggan, $produk->id_produk);
        }
        $ratingSaya = Rating::ratingSaya(auth()->id(), Rating::TIPE_PRODUK, $produk->id_produk);

        return view('pelanggan.produk.detail', compact(
            'produk',
            'favoritCount',
            'isFavorit',
            'beliCount',
            'produkLainnya',
            'ringkasan',
            'ulasans',
            'bisaRating',
            'ratingSaya'
        ));
    }
}
