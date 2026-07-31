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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        $promos = Promo::where('status', 'Tersedia')
            ->whereDate('selesai', '>=', now())
            ->orderBy('id_promo', 'desc')
            ->get();
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

        $bookingAktif = Booking::where('id_pelanggan', $userId)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->count();
        $riwayatTreatment = Booking::where('id_pelanggan', $userId)
            ->where('status', 'selesai')
            ->count();

        $riwayatTreatments = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $userId)
            ->where('status', 'selesai')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->take(5)
            ->get();

        $bookingMendatang = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $userId)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->take(3)
            ->get();

        $favoritLayananIds = DetailBooking::select('id_layanan')
            ->whereHas('booking', fn($q) => $q->where('id_pelanggan', $userId))
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

        $pelanggan = Pelanggan::where('email', $user->email)->first();
        if (!$pelanggan) {
            $pelanggan = Pelanggan::where('nm_pelanggan', $user->nama)->first();
        }
        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'nm_pelanggan' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_member' => null,
            ]);
        }
        $totalBooking = DB::table('log_booking')->where('id_pelanggan', $userId)->count();
        $memberTingkat = null;
        $memberList = collect();
        if ($pelanggan && $pelanggan->id_member) {
            $member = Membership::find($pelanggan->id_member);
            $memberTingkat = $member ? $member->tingkat : null;
            $memberList = Membership::where('status', 'aktif')->orderBy('id_member')->get();
        }

        $chartMonths = [];
        $chartCounts = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->startOfMonth()->subMonths($i);
            $count = DB::table('log_booking')
                ->where('id_pelanggan', $userId)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();
            $chartMonths[] = $date->format('M');
            $chartCounts[] = $count;
        }

        return view('pelanggan.dashboard', compact(
            'promos', 'layanans', 'kategoriLayanan', 'produks',
            'totalBooking', 'bookingAktif', 'riwayatTreatment', 'kunjunganBulanIni',
            'memberTingkat', 'memberList',
            'chartMonths', 'chartCounts',
            'riwayatTreatments', 'bookingMendatang',
            'layananFavorit', 'produkTerlaris'
        ));
    }
}
