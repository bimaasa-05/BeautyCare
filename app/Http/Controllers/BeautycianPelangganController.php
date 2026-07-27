<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeautycianPelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $pelanggan = Pelanggan::with('membership')
            ->addSelect(['status' => Booking::select('status')
                ->whereColumn('booking.id_pelanggan', 'pelanggan.id_pelanggan')
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam', 'desc')
                ->limit(1)
            ])
            ->when($search, function ($q) use ($search) {
                $q->where('nm_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->orderBy('id_pelanggan', 'desc')
            ->paginate(10)
            ->withQueryString();

        $total_pelanggan = Pelanggan::count();
        $total_member = Pelanggan::whereHas('membership')->count();
        $total_non_member = Pelanggan::whereDoesntHave('membership')->count();

        $statusCounts = Pelanggan::selectRaw("
            COALESCE((
                SELECT status FROM booking
                WHERE booking.id_pelanggan = pelanggan.id_pelanggan
                ORDER BY tanggal DESC, jam DESC LIMIT 1
            ), 'tanpa_status') as latest_status
        ")->get()->groupBy('latest_status')->map->count();

        $total_terjadwal = $statusCounts['dikonfirmasi'] ?? 0;
        $total_diproses  = $statusCounts['diproses'] ?? 0;
        $total_selesai   = $statusCounts['selesai'] ?? 0;
        $total_dibatalkan = $statusCounts['dibatalkan'] ?? 0;

        return view('beautycian.pelanggan.index', compact(
            'pelanggan', 'search',
            'total_pelanggan', 'total_member', 'total_non_member',
            'total_terjadwal', 'total_diproses', 'total_selesai', 'total_dibatalkan'
        ));
    }
}
