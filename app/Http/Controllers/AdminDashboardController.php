<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Booking;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use App\Services\LeaderboardService;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    protected function getDashboardData()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $bulanLalu = $bulan == 1 ? 12 : $bulan - 1;
        $tahunLalu = $bulan == 1 ? $tahun - 1 : $tahun;

        $totalPendapatan = Transaksi::where('jenis_transaksi', 'Penjualan')
            ->where('status', '!=', 'Dibatalkan')->sum('total');

        $totalBooking = Booking::count();

        $totalPelanggan = Pelanggan::count();

        $totalKaryawan = Karyawan::whereHas('user', fn ($q) => $q->whereIn('role', ['kasir', 'beautycian']))->count();

        $produkTerjual = DetailTransaksi::where('detail_transaksi.jenis', 'produk')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.jenis_transaksi', 'Penjualan')
            ->sum('detail_transaksi.qty');

        $pendapatanBulanIni = Transaksi::where('jenis_transaksi', 'Penjualan')
            ->where('status', '!=', 'Dibatalkan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->sum('total');

        $pendapatanBulanLalu = Transaksi::where('jenis_transaksi', 'Penjualan')
            ->where('status', '!=', 'Dibatalkan')
            ->whereYear('tanggal', $tahunLalu)
            ->whereMonth('tanggal', $bulanLalu)
            ->sum('total');

        $pendapatanGrowth = $pendapatanBulanLalu > 0
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100)
            : ($pendapatanBulanIni > 0 ? 100 : 0);

        $bookingBulanIni = Booking::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->count();

        $bookingBulanLalu = Booking::whereYear('tanggal', $tahunLalu)
            ->whereMonth('tanggal', $bulanLalu)
            ->count();

        $bookingGrowth = $bookingBulanLalu > 0
            ? round((($bookingBulanIni - $bookingBulanLalu) / $bookingBulanLalu) * 100)
            : ($bookingBulanIni > 0 ? 100 : 0);

        $pelangganBulanIni = Pelanggan::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->count();

        $pelangganBulanLalu = Pelanggan::whereYear('created_at', $tahunLalu)
            ->whereMonth('created_at', $bulanLalu)
            ->count();

        $pelangganGrowth = $pelangganBulanLalu > 0
            ? round((($pelangganBulanIni - $pelangganBulanLalu) / $pelangganBulanLalu) * 100)
            : ($pelangganBulanIni > 0 ? 100 : 0);

        $produkTerjualBulanIni = DetailTransaksi::where('detail_transaksi.jenis', 'produk')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.jenis_transaksi', 'Penjualan')
            ->whereYear('transaksi.tanggal', $tahun)
            ->whereMonth('transaksi.tanggal', $bulan)
            ->sum('detail_transaksi.qty');

        $produkTerjualBulanLalu = DetailTransaksi::where('detail_transaksi.jenis', 'produk')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.jenis_transaksi', 'Penjualan')
            ->whereYear('transaksi.tanggal', $tahunLalu)
            ->whereMonth('transaksi.tanggal', $bulanLalu)
            ->sum('detail_transaksi.qty');

        $produkTerjualGrowth = $produkTerjualBulanLalu > 0
            ? round((($produkTerjualBulanIni - $produkTerjualBulanLalu) / $produkTerjualBulanLalu) * 100)
            : ($produkTerjualBulanIni > 0 ? 100 : 0);

        $karyawanGrowth = 0;

        $chartRevenue = Transaksi::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->where('status', '!=', 'Dibatalkan')
            ->where('jenis_transaksi', 'Penjualan')
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $chartBooking = Booking::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $chartLabels = [];
        $chartRevenueData = [];
        $chartBookingData = [];
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $namaBulan[$i - 1];
            $chartRevenueData[] = (float)($chartRevenue[$i] ?? 0);
            $chartBookingData[] = (int)($chartBooking[$i] ?? 0);
        }

        $maxRevenue = count($chartRevenueData) > 0 ? max($chartRevenueData) : 0;

        $hariIni = date('Y-m-d');

        $chartBookingMinggu = Booking::select(
                DB::raw('DAYOFWEEK(tanggal) as hari'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('tanggal', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])
            ->groupBy(DB::raw('DAYOFWEEK(tanggal)'))
            ->orderBy('hari')
            ->pluck('total', 'hari')
            ->toArray();

        $hariBars = [];
        $hariLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        for ($d = 1; $d <= 7; $d++) {
            $hariBars[] = (int)($chartBookingMinggu[$d] ?? 0);
        }
        $maxBar = count($hariBars) > 0 ? max($hariBars) : 1;
        $totalBookingMinggu = array_sum($hariBars);

        $senin = date('Y-m-d', strtotime('monday this week'));
        $minggu = date('Y-m-d', strtotime('sunday this week'));
        $bookingMingguDetail = Booking::with(['detail.layanan'])
            ->whereBetween('tanggal', [$senin, $minggu])
            ->get()
            ->groupBy(function($b) { return \Carbon\Carbon::parse($b->tanggal)->dayOfWeek; });

        $hariDetail = [];
        foreach ($hariLabel as $i => $label) {
            $dayNum = $i;
            $dayBookings = $bookingMingguDetail->get($dayNum, collect());
            $layanan = [];
            foreach ($dayBookings as $b) {
                foreach ($b->detail as $d) {
                    $nm = $d->layanan->nm_layanan ?? 'Layanan';
                    if (!isset($layanan[$nm])) $layanan[$nm] = 0;
                    $layanan[$nm]++;
                }
            }
            $hariDetail[] = $layanan;
        }

        $layananBookingMinggu = Booking::with(['detail.layanan'])
            ->whereBetween('tanggal', [$senin, $minggu])
            ->get()
            ->flatMap(function($b) {
                return $b->detail->pluck('layanan.nm_layanan');
            })
            ->filter()
            ->countBy()
            ->toArray();

        $jadwalHariIni = Booking::with(['pelanggan', 'detail.layanan'])
            ->whereDate('tanggal', $hariIni)
            ->orderBy('jam')
            ->get();

        $layananTerlaris = DetailTransaksi::select(
                'id_item',
                'nm_item',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_subtotal')
            )
            ->where('jenis', 'layanan')
            ->groupBy('id_item', 'nm_item')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $produkTerlaris = DetailTransaksi::select(
                'detail_transaksi.id_item',
                'detail_transaksi.nm_item',
                DB::raw('SUM(detail_transaksi.qty) as total_qty'),
                DB::raw('SUM(detail_transaksi.subtotal) as total_subtotal')
            )
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('detail_transaksi.jenis', 'produk')
            ->where('transaksi.jenis_transaksi', 'Penjualan')
            ->groupBy('detail_transaksi.id_item', 'detail_transaksi.nm_item')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $karyawanAktif = Karyawan::with('user')
            ->whereHas('user', fn ($q) => $q->whereIn('role', ['kasir', 'beautycian']))
            ->where('status', '!=', 'Libur')
            ->get();

        $ringkasanStok = Produk::with('kategori')
            ->where('status', 'Tersedia')
            ->orderBy('stok')
            ->limit(4)
            ->get();

        $totalStok = Produk::where('status', 'Tersedia')->count();
        $stokAman = Produk::where('status', 'Tersedia')->where('stok', '>', 20)->count();
        $stokMenipis = Produk::where('status', 'Tersedia')->where('stok', '<=', 20)->where('stok', '>', 0)->count();
        $stokHabis = Produk::where('status', 'Habis')->count();
        $stokTerisi = $totalStok > 0 ? round(($stokAman / $totalStok) * 100) : 0;
        $stokMenipisPct = $totalStok > 0 ? round(($stokMenipis / $totalStok) * 100) : 0;
        $stokHabisPct = $totalStok > 0 ? round(($stokHabis / $totalStok) * 100) : 0;

        $notifStok = Produk::with('kategori')
            ->where('stok', '<=', 20)
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get();

        $bookingTerbaru = Booking::with(['pelanggan', 'detail.layanan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->limit(5)
            ->get();

        $leaderboardService = new LeaderboardService();
        $topGlobalLayanan = $leaderboardService->topPelanggan('Layanan', null, null, 5);
        $topGlobalProduk = $leaderboardService->topPelanggan('Produk', null, null, 5);

        $fmt = function ($amount) {
            if ($amount >= 1000000000) {
                return 'Rp ' . number_format($amount / 1000000000, 1) . ' M';
            }
            if ($amount >= 1000000) {
                return 'Rp ' . number_format($amount / 1000000, 1) . ' jt';
            }
            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        return compact(
            'totalPendapatan', 'totalBooking', 'totalPelanggan',
            'totalKaryawan', 'produkTerjual',
            'pendapatanGrowth', 'bookingGrowth', 'pelangganGrowth',
            'produkTerjualGrowth', 'karyawanGrowth',
            'chartLabels', 'chartRevenueData', 'chartBookingData', 'maxRevenue',
            'hariBars', 'hariLabel', 'hariDetail', 'maxBar', 'totalBookingMinggu', 'layananBookingMinggu',
            'jadwalHariIni',
            'layananTerlaris', 'produkTerlaris',
            'karyawanAktif',
            'ringkasanStok',
            'notifStok',
            'stokTerisi', 'stokMenipisPct', 'stokHabisPct',
            'bookingTerbaru',
            'topGlobalLayanan', 'topGlobalProduk',
            'fmt'
        );
    }

    public function index()
    {
        $data = $this->getDashboardData();
        extract($data);

        return view('admin.dashboard', $data);
    }

    public function data()
    {
        $data = $this->getDashboardData();
        extract($data);

        return response()->json([
            'stats' => [
                'totalPendapatan' => $fmt($totalPendapatan),
                'pendapatanGrowth' => $pendapatanGrowth,
                'totalBooking' => number_format($totalBooking),
                'bookingGrowth' => $bookingGrowth,
                'totalPelanggan' => number_format($totalPelanggan),
                'pelangganGrowth' => $pelangganGrowth,
                'totalKaryawan' => number_format($totalKaryawan),
                'karyawanGrowth' => $karyawanGrowth,
                'produkTerjual' => number_format($produkTerjual),
                'produkTerjualGrowth' => $produkTerjualGrowth,
            ],
            'charts' => [
                'labels' => $chartLabels,
                'revenue' => $chartRevenueData,
            ],
            'donut' => [
                'values' => array_values($layananBookingMinggu),
                'labels' => array_keys($layananBookingMinggu),
                'total' => $totalBookingMinggu,
            ],
            'jadwalHariIni' => [
                'total' => $jadwalHariIni->count(),
                'html' => view('partials.dashboard.jadwal-hari-ini', compact('jadwalHariIni'))->render(),
            ],
            'layananTerlaris' => [
                'html' => view('partials.dashboard.layanan-terlaris', ['items' => $layananTerlaris, 'fmt' => $fmt])->render(),
            ],
            'produkTerlaris' => [
                'html' => view('partials.dashboard.produk-terlaris', ['items' => $produkTerlaris, 'fmt' => $fmt])->render(),
            ],
            'topGlobalLayanan' => [
                'html' => view('partials.dashboard.top-global-layanan', ['items' => $topGlobalLayanan, 'fmt' => $fmt])->render(),
            ],
            'topGlobalProduk' => [
                'html' => view('partials.dashboard.top-global-produk', ['items' => $topGlobalProduk, 'fmt' => $fmt])->render(),
            ],
            'karyawanAktif' => [
                'html' => view('partials.dashboard.karyawan-aktif', compact('karyawanAktif'))->render(),
            ],
            'ringkasanStok' => [
                'html' => view('partials.dashboard.ringkasan-stok', compact('ringkasanStok'))->render(),
            ],
            'bookingTerbaru' => [
                'html' => view('partials.dashboard.booking-terbaru', compact('bookingTerbaru'))->render(),
            ],
            'notifStok' => [
                'html' => view('partials.dashboard.notif-stok', compact('notifStok'))->render(),
            ],
        ]);
    }
}
