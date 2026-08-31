<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pelanggan;
use App\Models\Rating;

class PelangganRatingController extends Controller
{
    /**
     * Halaman khusus memberi rating layanan dari booking yang sudah selesai.
     */
    public function layanan($id)
    {
        $pelanggan = Pelanggan::dariUser(auth()->user());
        if (!$pelanggan) {
            return redirect()->route('pelanggan.booking')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $booking = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_booking', (int) $id)
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('status', 'selesai')
            ->first();

        if (!$booking) {
            return redirect()->route('pelanggan.booking')->with('error', 'Booking tidak ditemukan atau belum selesai, Anda belum dapat memberi rating.');
        }

        $detailLayanan = $booking->detail
            ->filter(fn($d) => $d->layanan)
            ->values();

        $ringkasans = [];
        $ulasans = [];
        $ratingSaya = [];
        $bisaRating = [];

        foreach ($detailLayanan as $detail) {
            $idLayanan = $detail->layanan->id_layanan;
            $ringkasans[$idLayanan] = Rating::ringkasan(Rating::TIPE_LAYANAN, $idLayanan);
            $ulasans[$idLayanan] = Rating::terbaru(Rating::TIPE_LAYANAN, $idLayanan, 20);
            $ratingSaya[$idLayanan] = Rating::ratingSaya(auth()->id(), Rating::TIPE_LAYANAN, $idLayanan);
            $bisaRating[$idLayanan] = Rating::bisaRatingLayanan($pelanggan->id_pelanggan, $idLayanan);
        }

        return view('pelanggan.rating.layanan', compact(
            'booking',
            'detailLayanan',
            'ringkasans',
            'ulasans',
            'ratingSaya',
            'bisaRating'
        ));
    }
}
