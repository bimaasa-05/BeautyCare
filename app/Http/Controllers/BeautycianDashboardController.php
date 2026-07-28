<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class BeautycianDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $id_karyawan = $user->id;
        $today = date('Y-m-d');

        // Stat cards
        $jadwal_hari_ini = Booking::where('id_karyawan', $id_karyawan)
            ->where('tanggal', $today)
            ->count();

        $pelanggan_ditangani = Booking::where('id_karyawan', $id_karyawan)
            ->distinct('id_pelanggan')
            ->count('id_pelanggan');

        $layanan_selesai = Booking::where('id_karyawan', $id_karyawan)
            ->where('status', 'selesai')
            ->count();

        $jam_kerja_today = DetailBooking::select(DB::raw('COALESCE(SUM(layanan.durasi), 0) as total_durasi'))
            ->join('booking', 'booking.id_booking', '=', 'detail_booking.id_booking')
            ->join('layanan', 'layanan.id_layanan', '=', 'detail_booking.id_layanan')
            ->where('booking.id_karyawan', $id_karyawan)
            ->where('booking.tanggal', $today)
            ->whereIn('booking.status', ['diproses', 'selesai'])
            ->first()
            ->total_durasi;

        $jam_kerja = $jam_kerja_today > 0 ? round($jam_kerja_today / 60, 1) . ' jam' : '0 jam';

        // Treatment history (Riwayat Treatment)
        $riwayat_treatment = Booking::with(['detail.layanan', 'pelanggan'])
            ->where('id_karyawan', $id_karyawan)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->take(5)
            ->get();

        // Today's schedule (Jadwal Perawatan)
        $jadwal_hari_ini_list = Booking::with(['detail.layanan', 'pelanggan'])
            ->where('id_karyawan', $id_karyawan)
            ->where('tanggal', $today)
            ->orderBy('jam', 'asc')
            ->get();

        // Upcoming bookings (Booking Mendatang)
        $booking_mendatang = Booking::with(['detail.layanan', 'pelanggan'])
            ->where('id_karyawan', $id_karyawan)
            ->where('tanggal', '>', $today)
            ->whereIn('status', ['dikonfirmasi', 'diproses'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->take(5)
            ->get();

        // Chart data helper
        $chartPeriod = $request->input('chart_period', 'week');

        // --- Week (7 days) ---
        $weekData = DetailBooking::select(
                DB::raw('DATE(booking.tanggal) as tanggal'),
                DB::raw('COUNT(detail_booking.id_detail_booking) as total')
            )
            ->join('booking', 'booking.id_booking', '=', 'detail_booking.id_booking')
            ->where('booking.id_karyawan', $id_karyawan)
            ->where('booking.status', 'selesai')
            ->where('booking.tanggal', '>=', date('Y-m-d', strtotime('-7 days')))
            ->groupBy('booking.tanggal')
            ->orderBy('booking.tanggal', 'asc')
            ->get();

        $weekLabels = [];
        $weekValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $weekLabels[] = date('D', strtotime($date));
            $found = $weekData->firstWhere('tanggal', $date);
            $weekValues[] = $found ? (int) $found->total : 0;
        }

        // --- Month (30 days) ---
        $monthData = DetailBooking::select(
                DB::raw('DATE(booking.tanggal) as tanggal'),
                DB::raw('COUNT(detail_booking.id_detail_booking) as total')
            )
            ->join('booking', 'booking.id_booking', '=', 'detail_booking.id_booking')
            ->where('booking.id_karyawan', $id_karyawan)
            ->where('booking.status', 'selesai')
            ->where('booking.tanggal', '>=', date('Y-m-d', strtotime('-30 days')))
            ->groupBy('booking.tanggal')
            ->orderBy('booking.tanggal', 'asc')
            ->get();

        $monthLabels = [];
        $monthValues = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $monthLabels[] = date('d M', strtotime($date));
            $found = $monthData->firstWhere('tanggal', $date);
            $monthValues[] = $found ? (int) $found->total : 0;
        }

        // --- Year (12 months) ---
        $yearData = DetailBooking::select(
                DB::raw("DATE_FORMAT(booking.tanggal, '%Y-%m') as bulan"),
                DB::raw('COUNT(detail_booking.id_detail_booking) as total')
            )
            ->join('booking', 'booking.id_booking', '=', 'detail_booking.id_booking')
            ->where('booking.id_karyawan', $id_karyawan)
            ->where('booking.status', 'selesai')
            ->where('booking.tanggal', '>=', date('Y-m-d', strtotime('-12 months')))
            ->groupBy(DB::raw("DATE_FORMAT(booking.tanggal, '%Y-%m')"))
            ->orderBy('bulan', 'asc')
            ->get();

        $yearLabels = [];
        $yearValues = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $yearLabels[] = date('M Y', strtotime($date . '-01'));
            $found = $yearData->firstWhere('bulan', $date);
            $yearValues[] = $found ? (int) $found->total : 0;
        }

        // Select which dataset to show initially
        $chartLabels = ${$chartPeriod . 'Labels'};
        $chartValues = ${$chartPeriod . 'Values'};

        // Jam kerja per hari (last 7 days)
        $jamKerjaPerHari = DetailBooking::select(
                DB::raw('DAYOFWEEK(booking.tanggal) as hari'),
                DB::raw('COALESCE(SUM(layanan.durasi), 0) as total_durasi')
            )
            ->join('booking', 'booking.id_booking', '=', 'detail_booking.id_booking')
            ->join('layanan', 'layanan.id_layanan', '=', 'detail_booking.id_layanan')
            ->where('booking.id_karyawan', $id_karyawan)
            ->where('booking.tanggal', '>=', date('Y-m-d', strtotime('-7 days')))
            ->whereIn('booking.status', ['diproses', 'selesai'])
            ->groupBy(DB::raw('DAYOFWEEK(booking.tanggal)'))
            ->pluck('total_durasi', 'hari');

        $hariMap = [1 => 'Min', 2 => 'Sen', 3 => 'Sel', 4 => 'Rab', 5 => 'Kam', 6 => 'Jum', 7 => 'Sab'];
        $jamKerjaBars = [];
        $totalJamKerja = 0;
        for ($i = 1; $i <= 7; $i++) {
            $durasi = isset($jamKerjaPerHari[$i]) ? (int) $jamKerjaPerHari[$i] : 0;
            $jamKerjaBars[] = $durasi;
            $totalJamKerja += $durasi;
        }
        $maxDurasi = max($jamKerjaBars) ?: 1;

        // Produk Sering Digunakan
        $produk_sering = DetailTransaksi::select(
                'detail_transaksi.nm_item',
                'kategori_produk.nm_produk as nm_kategori',
                DB::raw('COUNT(detail_transaksi.id_detail_transaksi) as total')
            )
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->leftJoin('produk', 'produk.id_produk', '=', 'detail_transaksi.id_item')
            ->leftJoin('kategori_produk', 'kategori_produk.id_kategori_produk', '=', 'produk.id_kategori_produk')
            ->where('detail_transaksi.jenis', 'Produk')
            ->where('transaksi.status', 'Lunas')
            ->groupBy('detail_transaksi.nm_item', 'kategori_produk.nm_produk')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Favorit products
        $produk_favorit = DetailTransaksi::select(
                'nm_item',
                DB::raw('COUNT(detail_transaksi.id_detail_transaksi) as total')
            )
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('detail_transaksi.jenis', 'Produk')
            ->where('transaksi.status', 'Lunas')
            ->groupBy('nm_item')
            ->orderBy('total', 'desc')
            ->take(4)
            ->get();

        $maxFavorit = $produk_favorit->max('total') ?: 1;

        $statusLabels = [
            'menunggu'     => 'Menunggu',
            'dikonfirmasi' => 'Dikonfirmasi',
            'diproses'     => 'Diproses',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
        ];

        return view('beautycian.dashboard', compact(
            'jadwal_hari_ini',
            'pelanggan_ditangani',
            'layanan_selesai',
            'jam_kerja',
            'riwayat_treatment',
            'jadwal_hari_ini_list',
            'booking_mendatang',
            'weekLabels', 'weekValues',
            'monthLabels', 'monthValues',
            'yearLabels', 'yearValues',
            'chartLabels', 'chartValues',
            'jamKerjaBars',
            'maxDurasi',
            'totalJamKerja',
            'produk_sering',
            'produk_favorit',
            'maxFavorit',
            'statusLabels'
        ));
    }
}