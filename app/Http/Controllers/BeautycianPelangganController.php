<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pelanggan;
use App\Models\DetailBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeautycianPelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $id_karyawan = auth()->id();

        $pelanggan = Pelanggan::with('membership')
            ->addSelect(['status' => Booking::select('status')
                ->whereColumn('booking.id_pelanggan', 'pelanggan.id_pelanggan')
                ->where('id_karyawan', $id_karyawan)
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam', 'desc')
                ->limit(1)
            ])
            ->whereHas('booking', function ($q) use ($id_karyawan) {
                $q->where('id_karyawan', $id_karyawan);
            })
            ->when($search, function ($q) use ($search) {
                $q->where('nm_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->orderBy('id_pelanggan', 'desc')
            ->paginate(10)
            ->withQueryString();

        $total_pelanggan = Pelanggan::whereHas('booking', function ($q) use ($id_karyawan) {
            $q->where('id_karyawan', $id_karyawan);
        })->count();

        $total_member = Pelanggan::whereHas('booking', function ($q) use ($id_karyawan) {
                $q->where('id_karyawan', $id_karyawan);
            })->whereHas('membership')->count();

        $total_non_member = $total_pelanggan - $total_member;

        $pelanggan_baru_bulan_ini = Pelanggan::whereHas('booking', function ($q) use ($id_karyawan) {
                $q->where('id_karyawan', $id_karyawan);
            })
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $total_treatment_selesai = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')->count();

        $total_reservasi = Booking::where('id_karyawan', $id_karyawan)->count();

        $rata_rata_treatment = $total_pelanggan > 0 ? round($total_reservasi / $total_pelanggan, 1) : 0;

        $statusCounts = Pelanggan::selectRaw("
            COALESCE((
                SELECT status FROM booking
                WHERE booking.id_pelanggan = pelanggan.id_pelanggan
                AND booking.id_karyawan = {$id_karyawan}
                ORDER BY tanggal DESC, jam DESC LIMIT 1
            ), 'tanpa_status') as latest_status
        ")->whereHas('booking', function ($q) use ($id_karyawan) {
            $q->where('id_karyawan', $id_karyawan);
        })->get()->groupBy('latest_status')->map->count();

        $total_terjadwal = $statusCounts['dikonfirmasi'] ?? 0;
        $total_diproses  = $statusCounts['diproses'] ?? 0;
        $total_selesai   = $statusCounts['selesai'] ?? 0;
        $total_dibatalkan = $statusCounts['dibatalkan'] ?? 0;

        $chartBulan = [];
        $chartPelanggan = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartBulan[] = \Carbon\Carbon::create()->month($i)->isoFormat('MMM');
            $chartPelanggan[] = Pelanggan::whereHas('booking', function ($q) use ($id_karyawan, $i) {
                    $q->where('id_karyawan', $id_karyawan)
                      ->whereMonth('tanggal', $i)
                      ->whereYear('tanggal', now()->year);
                })->count();
        }

        $layananFavorit = DetailBooking::select('id_layanan', DB::raw('COUNT(*) as total'))
            ->whereHas('booking', function ($q) use ($id_karyawan) {
                $q->where('id_karyawan', $id_karyawan);
            })
            ->groupBy('id_layanan')
            ->orderBy('total', 'desc')
            ->with('layanan')
            ->limit(5)
            ->get();

        return view('beautycian.pelanggan.index', compact(
            'pelanggan', 'search',
            'total_pelanggan', 'total_member', 'total_non_member',
            'total_terjadwal', 'total_diproses', 'total_selesai', 'total_dibatalkan',
            'pelanggan_baru_bulan_ini', 'total_treatment_selesai',
            'total_reservasi', 'rata_rata_treatment',
            'chartBulan', 'chartPelanggan', 'layananFavorit'
        ));
    }
}
