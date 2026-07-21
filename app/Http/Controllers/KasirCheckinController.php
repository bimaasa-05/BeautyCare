<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class KasirCheckinController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $search = $request->keyword;

        $TotalHariIni = Booking::where('tanggal', $today)->count();
        $TotalCheckIn = Booking::where('tanggal', $today)->where('status', 'diproses')->count();
        $TotalMenunggu = Booking::where('tanggal', $today)->whereIn('status', ['menunggu', 'dikonfirmasi'])->count();

        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')
            ->where('tanggal', $today)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('pelanggan', function ($sub) use ($search) {
                        $sub->where('nm_pelanggan', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    })->orWhere('id_booking', 'like', "%{$search}%");
                });
            })
            ->orderBy('id_booking', 'desc')
            ->paginate(10);

        $jamSekarang = date('H:i');

        return view('kasir.checkin.index', compact(
            'reservasi', 'TotalHariIni', 'TotalCheckIn', 'TotalMenunggu', 'jamSekarang'
        ));
    }

    public function checkIn($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'diproses']);

        buatNotif(auth()->id(), 'Check In Berhasil', 'Pelanggan ' . ($booking->pelanggan->nm_pelanggan ?? '-') . ' telah check in', 'Booking', route('kasir.checkin.index'));

        return redirect()->route('kasir.checkin.index')
            ->with('success', 'Pelanggan berhasil check in');
    }

    public function undoCheckIn($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'dikonfirmasi']);

        buatNotif(auth()->id(), 'Check In Dibatalkan', 'Check in untuk ' . ($booking->pelanggan->nm_pelanggan ?? '-') . ' dibatalkan', 'Booking', route('kasir.checkin.index'));

        return redirect()->route('kasir.checkin.index')
            ->with('success', 'Check in berhasil dibatalkan');
    }
}
