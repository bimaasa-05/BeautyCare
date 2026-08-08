<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class AdminPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?: now()->format('Y-m');
        $kategori = $request->kategori;

        $query = Pengeluaran::with('user');

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

        $totalBulanIni = Pengeluaran::where('tanggal', 'like', now()->format('Y-m') . '%')->sum('nominal');
        $totalSemua = Pengeluaran::sum('nominal');
        $totalKasir = Pengeluaran::count();

        $kategoris = Pengeluaran::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin.pengeluaran.index', compact(
            'pengeluaran', 'totalBulanIni', 'totalSemua', 'totalKasir', 'kategoris', 'bulan', 'kategori'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'id_user' => 'nullable|integer',
        ]);

        $pengeluaran = Pengeluaran::create([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan ?? '',
            'nominal' => (int) $request->nominal,
            'id_user' => $request->id_user ?: auth()->id(),
        ]);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pengeluaran ' . $request->kategori . ' sebesar Rp ' . number_format($request->nominal, 0, ',', '.'), 'Pengeluaran', $pengeluaran->id_pengeluaran);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);

        $pengeluaran->update([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan ?? '',
            'nominal' => (int) $request->nominal,
        ]);

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah pengeluaran #' . $id, 'Pengeluaran', $id);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus pengeluaran #' . $id, 'Pengeluaran', $id);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
