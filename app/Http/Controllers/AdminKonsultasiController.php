<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;

class AdminKonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with(['pelanggan', 'karyawan'])
            ->orderByRaw("FIELD(status, 'menunggu', 'dikonfirmasi', 'selesai', 'ditolak')")
            ->orderByDesc('tanggal');

        if ($request->filled('status') && in_array($request->status, ['menunggu', 'dikonfirmasi', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $summary = [
            'menunggu' => Konsultasi::where('status', 'menunggu')->count(),
            'dikonfirmasi' => Konsultasi::where('status', 'dikonfirmasi')->count(),
            'selesai' => Konsultasi::where('status', 'selesai')->count(),
            'ditolak' => Konsultasi::where('status', 'ditolak')->count(),
        ];

        return view('admin.konsultasi.index', [
            'konsultasi' => $query->get(),
            'summary' => $summary,
            'filterStatus' => $request->status,
        ]);
    }
}
