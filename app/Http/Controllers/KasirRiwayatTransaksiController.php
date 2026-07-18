<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirRiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::where('status', 1)->sum('total');

        $transaksi = Transaksi::with('pelanggan', 'user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('no_invoice', 'like', "%{$search}%")
                        ->orWhereHas('pelanggan', function ($sub) use ($search) {
                            $sub->where('nm_pelanggan', 'like', "%{$search}%")
                                ->orWhere('no_hp', 'like', "%{$search}%");
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

        return view('kasir.riwayat-transaksi.index', compact(
            'transaksi', 'totalTransaksi', 'totalPendapatan'
        ));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'user')->findOrFail($id);
        return view('kasir.riwayat-transaksi.show', compact('transaksi'));
    }
}
