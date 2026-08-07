<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pelanggan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PelangganTreatmentController extends Controller
{
    public function index()
    {
        $idPelanggan = $this->resolveIdPelanggan();
        $status = request('status');

        $query = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $idPelanggan)
            ->whereIn('status', ['selesai', 'dibatalkan']);

        if ($status && in_array($status, ['selesai', 'dibatalkan'])) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('id_booking', 'desc')->get();

        return view('pelanggan.treatment.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan.karyawan', 'transaksi', 'pelanggan', 'riwayatTreatment'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->firstOrFail();

        return view('pelanggan.treatment.detail', compact('booking'));
    }

    public function pdf($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan', 'transaksi', 'pelanggan', 'riwayatTreatment'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->firstOrFail();

        $pdf = Pdf::loadView('pelanggan.treatment.pdf', compact('booking'));
        return $pdf->download('Detail-Treatment-BK' . str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) . '.pdf');
    }

    private function resolveIdPelanggan()
    {
        $user = auth()->user();
        if ($user->dataPelanggan) {
            return $user->dataPelanggan->id_pelanggan;
        }
        return Pelanggan::firstOrCreate(
            ['id_user' => $user->id],
            ['nm_pelanggan' => $user->nama, 'email' => $user->email, 'no_hp' => $user->no_hp ?? '']
        )->id_pelanggan;
    }
}
