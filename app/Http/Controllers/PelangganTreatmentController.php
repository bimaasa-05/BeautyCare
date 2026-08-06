<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function pdf($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan', 'transaksi', 'pelanggan', 'riwayatTreatment'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('pelanggan.treatment.pdf', compact('booking'));
        return $pdf->download('Detail-Treatment-BK' . str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) . '.pdf');
    }

}
