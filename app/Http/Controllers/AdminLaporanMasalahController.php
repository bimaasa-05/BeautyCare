<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\LaporanMasalah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminLaporanMasalahController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanMasalah::with('user')
            ->orderByRaw("FIELD(status, 'baru', 'diproses', 'selesai')")
            ->orderByDesc('id_laporan');

        if ($request->filled('status') && in_array($request->status, ['baru', 'diproses', 'selesai'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('role') && in_array($request->role, ['kasir', 'beautycian', 'pelanggan'])) {
            $query->where('role', $request->role);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('deskripsi', 'like', '%' . $keyword . '%')
                    ->orWhere('kategori', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', fn ($u) => $u->where('nama', 'like', '%' . $keyword . '%'));
            });
        }

        $summary = [
            'baru' => LaporanMasalah::where('status', 'baru')->count(),
            'diproses' => LaporanMasalah::where('status', 'diproses')->count(),
            'selesai' => LaporanMasalah::where('status', 'selesai')->count(),
        ];

        return view('admin.laporan-masalah.index', [
            'laporan' => $query->get(),
            'summary' => $summary,
            'filterStatus' => $request->status,
            'filterRole' => $request->role,
        ]);
    }

    public function show($id)
    {
        $laporan = LaporanMasalah::with('user')->findOrFail($id);

        return view('admin.laporan-masalah.show', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $laporan = LaporanMasalah::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
            'catatan_admin' => 'nullable|string|max:2000',
        ]);

        $laporan->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? $laporan->catatan_admin,
        ]);

        $label = [
            'baru' => 'Diterima',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
        ][$validated['status']];

        $profil = match ($laporan->role) {
            'kasir' => 'kasir.laporan-masalah.index',
            'beautycian' => 'beautycian.laporan-masalah.index',
            default => 'pelanggan.laporan-masalah.index',
        };

        $isi = 'Status laporan Anda "' . $laporan->kategori . '" menjadi ' . $label . '.';
        if ($laporan->catatan_admin) {
            $isi .= ' Catatan admin: ' . Str::limit($laporan->catatan_admin, 120);
        }

        buatNotif($laporan->id_user, 'Laporan Masalah ' . $label, $isi, 'Laporan', route($profil));

        ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' mengubah status laporan masalah #' . $laporan->id_laporan . ' menjadi ' . $label . ' (' . $laporan->kategori . ')', 'Laporan', $laporan->id_laporan);

        return redirect()->route('admin.laporan-masalah.index')
            ->with('message', 'Status laporan #' . $laporan->id_laporan . ' diperbarui menjadi ' . $label . '.');
    }
}