<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\DetailBooking;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;

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

        $reservasi = $query->orderByDesc(Pelanggan::select('created_at')
            ->whereColumn('id_pelanggan', 'booking.id_pelanggan')
            ->limit(1))
            ->paginate(10)->withQueryString();

        $total_reservasi = Booking::where('id_karyawan', $id_karyawan)->count();
        $dikonfirmasi = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dikonfirmasi')->count();
        $diproses     = Booking::where('id_karyawan', $id_karyawan)->where('status', 'diproses')->count();
        $selesai      = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')->count();
        $dibatalkan   = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dibatalkan')->count();

        $total_pendapatan = DetailBooking::whereHas('booking', function ($q) use ($id_karyawan) {
            $q->where('id_karyawan', $id_karyawan)->where('status', 'selesai');
        })->sum('subtotal');

        $pendapatan_bulan_ini = DetailBooking::whereHas('booking', function ($q) use ($id_karyawan) {
            $q->where('id_karyawan', $id_karyawan)
                ->where('status', 'selesai')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        })->sum('subtotal');

        $rata_rata_transaksi = $selesai > 0 ? round($total_pendapatan / $selesai) : 0;

        $booking_hari_ini = Booking::where('id_karyawan', $id_karyawan)
            ->where('tanggal', now()->toDateString())
            ->count();

        $chartBulan = [];
        $chartSelesai = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartBulan[] = \Carbon\Carbon::create()->month($i)->isoFormat('MMM');
            $chartSelesai[] = Booking::where('id_karyawan', $id_karyawan)
                ->where('status', 'selesai')
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->count();
        }

        $chartDailyData = [];
        $daysInMonth = now()->daysInMonth;
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $chartDailyData[] = Booking::where('id_karyawan', $id_karyawan)
                ->where('status', 'selesai')
                ->whereDay('tanggal', $d)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();
        }

        $layananTerpopuler = DetailBooking::select('id_layanan', DB::raw('COUNT(*) as total'))
            ->whereHas('booking', function ($q) use ($id_karyawan) {
                $q->where('id_karyawan', $id_karyawan);
            })
            ->groupBy('id_layanan')
            ->orderBy('total', 'desc')
            ->with('layanan')
            ->limit(5)
            ->get();

        $pelanggan_setia = Booking::where('id_karyawan', $id_karyawan)
            ->select('id_pelanggan', DB::raw('COUNT(*) as total'))
            ->groupBy('id_pelanggan')
            ->orderBy('total', 'desc')
            ->with('pelanggan')
            ->limit(5)
            ->get();

        return view('beautycian.laporan-reservasi.index', compact(
            'reservasi',
            'search',
            'total_reservasi',
            'dikonfirmasi',
            'diproses',
            'selesai',
            'dibatalkan',
            'total_pendapatan',
            'pendapatan_bulan_ini',
            'rata_rata_transaksi',
            'booking_hari_ini',
            'chartBulan',
            'chartSelesai',
            'chartDailyData',
            'layananTerpopuler',
            'pelanggan_setia'
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
