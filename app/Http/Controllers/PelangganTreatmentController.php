<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PelangganTreatmentController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $status = request('status');

        $query = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $userId);

        if ($status && in_array($status, ['menunggu', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'])) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('id_booking', 'desc')->get();

        return view('pelanggan.treatment.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan', 'transaksi', 'pelanggan', 'riwayatTreatment'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', auth()->id())
            ->firstOrFail();

        return view('pelanggan.treatment.detail', compact('booking'));
    }
}
