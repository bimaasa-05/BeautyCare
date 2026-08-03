<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Booking;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirDashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $periode = $request->get('periode', '7hari');
        $paymentPeriode = $request->get('payment_periode', '7hari');

        $periodStart = match ($periode) {
            '30hari' => date('Y-m-d', strtotime('-30 days')),
            '3bulan' => date('Y-m-d', strtotime('-3 months')),
            'tahunini' => date('Y-01-01'),
            default => date('Y-m-d', strtotime('-7 days')),
        };

        $paymentPeriodStart = match ($paymentPeriode) {
            '30hari' => date('Y-m-d', strtotime('-30 days')),
            '3bulan' => date('Y-m-d', strtotime('-3 months')),
            'tahunini' => date('Y-01-01'),
            default => date('Y-m-d', strtotime('-7 days')),
        };

        $pendapatanHariIni = (float) Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $today)
            ->where('status', 'Lunas')
            ->sum('total');

        $pendapatanKemarin = (float) Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $yesterday)
            ->where('status', 'Lunas')
            ->sum('total');

        $pendapatanGrowth = $pendapatanKemarin > 0
            ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100)
            : ($pendapatanHariIni > 0 ? 100 : 0);

        $transaksiHariIni = Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $today)
            ->count();

        $transaksiKemarin = Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $yesterday)
            ->count();

        $transaksiGrowth = $transaksiKemarin > 0
            ? round((($transaksiHariIni - $transaksiKemarin) / $transaksiKemarin) * 100)
            : ($transaksiHariIni > 0 ? 100 : 0);

        $pelangganHariIni = Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $today)
            ->whereNotNull('id_pelanggan')
            ->distinct('id_pelanggan')
            ->count('id_pelanggan');

        $pelangganKemarin = Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $yesterday)
            ->whereNotNull('id_pelanggan')
            ->distinct('id_pelanggan')
            ->count('id_pelanggan');

        $pelangganGrowth = $pelangganKemarin > 0
            ? round((($pelangganHariIni - $pelangganKemarin) / $pelangganKemarin) * 100)
            : ($pelangganHariIni > 0 ? 100 : 0);

        $pesananPending = Transaksi::where('id_user', $userId)
            ->where('status', 'Pending')
            ->count();

        $pendingKemarin = Transaksi::where('id_user', $userId)
            ->whereDate('tanggal', $yesterday)
            ->where('status', 'Pending')
            ->count();

        $pendingGrowth = $pendingKemarin > 0
            ? round((($pesananPending - $pendingKemarin) / $pendingKemarin) * 100)
            : ($pesananPending > 0 && $pendingKemarin == 0 ? 100 : 0);

        $produkTerjual = (int) DetailTransaksi::join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.id_user', $userId)
            ->whereDate('transaksi.tanggal', $today)
            ->where('detail_transaksi.jenis', 'produk')
            ->sum('detail_transaksi.qty');

        $produkTerjualKemarin = (int) DetailTransaksi::join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.id_user', $userId)
            ->whereDate('transaksi.tanggal', $yesterday)
            ->where('detail_transaksi.jenis', 'produk')
            ->sum('detail_transaksi.qty');

        $produkTerjualGrowth = $produkTerjualKemarin > 0
            ? round((($produkTerjual - $produkTerjualKemarin) / $produkTerjualKemarin) * 100)
            : ($produkTerjual > 0 ? 100 : 0);

        [$chartLabels, $chartRevenue] = $this->getChartData($userId, $periode, $periodStart);

        $salesChartData = [
            '7hari' => $this->getChartDataForPeriod($userId, '7hari'),
            '30hari' => $this->getChartDataForPeriod($userId, '30hari'),
            '3bulan' => $this->getChartDataForPeriod($userId, '3bulan'),
            'tahunini' => $this->getChartDataForPeriod($userId, 'tahunini'),
        ];

        $paymentChartData = [
            '7hari' => $this->getPaymentChartDataForPeriod($userId, '7hari'),
            '30hari' => $this->getPaymentChartDataForPeriod($userId, '30hari'),
            '3bulan' => $this->getPaymentChartDataForPeriod($userId, '3bulan'),
            'tahunini' => $this->getPaymentChartDataForPeriod($userId, 'tahunini'),
        ];

        $paymentData = Transaksi::select('metode_byr', DB::raw('COUNT(*) as total'), DB::raw('COALESCE(SUM(total),0) as jumlah'))
            ->where('id_user', $userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$paymentPeriodStart, $today])
            ->groupBy('metode_byr')
            ->orderBy('total', 'desc')
            ->get();

        $paymentLabels = $paymentData->pluck('metode_byr')->toArray();
        $paymentValues = $paymentData->pluck('total')->map(fn($v) => (int) $v)->toArray();

        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->where('id_user', $userId)
            ->whereBetween('tanggal', [$periodStart, $today])
            ->orderBy('id_transaksi', 'desc')
            ->limit(10)
            ->get();

        $produkTerlaris = DetailTransaksi::select(
                'detail_transaksi.id_item',
                'detail_transaksi.nm_item',
                'detail_transaksi.jenis',
                DB::raw('SUM(detail_transaksi.qty) as total_qty'),
                DB::raw('SUM(detail_transaksi.subtotal) as total_subtotal')
            )
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.id_user', $userId)
            ->whereBetween('transaksi.tanggal', [$periodStart, $today])
            ->groupBy('detail_transaksi.id_item', 'detail_transaksi.nm_item', 'detail_transaksi.jenis')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        $rekapPembayaran = Transaksi::select(
                'metode_byr',
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->where('id_user', $userId)
            ->whereBetween('tanggal', [$paymentPeriodStart, $today])
            ->groupBy('metode_byr')
            ->orderBy('jumlah', 'desc')
            ->get();

        $checkinHariIni = Booking::with(['pelanggan', 'detail.layanan'])
            ->whereDate('tanggal', $today)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->orderBy('jam')
            ->get();

        $riwayatTransaksi = Transaksi::with('pelanggan')
            ->where('id_user', $userId)
            ->orderBy('id_transaksi', 'desc')
            ->limit(10)
            ->get();

        $stokMenipis = Produk::with('kategori')
            ->where('stok', '<=', 20)
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get();

        $fmt = function ($amount) {
            if ($amount >= 1000000000) {
                return 'Rp ' . number_format($amount / 1000000000, 1) . ' M';
            }
            if ($amount >= 1000000) {
                return 'Rp ' . number_format($amount / 1000000, 1) . ' jt';
            }
            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        $fmtRibuan = function ($amount) {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        return view('kasir.dashboard', compact(
            'pendapatanHariIni', 'pendapatanGrowth',
            'transaksiHariIni', 'transaksiGrowth',
            'pelangganHariIni', 'pelangganGrowth',
            'pesananPending', 'pendingGrowth',
            'produkTerjual', 'produkTerjualGrowth',
            'chartLabels', 'chartRevenue', 'periode',
            'paymentLabels', 'paymentValues', 'paymentPeriode',
            'salesChartData', 'paymentChartData',
            'transaksiTerbaru',
            'produkTerlaris',
            'rekapPembayaran',
            'checkinHariIni',
            'riwayatTransaksi',
            'stokMenipis',
            'fmt', 'fmtRibuan', 'today'
        ));
    }

    private function getChartDataForPeriod($userId, $periode)
    {
        $start = match ($periode) {
            '30hari' => date('Y-m-d', strtotime('-30 days')),
            '3bulan' => date('Y-m-d', strtotime('-3 months')),
            'tahunini' => date('Y-01-01'),
            default => date('Y-m-d', strtotime('-7 days')),
        };
        [$labels, $revenue] = $this->getChartData($userId, $periode, $start);
        return ['labels' => $labels, 'values' => $revenue];
    }

    private function getPaymentChartDataForPeriod($userId, $periode)
    {
        $today = date('Y-m-d');
        $start = match ($periode) {
            '30hari' => date('Y-m-d', strtotime('-30 days')),
            '3bulan' => date('Y-m-d', strtotime('-3 months')),
            'tahunini' => date('Y-01-01'),
            default => date('Y-m-d', strtotime('-7 days')),
        };

        $data = Transaksi::select('metode_byr', DB::raw('COUNT(*) as total'), DB::raw('COALESCE(SUM(total),0) as jumlah'))
            ->where('id_user', $userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$start, $today])
            ->groupBy('metode_byr')
            ->orderBy('total', 'desc')
            ->get();

        $labels = $data->pluck('metode_byr')->toArray();
        $values = $data->pluck('total')->map(fn($v) => (int) $v)->toArray();

        return ['labels' => $labels, 'values' => $values];
    }

    private function getChartData($userId, $periode, $start)
    {
        $end = date('Y-m-d');

        $data = Transaksi::select(
                DB::raw('DATE(tanggal) as label'),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->where('id_user', $userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$start, $end])
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $labels = [];
        $revenue = [];
        $current = strtotime($start);
        $endTs = strtotime($end);
        while ($current <= $endTs) {
            $dateKey = date('Y-m-d', $current);
            $labels[] = date('d M', $current);
            $revenue[] = (float) ($data[$dateKey] ?? 0);
            $current = strtotime('+1 day', $current);
        }

        return [$labels, $revenue];
    }
}
