<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminReservasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;

        $TotalReservasi = Booking::count();
        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')
            ->when($search, function ($query, $search) {
                return $query->where('tanggal', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q) use ($search) {
                        $q->where('nm_pelanggan', 'like', "%{$search}%");
                    });
            })
            ->when($request->filled('id_karyawan'), function ($query) use ($request) {
                return $query->where('id_karyawan', $request->id_karyawan);
            })
            ->orderBy('id_booking', 'desc')->paginate(10);

        return view('admin.reservasi.index', compact('reservasi', 'TotalReservasi'));
    }

    public function show($id)
    {
        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')->findOrFail($id);
        return view('admin.reservasi.show', compact('reservasi'));
    }
}
