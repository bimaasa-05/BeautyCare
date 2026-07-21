<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Booking;
use App\Models\User;
use App\Models\Pelanggan;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
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

        $pelangganBaru = Pelanggan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        [$chartLabels, $chartRevenue, $chartBookings] = $this->getChartData($periode, $startDate, $endDate);

        $prevStart = $this->getPreviousPeriodStart($periode, $startDate);

        $prevPendapatan = Transaksi::whereBetween('tanggal', [$prevStart, $startDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');
        $pendapatanGrowth = $prevPendapatan > 0 ? round((($totalPendapatan - $prevPendapatan) / $prevPendapatan) * 100) : 0;

        $prevReservasi = Booking::whereBetween('tanggal', [$prevStart, $startDate])->count();
        $reservasiGrowth = $prevReservasi > 0 ? round((($totalReservasi - $prevReservasi) / $prevReservasi) * 100) : 0;

        $prevPelanggan = Pelanggan::whereBetween('created_at', [$prevStart . ' 00:00:00', $startDate . ' 23:59:59'])
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

        $jumlahHari = (int)((strtotime($endDate) - strtotime($startDate)) / 86400) + 1;
        $rataPendapatan = $jumlahHari > 0 ? $totalPendapatan / $jumlahHari : 0;

        return view('admin.laporan.index', compact(
            'totalPendapatan', 'totalReservasi', 'pelangganBaru',
            'pendapatanGrowth', 'reservasiGrowth', 'pelangganGrowth',
            'chartLabels', 'chartRevenue', 'chartBookings',
            'periode', 'startDate', 'endDate', 'fmt', 'maxRevenue',
            'rataPendapatan', 'jumlahHari'
        ));
    }

    private function getChartData($periode, $startDate, $endDate)
    {
        if ($periode === '7hari' || $periode === '30hari') {
            $revenue = Transaksi::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COALESCE(SUM(total),0) as total')
                )
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->where('status', '!=', 'Dibatalkan')
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $bookings = Booking::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $labels = [];
            $revenueData = [];
            $bookingData = [];
            $current = strtotime($startDate);
            $end = strtotime($endDate);
            while ($current <= $end) {
                $dateKey = date('Y-m-d', $current);
                $labels[] = date('d M', $current);
                $revenueData[] = (float)($revenue[$dateKey] ?? 0);
                $bookingData[] = (int)($bookings[$dateKey] ?? 0);
                $current = strtotime('+1 day', $current);
            }
            return [$labels, $revenueData, $bookingData];
        }

        $revenue = Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $bookings = Booking::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $labels = [];
        $revenueData = [];
        $bookingData = [];
        $current = new \DateTime($startDate);
        $endDT = new \DateTime($endDate);
        while ($current <= $endDT) {
            $key = $current->format('Y-m');
            $labels[] = $monthNames[(int)$current->format('m') - 1];
            $revenueData[] = (float)($revenue[$key] ?? 0);
            $bookingData[] = (int)($bookings[$key] ?? 0);
            $current->modify('+1 month');
        }
        return [$labels, $revenueData, $bookingData];
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

    public function exportPDF(Request $request)
    {
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $totalPendapatan = Transaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');

        $totalReservasi = Booking::whereBetween('tanggal', [$startDate, $endDate])->count();

        $pelangganBaru = Pelanggan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        [$chartLabels, $chartRevenue, $chartBookings] = $this->getChartData($periode, $startDate, $endDate);

        $prevStart = $this->getPreviousPeriodStart($periode, $startDate);

        $prevPendapatan = Transaksi::whereBetween('tanggal', [$prevStart, $startDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');
        $pendapatanGrowth = $prevPendapatan > 0 ? round((($totalPendapatan - $prevPendapatan) / $prevPendapatan) * 100) : 0;

        $prevReservasi = Booking::whereBetween('tanggal', [$prevStart, $startDate])->count();
        $reservasiGrowth = $prevReservasi > 0 ? round((($totalReservasi - $prevReservasi) / $prevReservasi) * 100) : 0;

        $prevPelanggan = Pelanggan::whereBetween('created_at', [$prevStart . ' 00:00:00', $startDate . ' 23:59:59'])
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

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'totalPendapatan', 'totalReservasi', 'pelangganBaru',
            'pendapatanGrowth', 'reservasiGrowth', 'pelangganGrowth',
            'chartLabels', 'chartRevenue', 'chartBookings',
            'startDate', 'endDate', 'fmt'
        ));

        return $pdf->download('laporan-beautycare-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        return Excel::download(
            new LaporanExport($startDate, $endDate),
            'laporan-beautycare-' . date('Y-m-d') . '.xlsx'
        );
    }
}
