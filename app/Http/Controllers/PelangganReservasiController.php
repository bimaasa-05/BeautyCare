<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PelangganReservasiController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $status = $request->status;

        $query = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $userId);

        if ($status && in_array($status, ['menunggu', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'])) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('id_booking', 'desc')->get();

        $search = $request->search;
        if ($search) {
            $bookings = $bookings->filter(function ($b) use ($search) {
                $keyword = strtolower($search);
                $idBooking = '#' . str_pad($b->id_booking, 3, '0', STR_PAD_LEFT);
                $namaKaryawan = $b->karyawan ? strtolower($b->karyawan->nama) : '';
                $nmLayanan = $b->detail->filter(fn($d) => $d->layanan)->pluck('layanan.nm_layanan')->implode(' ');

                return str_contains(strtolower($b->status), $keyword)
                    || str_contains(strtolower($b->tanggal), $keyword)
                    || str_contains(strtolower($b->jam), $keyword)
                    || str_contains(strtolower($b->catatan), $keyword)
                    || str_contains($namaKaryawan, $keyword)
                    || str_contains($nmLayanan, $keyword)
                    || str_contains(strtolower($idBooking), $keyword);
            });
        }

        return view('pelanggan.reservasi.index', compact('bookings', 'search'));
    }
}
