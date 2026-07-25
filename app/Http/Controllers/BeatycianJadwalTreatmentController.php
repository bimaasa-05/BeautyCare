<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BeatycianJadwalTreatmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterStatus = $request->input('filter_status');

        $user = auth()->user();
        $id_karyawan = $user->id;

        $query = Booking::with(['detail.layanan', 'karyawan', 'pelanggan'])
            ->where('id_karyawan', $id_karyawan);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($q2) use ($search) {
                      $q2->where('nm_pelanggan', 'like', "%{$search}%");
                  });
            });
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $jadwal = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)->withQueryString();

        $total_jadwal = Booking::where('id_karyawan', $id_karyawan)->count();
        $dikonfirmasi = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dikonfirmasi')->count();
        $diproses     = Booking::where('id_karyawan', $id_karyawan)->where('status', 'diproses')->count();
        $selesai      = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')->count();
        $dibatalkan   = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dibatalkan')->count();

        return view('beautycian.jadwal-treatment.index', compact(
            'jadwal', 'search',
            'total_jadwal', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'
        ));
    }

    public function updateStatus(Request $request)
    {
        $request->validate(['id_booking' => 'required|exists:booking,id_booking']);

        $booking = Booking::where('id_booking', $request->id_booking)
            ->where('id_karyawan', auth()->id())
            ->firstOrFail();

        if ($booking->status === 'dikonfirmasi') {
            $booking->update(['status' => 'diproses']);
            return back()->with('success', 'Treatment telah dimulai!');
        }

        if ($booking->status === 'diproses') {
            $booking->update(['status' => 'selesai']);
            return back()->with('success', 'Treatment telah selesai!');
        }

        return back()->with('error', 'Status tidak valid untuk diubah.');
    }
}
