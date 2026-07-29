<?php

namespace App\Http\Controllers;

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

        return view('pelanggan.produk.index', compact('produks'));
    }
}
