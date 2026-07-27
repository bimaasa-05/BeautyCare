<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BeautycianLaporanReservasiController extends Controller
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

        $reservasi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)->withQueryString();

        $total_reservasi = Booking::where('id_karyawan', $id_karyawan)->count();
        $dikonfirmasi = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dikonfirmasi')->count();
        $diproses     = Booking::where('id_karyawan', $id_karyawan)->where('status', 'diproses')->count();
        $selesai      = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')->count();
        $dibatalkan   = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dibatalkan')->count();

        return view('beautycian.laporan-reservasi.index', compact(
            'reservasi', 'search',
            'total_reservasi', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'
        ));
    }

    public function show($id)
    {
        $user = auth()->user();
        $id_karyawan = $user->id;

        $reservasi = Booking::with(['detail.layanan', 'karyawan', 'pelanggan'])
            ->where('id_karyawan', $id_karyawan)
            ->findOrFail($id);

        $statusLabels = [
            'dikonfirmasi' => 'Dikonfirmasi',
            'diproses'     => 'Diproses',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
        ];

        return view('beautycian.laporan-reservasi.show', compact('reservasi', 'statusLabels'));
    }
}
