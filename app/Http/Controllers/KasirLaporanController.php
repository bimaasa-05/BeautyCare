<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Exports\KasirLaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirLaporanController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $search = $request->keyword;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $queryBase = Transaksi::where('id_user', $userId);

        $totalTransaksi = (clone $queryBase)->count();

        $totalPendapatan = (clone $queryBase)
            ->where('status', 'Lunas')
            ->sum('total');

        $rataTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        $metodeTerbanyak = (clone $queryBase)
            ->select('metode_byr', DB::raw('COUNT(*) as total'))
            ->where('status', 'Lunas')
            ->groupBy('metode_byr')
            ->orderBy('total', 'desc')
            ->first();

        $metodeData = (clone $queryBase)
            ->select('metode_byr', DB::raw('COUNT(*) as total'))
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('metode_byr')
            ->orderBy('total', 'desc')
            ->get();

        $chartMetodeLabels = $metodeData->pluck('metode_byr')->toArray();
        $chartMetodeValues = $metodeData->pluck('total')->toArray();

        $periodeTransaksi = (clone $queryBase)
            ->whereBetween('tanggal', [$startDate, $endDate]);

        $periodePendapatan = (clone $periodeTransaksi)
            ->where('status', 'Lunas')
            ->sum('total');

        $periodeCount = (clone $periodeTransaksi)->count();

        $prevStart = $this->getPreviousPeriodStart($periode, $startDate);
        $prevPendapatan = (clone $queryBase)
            ->whereBetween('tanggal', [$prevStart, $startDate])
            ->where('status', 'Lunas')
            ->sum('total');
        $pendapatanGrowth = $prevPendapatan > 0 ? round((($periodePendapatan - $prevPendapatan) / $prevPendapatan) * 100) : 0;

        [$chartLabels, $chartRevenue, $chartTransaksi] = $this->getChartData($userId, $periode, $startDate, $endDate);

        $jumlahHari = (int)((strtotime($endDate) - strtotime($startDate)) / 86400) + 1;
        $rataPendapatan = $jumlahHari > 0 ? $periodePendapatan / $jumlahHari : 0;

        $transaksi = (clone $queryBase)
            ->with('pelanggan')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('no_invoice', 'like', "%{$search}%")
                        ->orWhereHas('pelanggan', function ($sub) use ($search) {
                            $sub->where('nm_pelanggan', 'like', "%{$search}%");
                        });
                });
            })
            ->when($dari, function ($query, $dari) {
                return $query->whereDate('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query, $sampai) {
                return $query->whereDate('tanggal', '<=', $sampai);
            })
            ->orderBy('id_transaksi', 'desc')
            ->paginate(15);

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

        return view('kasir.laporan.index', compact(
            'totalTransaksi', 'totalPendapatan', 'rataTransaksi',
            'metodeTerbanyak', 'periodePendapatan', 'periodeCount',
            'pendapatanGrowth', 'chartLabels', 'chartRevenue',
            'chartTransaksi', 'chartMetodeLabels', 'chartMetodeValues',
            'periode', 'startDate', 'endDate', 'transaksi',
            'search', 'dari', 'sampai', 'fmt', 'maxRevenue',
            'rataPendapatan', 'jumlahHari'
        ));
    }

    private function getChartData($userId, $periode, $startDate, $endDate)
    {
        if ($periode === '7hari' || $periode === '30hari') {
            $revenue = Transaksi::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COALESCE(SUM(total),0) as total')
                )
                ->where('id_user', $userId)
                ->where('status', 'Lunas')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $transCount = Transaksi::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('id_user', $userId)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $labels = [];
            $revenueData = [];
            $transData = [];
            $current = strtotime($startDate);
            $end = strtotime($endDate);
            while ($current <= $end) {
                $dateKey = date('Y-m-d', $current);
                $labels[] = date('d M', $current);
                $revenueData[] = (float)($revenue[$dateKey] ?? 0);
                $transData[] = (int)($transCount[$dateKey] ?? 0);
                $current = strtotime('+1 day', $current);
            }
            return [$labels, $revenueData, $transData];
        }

        $revenue = Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->where('id_user', $userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $transCount = Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw('COUNT(*) as total')
            )
            ->where('id_user', $userId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $labels = [];
        $revenueData = [];
        $transData = [];
        $current = new \DateTime($startDate);
        $endDT = new \DateTime($endDate);
        while ($current <= $endDT) {
            $key = $current->format('Y-m');
            $labels[] = $monthNames[(int)$current->format('m') - 1];
            $revenueData[] = (float)($revenue[$key] ?? 0);
            $transData[] = (int)($transCount[$key] ?? 0);
            $current->modify('+1 month');
        }
        return [$labels, $revenueData, $transData];
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
        $userId = auth()->id();
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $totalTransaksi = Transaksi::where('id_user', $userId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->count();

        $totalPendapatan = Transaksi::where('id_user', $userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('total');

        $rataTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        $transaksi = Transaksi::with('pelanggan')
            ->where('id_user', $userId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $userName = auth()->user()->nama;

        $fmt = function ($amount) {
            if ($amount >= 1000000000) {
                return 'Rp ' . number_format($amount / 1000000000, 1) . 'M';
            }
            if ($amount >= 1000000) {
                return 'Rp ' . number_format($amount / 1000000, 1) . 'jt';
            }
            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        $pdf = Pdf::loadView('kasir.laporan.pdf', compact(
            'totalTransaksi', 'totalPendapatan', 'rataTransaksi',
            'transaksi', 'startDate', 'endDate', 'userName', 'fmt'
        ));

        return $pdf->download('laporan-kasir-' . auth()->user()->nama . '-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        return Excel::download(
            new KasirLaporanExport(auth()->id(), $startDate, $endDate),
            'laporan-kasir-' . auth()->user()->nama . '-' . date('Y-m-d') . '.xlsx'
        );
    }
}
