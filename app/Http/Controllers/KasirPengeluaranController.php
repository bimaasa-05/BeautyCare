<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class KasirPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $bulan = $request->bulan ?: now()->format('Y-m');
        $kategori = $request->kategori;

        $query = Pengeluaran::where('id_user', $userId);

        if ($bulan) {
            $query->where('tanggal', 'like', $bulan . '%');
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $pengeluaran = $query->orderBy('tanggal', 'desc')
            ->orderBy('id_pengeluaran', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalBulanIni = Pengeluaran::where('id_user', $userId)
            ->where('tanggal', 'like', now()->format('Y-m') . '%')
            ->sum('nominal');

        $totalSemua = Pengeluaran::where('id_user', $userId)->sum('nominal');

        $kategoris = Pengeluaran::where('id_user', $userId)
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('kasir.pengeluaran.index', compact(
            'pengeluaran', 'totalBulanIni', 'totalSemua', 'kategoris', 'bulan', 'kategori'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $pengeluaran = Pengeluaran::create([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan ?? '',
            'nominal' => (int) $request->nominal,
            'id_user' => auth()->id(),
        ]);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pengeluaran ' . $request->kategori . ' sebesar Rp ' . number_format($request->nominal, 0, ',', '.'), 'Pengeluaran', $pengeluaran->id_pengeluaran);

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Pengeluaran Baru', auth()->user()->nama . ' mencatat pengeluaran ' . $request->kategori . ' sebesar Rp ' . number_format($request->nominal, 0, ',', '.') . '.', 'Pengeluaran', url('/admin/pengeluaran'));
        }

        return redirect()->route('kasir.pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::where('id_pengeluaran', $id)
            ->where('id_user', auth()->id())
            ->firstOrFail();

        $pengeluaran->delete();

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus pengeluaran #' . $id, 'Pengeluaran', $id);

        return redirect()->route('kasir.pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
