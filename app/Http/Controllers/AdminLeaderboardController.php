<?php

namespace App\Http\Controllers;

use App\Services\LeaderboardService;
use Illuminate\Http\Request;

class AdminLeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'semua');
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');

        [$startDate, $endDate] = $this->resolveRange($periode, $dari, $sampai);

        $service = new LeaderboardService();
        $topLayanan = $service->topPelanggan('Layanan', $startDate, $endDate);
        $topProduk = $service->topPelanggan('Produk', $startDate, $endDate);
<<<<<<< HEAD
        $topBeautycian = $service->beauticianLeaderboard($startDate, $endDate, 10);
=======
        $topBeautycian = $service->beautycianLeaderboard($startDate, $endDate, 10);
>>>>>>> 5d8cc777856d624b89dda3bdbe551fbbaaa316a4
        $topKasir = $service->kasirLeaderboard($startDate, $endDate, 10);

        $fmt = function ($amount) {
            return 'Rp ' . number_format((float) $amount, 0, ',', '.');
        };

        return view('admin.leaderboard.index', compact(
<<<<<<< HEAD
            'topLayanan', 'topProduk', 'topBeautician', 'topKasir', 'fmt',
=======
            'topLayanan', 'topProduk', 'topBeautycian', 'topKasir', 'fmt',
>>>>>>> 5d8cc777856d624b89dda3bdbe551fbbaaa316a4
            'periode', 'dari', 'sampai', 'startDate', 'endDate'
        ));
    }

    private function resolveRange($periode, $dari, $sampai)
    {
        if ($periode === 'semua') {
            return [null, null];
        }

        $end = date('Y-m-d');
        $start = match ($periode) {
            '1bulan' => date('Y-m-d', strtotime('-1 month')),
            '1tahun' => date('Y-m-d', strtotime('-1 year')),
            'custom' => $dari ?: $end,
            default => date('Y-m-d', strtotime('-7 days')),
        };
        $end = $periode === 'custom' ? ($sampai ?: $end) : $end;

        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }

        return [$start, $end];
    }
}
