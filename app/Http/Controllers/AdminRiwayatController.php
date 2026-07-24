<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;

class AdminRiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;
        $dari = $request->dari;
        $sampai = $request->sampai;
        $roleFilter = $request->role;
        $tipeFilter = $request->tipe;

        $totalAktivitas = RiwayatAktivitas::count();
        $totalByRole = RiwayatAktivitas::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        $riwayat = RiwayatAktivitas::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('deskripsi', 'like', "%{$search}%")
                        ->orWhere('aksi', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($sub) use ($search) {
                            $sub->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->when($dari, function ($query, $dari) {
                return $query->whereDate('created_at', '>=', $dari);
            })
            ->when($sampai, function ($query, $sampai) {
                return $query->whereDate('created_at', '<=', $sampai);
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                return $query->where('role', $roleFilter);
            })
            ->when($tipeFilter, function ($query, $tipeFilter) {
                return $query->where('tipe', $tipeFilter);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.riwayat.index', compact(
            'riwayat', 'totalAktivitas', 'totalByRole'
        ));
    }

    public function show($id)
    {
        $riwayat = RiwayatAktivitas::with('user')->findOrFail($id);
        return view('admin.riwayat.show', compact('riwayat'));
    }
}
