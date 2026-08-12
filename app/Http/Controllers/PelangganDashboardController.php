<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Layanan;
use App\Models\KategoriLayanan;
use App\Models\Produk;
use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Pelanggan;
use App\Models\Membership;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'pelanggan') {
            abort(403);
        }

        $promos = Promo::where('status', 'Tersedia')
            ->whereDate('selesai', '>', now())
            ->orderBy('id_promo', 'desc')
            ->get()
            ->filter(fn ($promo) => $promo->berlakuUntuk(auth()->user()));
        $layanans = Layanan::where('status', 'Tersedia')
            ->orderBy('id_layanan', 'asc')
            ->get();
        $kategoriLayanan = KategoriLayanan::where('status', 'tersedia')->get();
        $produks = Produk::with('kategori')
            ->where('status', 'Tersedia')
            ->orderBy('id_produk', 'desc')
            ->get();

        $userId = auth()->id();
        $user = auth()->user();

        $pelanggan = Pelanggan::dariUser($user);
        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'nm_pelanggan' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_user' => $user->id,
                'id_member' => null,
            ]);
        }
        $idPelanggan = $pelanggan->id_pelanggan;

        $bookingAktif = Booking::where('id_pelanggan', $idPelanggan)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->whereDate('tanggal', now()->toDateString())
            ->count();
        $riwayatTreatment = Booking::where('id_pelanggan', $idPelanggan)
            ->where('status', 'selesai')
            ->count();

        $riwayatTreatments = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $idPelanggan)
            ->where('status', 'selesai')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->take(5)
            ->get();

        $bookingMendatang = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $idPelanggan)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->take(3)
            ->get();

        $favoritLayananIds = DetailBooking::select('id_layanan')
            ->whereHas('booking', fn($q) => $q->where('id_pelanggan', $idPelanggan))
            ->groupBy('id_layanan')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(4)
            ->pluck('id_layanan');

        $layananFavorit = Layanan::whereIn('id_layanan', $favoritLayananIds)->get();
        if ($layananFavorit->isEmpty()) {
            $layananFavorit = Layanan::where('status', 'Tersedia')->inRandomOrder()->take(4)->get();
        }

        $produkTerlarisRaw = DB::table('detail_transaksi')
            ->select('id_item', DB::raw('COALESCE(SUM(qty), 0) as total_terjual'))
            ->where('jenis', 'Produk')
            ->groupBy('id_item')
            ->orderBy('total_terjual', 'desc')
            ->limit(4)
            ->get();

        $produkTerlaris = collect();
        if ($produkTerlarisRaw->isNotEmpty()) {
            $ids = $produkTerlarisRaw->pluck('id_item');
            $produks = Produk::with('kategori')->whereIn('id_produk', $ids)->get()->keyBy('id_produk');
            foreach ($produkTerlarisRaw as $item) {
                if ($p = $produks->get($item->id_item)) {
                    $p->total_terjual = $item->total_terjual;
                    $produkTerlaris->push($p);
                }
            }
        }
        if ($produkTerlaris->isEmpty()) {
            $produkTerlaris = Produk::with('kategori')
                ->where('status', 'Tersedia')
                ->inRandomOrder()
                ->take(4)
                ->get();
            $produkTerlaris->each(fn($p) => $p->total_terjual = 0);
        }
        $kunjunganBulanIni = DB::table('log_kunjungan')
            ->where('id_user', $userId)
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->count();

        $totalBooking = DB::table('log_booking')->where('id_pelanggan', $idPelanggan)->count();
        $memberTingkat = null;
        $memberList = collect();
        if ($pelanggan && $pelanggan->id_member) {
            $member = $pelanggan->membershipAktif();
            $memberTingkat = $member ? $member->tingkat : null;
            $memberList = Membership::where('status', 'aktif')->orderBy('id_member')->get();
        }

        $totalBelanja = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('status', 'Lunas')
            ->sum('total');
        $totalTransaksi = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('status', 'Lunas')
            ->count();

        $memberSaatIni = $pelanggan && $pelanggan->id_member
            ? $pelanggan->membershipAktif()
            : null;
        $semuaMember = Membership::where('status', 'aktif')
            ->orderBy('min_transaksi')
            ->orderBy('min_pembelian')
            ->get();
        $levels = ['Silver', 'Gold', 'Platinum'];
        $nextTier = null;
        if ($memberSaatIni) {
            $currentIndex = array_search($memberSaatIni->tingkat, $levels);
            if ($currentIndex !== false && $currentIndex < count($levels) - 1) {
                $nextTier = $semuaMember->firstWhere('tingkat', $levels[$currentIndex + 1]);
            }
        } elseif ($totalTransaksi > 0 || $totalBelanja > 0) {
            $nextTier = $semuaMember->first();
        }
        $isMaxTier = $memberSaatIni && $memberSaatIni->tingkat === end($levels);
        $targetBelanja = $isMaxTier ? $memberSaatIni->min_pembelian : ($nextTier?->min_pembelian ?? 0);
        $targetTransaksi = $isMaxTier ? $memberSaatIni->min_transaksi : ($nextTier?->min_transaksi ?? 0);
        $progressBelanja = $isMaxTier ? 100
            : ($nextTier && $nextTier->min_pembelian > 0 ? (int) min(100, round($totalBelanja / $nextTier->min_pembelian * 100)) : 0);
        $progressTransaksi = $isMaxTier ? 100
            : ($nextTier && $nextTier->min_transaksi > 0 ? (int) min(100, round($totalTransaksi / $nextTier->min_transaksi * 100)) : 0);

        $chartMonths = [];
        $chartCounts = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->startOfMonth()->subMonths($i);
            $count = DB::table('log_booking')
                ->where('id_pelanggan', $idPelanggan)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();
            $chartMonths[] = $date->format('M');
            $chartCounts[] = $count;
        }

        $chartYearMonths = [];
        $chartYearCounts = [];
        for ($m = 1; $m <= now()->month; $m++) {
            $date = now()->copy()->startOfYear()->addMonths($m - 1);
            $count = DB::table('log_booking')
                ->where('id_pelanggan', $idPelanggan)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();
            $chartYearMonths[] = $date->format('M');
            $chartYearCounts[] = $count;
        }

        return view('pelanggan.dashboard', compact(
            'promos', 'layanans', 'kategoriLayanan', 'produks',
            'totalBooking', 'bookingAktif', 'riwayatTreatment', 'kunjunganBulanIni',
            'memberTingkat', 'memberList',
            'chartMonths', 'chartCounts', 'chartYearMonths', 'chartYearCounts',
            'riwayatTreatments', 'bookingMendatang',
            'layananFavorit', 'produkTerlaris',
            'totalBelanja', 'totalTransaksi', 'memberSaatIni',
            'nextTier', 'isMaxTier', 'progressBelanja', 'progressTransaksi',
            'targetBelanja', 'targetTransaksi'
        ));
    }
}
