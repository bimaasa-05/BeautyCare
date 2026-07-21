<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', '30hari');

        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $totalPendapatan = Transaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');

        $totalReservasi = Booking::whereBetween('tanggal', [$startDate, $endDate])->count();

        $pelangganBaru = User::where('role', 'pelanggan')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        $year = date('Y');
        $currentMonth = (int)date('m');

        $monthlyRevenue = Transaksi::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->whereYear('tanggal', $year)
            ->where('status', '!=', 'Dibatalkan')
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $monthlyBookings = Booking::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal', $year)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartLabels = [];
        $chartRevenue = [];
        $chartBookings = [];

        for ($i = 1; $i <= $currentMonth; $i++) {
            $chartLabels[] = $monthNames[$i - 1];
            $chartRevenue[] = (float)($monthlyRevenue[$i] ?? 0);
            $chartBookings[] = (int)($monthlyBookings[$i] ?? 0);
        }

        $prevStart = $this->getPreviousPeriodStart($periode, $startDate);

        $prevPendapatan = Transaksi::whereBetween('tanggal', [$prevStart, $startDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');
        $pendapatanGrowth = $prevPendapatan > 0 ? round((($totalPendapatan - $prevPendapatan) / $prevPendapatan) * 100) : 0;

        $prevReservasi = Booking::whereBetween('tanggal', [$prevStart, $startDate])->count();
        $reservasiGrowth = $prevReservasi > 0 ? round((($totalReservasi - $prevReservasi) / $prevReservasi) * 100) : 0;

        $prevPelanggan = User::where('role', 'pelanggan')
            ->whereBetween('created_at', [$prevStart . ' 00:00:00', $startDate . ' 23:59:59'])
            ->count();
        $pelangganGrowth = $prevPelanggan > 0 ? round((($pelangganBaru - $prevPelanggan) / $prevPelanggan) * 100) : 0;

        $fmt = function ($amount) {
            if ($amount >= 1000000000) {
                return 'Rp ' . number_format($amount / 1000000000, 1) . 'M';
            }
            if ($amount >= 1000000) {
                return 'Rp ' . number_format($amount / 1000000, 1) . 'jt';
            }
            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        $maxRevenue = count($chartRevenue) > 0 ? max($chartRevenue) : 0;

        return view('admin.laporan.index', compact(
            'totalPendapatan', 'totalReservasi', 'pelangganBaru',
            'pendapatanGrowth', 'reservasiGrowth', 'pelangganGrowth',
            'chartLabels', 'chartRevenue', 'chartBookings',
            'periode', 'startDate', 'endDate', 'fmt', 'maxRevenue'
        ));
    }

    private function getDateRange($periode)
    {
        $end = date('Y-m-d');
        return match ($periode) {
            '7hari' => ['start' => date('Y-m-d', strtotime('-7 days')), 'end' => $end],
            '3bulan' => ['start' => date('Y-m-d', strtotime('-3 months')), 'end' => $end],
            'tahunini' => ['start' => date('Y-01-01'), 'end' => $end],
            default => ['start' => date('Y-m-d', strtotime('-30 days')), 'end' => $end],
        };
    }

    private function getPreviousPeriodStart($periode, $currentStart)
    {
        return match ($periode) {
            '7hari' => date('Y-m-d', strtotime($currentStart . ' -7 days')),
            '3bulan' => date('Y-m-d', strtotime($currentStart . ' -3 months')),
            'tahunini' => date('Y-m-d', strtotime($currentStart . ' -1 year')),
            default => date('Y-m-d', strtotime($currentStart . ' -30 days')),
        };
    }
}
