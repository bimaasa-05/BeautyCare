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
            ->where('dt.jenis', $jenis)
            ->where('t.status', 'Lunas')
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
            ->where('dt.jenis', $jenis)
            ->where('t.status', 'Lunas')
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
}
