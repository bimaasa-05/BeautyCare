<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Membership;
use App\Exports\AdminLaporanPelangganExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaporanPelangganController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $totalPelanggan = Pelanggan::count();

        $pelangganBaru = Pelanggan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        $pelangganMember = Pelanggan::whereNotNull('id_member')->count();

        $transaksiPelanggan = Transaksi::whereNotNull('id_pelanggan')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->count();

        $prevStart = $this->getPreviousPeriodStart($periode, $startDate);
        $prevPelangganBaru = Pelanggan::whereBetween('created_at', [$prevStart . ' 00:00:00', $startDate . ' 23:59:59'])
            ->count();
        $pelangganBaruGrowth = $prevPelangganBaru > 0 ? round((($pelangganBaru - $prevPelangganBaru) / $prevPelangganBaru) * 100) : 0;

        [$chartLabels, $chartData] = $this->getChartData($startDate, $endDate, $periode);

        [$memberLabels, $memberValues] = $this->getMembershipDistribution();

        $search = $request->keyword;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $pelanggan = Pelanggan::with('membership')
            ->withCount('transaksi as total_transaksi')
            ->withSum(['transaksi as total_belanja' => function ($q) {
                $q->where('status', 'Lunas');
            }], 'total')
            ->withMax('transaksi as tgl_terakhir', 'tanggal')
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nm_pelanggan', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($dari, function ($q, $dari) {
                $q->whereDate('created_at', '>=', $dari);
            })
            ->when($sampai, function ($q, $sampai) {
                $q->whereDate('created_at', '<=', $sampai);
            })
            ->orderBy('id_pelanggan', 'desc')
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

        return view('admin.laporan-pelanggan.index', compact(
            'totalPelanggan', 'pelangganBaru', 'pelangganMember',
            'transaksiPelanggan', 'pelangganBaruGrowth',
            'chartLabels', 'chartData',
            'memberLabels', 'memberValues',
            'periode', 'startDate', 'endDate',
            'search', 'dari', 'sampai',
            'pelanggan', 'fmt'
        ));
    }

    private function getChartData($startDate, $endDate, $periode)
    {
        if ($periode === '7hari' || $periode === '30hari') {
            $data = Pelanggan::select(
                    DB::raw('DATE(created_at) as label'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $labels = [];
            $values = [];
            $current = strtotime($startDate);
            $end = strtotime($endDate);
            while ($current <= $end) {
                $dateKey = date('Y-m-d', $current);
                $labels[] = date('d M', $current);
                $values[] = (int)($data[$dateKey] ?? 0);
                $current = strtotime('+1 day', $current);
            }
            return [$labels, $values];
        }

        $data = Pelanggan::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as label"),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $labels = [];
        $values = [];
        $current = new \DateTime($startDate);
        $endDT = new \DateTime($endDate);
        while ($current <= $endDT) {
            $key = $current->format('Y-m');
            $labels[] = $monthNames[(int)$current->format('m') - 1];
            $values[] = (int)($data[$key] ?? 0);
            $current->modify('+1 month');
        }
        return [$labels, $values];
    }

    private function getMembershipDistribution()
    {
        $data = Membership::leftJoin('pelanggan', 'membership.id_member', '=', 'pelanggan.id_member')
            ->select('membership.tingkat', DB::raw('COUNT(pelanggan.id_pelanggan) as total'))
            ->groupBy('membership.tingkat')
            ->orderBy('total', 'desc')
            ->get();

        $labels = $data->pluck('tingkat')->toArray();
        $values = $data->pluck('total')->toArray();

        $nonMember = Pelanggan::whereNull('id_member')->count();
        if ($nonMember > 0) {
            $labels[] = 'Non Member';
            $values[] = $nonMember;
        }

        return [$labels, $values];
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

        $totalPelanggan = Pelanggan::count();
        $pelangganBaru = Pelanggan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $pelangganMember = Pelanggan::whereNotNull('id_member')->count();
        $transaksiPelanggan = Transaksi::whereNotNull('id_pelanggan')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->count();

        $pelanggan = Pelanggan::with('membership')
            ->withCount('transaksi as total_transaksi')
            ->withSum(['transaksi as total_belanja' => function ($q) {
                $q->where('status', 'Lunas');
            }], 'total')
            ->withMax('transaksi as tgl_terakhir', 'tanggal')
            ->orderBy('id_pelanggan', 'desc')
            ->get();

        $fmt = function ($amount) {
            if ($amount >= 1000000000) {
                return 'Rp ' . number_format($amount / 1000000000, 1) . 'M';
            }
            if ($amount >= 1000000) {
                return 'Rp ' . number_format($amount / 1000000, 1) . 'jt';
            }
            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        $pdf = Pdf::loadView('admin.laporan-pelanggan.pdf', compact(
            'totalPelanggan', 'pelangganBaru', 'pelangganMember',
            'transaksiPelanggan', 'pelanggan', 'startDate', 'endDate', 'fmt'
        ));

        return $pdf->download('laporan-pelanggan-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $periode = $request->get('periode', '30hari');
        $dateRange = $this->getDateRange($periode);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        return Excel::download(
            new AdminLaporanPelangganExport($startDate, $endDate),
            'laporan-pelanggan-' . date('Y-m-d') . '.xlsx'
        );
    }
}
