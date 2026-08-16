<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LeaderboardService
{
    public function topPelanggan($jenis, $startDate = null, $endDate = null, $limit = 10)
    {
        $totals = DB::table('detail_transaksi as dt')
            ->join('transaksi as t', 't.id_transaksi', '=', 'dt.id_transaksi')
            ->join('pelanggan as p', 'p.id_pelanggan', '=', 't.id_pelanggan')
            ->where('dt.jenis', 'LIKE', $jenis)
            ->where('t.status', 'Lunas')
            ->where('t.jenis_transaksi', 'Penjualan')
            ->when($startDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('t.tanggal', [$startDate, $endDate]);
            })
            ->select('p.id_pelanggan', 'p.nm_pelanggan', DB::raw('SUM(dt.subtotal) as nominal'))
            ->groupBy('p.id_pelanggan', 'p.nm_pelanggan')
            ->orderByDesc('nominal')
            ->limit($limit)
            ->get();

        $favoritRows = DB::table('detail_transaksi as dt')
            ->join('transaksi as t', 't.id_transaksi', '=', 'dt.id_transaksi')
            ->where('dt.jenis', 'LIKE', $jenis)
            ->where('t.status', 'Lunas')
            ->where('t.jenis_transaksi', 'Penjualan')
            ->when($startDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('t.tanggal', [$startDate, $endDate]);
            })
            ->select('t.id_pelanggan', 'dt.nm_item', DB::raw('SUM(dt.subtotal) as total'))
            ->groupBy('t.id_pelanggan', 'dt.nm_item')
            ->orderByDesc('total')
            ->get();

        $favorit = [];
        foreach ($favoritRows as $row) {
            $key = (string) $row->id_pelanggan;
            if (!isset($favorit[$key])) {
                $favorit[$key] = $row->nm_item;
            }
        }

        return $totals->map(function ($row) use ($favorit) {
            $row->favorit = $favorit[(string) $row->id_pelanggan] ?? '-';
            return $row;
        });
    }

    public function beautycianLeaderboard($startDate = null, $endDate = null, $limit = 10)
    {
        $query = DB::table('booking as b')
            ->join('users as u', 'u.id', '=', 'b.id_karyawan')
            ->join('pelanggan as p', 'p.id_pelanggan', '=', 'b.id_pelanggan')
            ->whereIn('b.status', ['selesai', 'diproses'])
            ->when($startDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('b.tanggal', [$startDate, $endDate]);
            });

        $totals = (clone $query)
            ->select(
                'u.id',
                'u.nama',
                'u.foto',
                DB::raw('COUNT(DISTINCT b.id_pelanggan) as total_pelanggan'),
                DB::raw('COUNT(b.id_booking) as total_booking'),
                DB::raw('COUNT(CASE WHEN b.status = "selesai" THEN 1 END) as total_selesai')
            )
            ->groupBy('u.id', 'u.nama', 'u.foto')
            ->orderByDesc('total_pelanggan')
            ->orderByDesc('total_selesai')
            ->limit($limit)
            ->get();

        return $totals->map(function ($row, $index) {
            $row->rank = $index + 1;
            $row->foto_url = $row->foto ? asset('storage/' . $row->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($row->nama) . '&background=FF4F87&color=fff&size=140';
            $row->win_rate = $row->total_booking > 0 ? round(($row->total_selesai / $row->total_booking) * 100, 1) : 0;
            return $row;
        });
    }

    public function kasirLeaderboard($startDate = null, $endDate = null, $limit = 10)
    {
        $rows = DB::table('transaksi as t')
            ->join('users as u', 'u.id', '=', 't.id_kasir')
            ->where('t.status', 'Lunas')
            ->whereIn('t.jenis_transaksi', ['Penjualan', 'Booking', 'Pesanan Online'])
            ->when($startDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('t.tanggal', [$startDate, $endDate]);
            })
            ->select(
                'u.id',
                'u.nama',
                'u.foto',
                DB::raw('SUM(t.total) as total_nominal'),
                DB::raw('COUNT(t.id_transaksi) as total_transaksi'),
                DB::raw('COUNT(DISTINCT t.id_pelanggan) as total_pelanggan')
            )
            ->groupBy('u.id', 'u.nama', 'u.foto')
            ->orderByDesc('total_nominal')
            ->orderByDesc('total_transaksi')
            ->limit($limit)
            ->get();

        return $rows->map(function ($row, $index) {
            $row->rank = $index + 1;
            $row->foto_url = $row->foto ? asset('storage/' . $row->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($row->nama) . '&background=FF4F87&color=fff&size=140';
            $row->rata_rata = $row->total_transaksi > 0 ? round($row->total_nominal / $row->total_transaksi) : 0;
            return $row;
        });
    }

    public function beautycianDetail($beautycianId, $startDate = null, $endDate = null)
    {
        $query = DB::table('booking as b')
            ->join('pelanggan as p', 'p.id_pelanggan', '=', 'b.id_pelanggan')
            ->where('b.id_karyawan', $beautycianId)
            ->whereIn('b.status', ['selesai', 'diproses'])
            ->when($startDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('b.tanggal', [$startDate, $endDate]);
            });

        $pelangganList = (clone $query)
            ->select(
                'p.id_pelanggan',
                'p.nm_pelanggan',
                'p.foto',
                DB::raw('COUNT(b.id_booking) as total_booking'),
                DB::raw('COUNT(CASE WHEN b.status = "selesai" THEN 1 END) as total_selesai'),
                DB::raw('MAX(b.tanggal) as last_booking')
            )
            ->groupBy('p.id_pelanggan', 'p.nm_pelanggan', 'p.foto')
            ->orderByDesc('total_booking')
            ->get();

        $monthlyStats = DB::table('booking as b')
            ->where('b.id_karyawan', $beautycianId)
            ->whereIn('b.status', ['selesai', 'diproses'])
            ->when($startDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('b.tanggal', [$startDate, $endDate]);
            })
            ->select(
                DB::raw("DATE_FORMAT(b.tanggal, '%Y-%m') as bulan"),
                DB::raw('COUNT(DISTINCT b.id_pelanggan) as pelanggan_unik'),
                DB::raw('COUNT(b.id_booking) as total_booking'),
                DB::raw('COUNT(CASE WHEN b.status = "selesai" THEN 1 END) as total_selesai')
            )
            ->groupBy(DB::raw("DATE_FORMAT(b.tanggal, '%Y-%m')"))
            ->orderBy('bulan', 'desc')
            ->limit(12)
            ->get();

        return [
            'pelanggan' => $pelangganList,
            'monthly' => $monthlyStats,
        ];
    }
}
