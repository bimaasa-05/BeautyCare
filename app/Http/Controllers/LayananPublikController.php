<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Rating;
use Illuminate\Http\Request;

class LayananPublikController extends Controller
{
    public function show($id)
    {
        $layanan = Layanan::with('kategori')
            ->where('status', 'Tersedia')
            ->findOrFail($id);

        $ringkasan = Rating::ringkasan(Rating::TIPE_LAYANAN, $layanan->id_layanan);
        $ulasans = Rating::terbaru(Rating::TIPE_LAYANAN, $layanan->id_layanan, 20);

        $layananLain = Layanan::with('kategori')
            ->where('status', 'Tersedia')
            ->where('id_layanan', '!=', $layanan->id_layanan)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('landing.layanan-detail', compact(
            'layanan',
            'ringkasan',
            'ulasans',
            'layananLain'
        ));
    }
}