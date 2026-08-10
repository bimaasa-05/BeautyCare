<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class BeautycianKonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with('pelanggan')
            ->where('id_karyawan', auth()->id())
            ->orderByRaw("FIELD(status, 'dikonfirmasi', 'selesai', 'ditolak')")
            ->orderByDesc('tanggal');

        if ($request->filled('status') && in_array($request->status, ['dikonfirmasi', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        return view('beautycian.konsultasi.index', [
            'konsultasi' => $query->get(),
            'filterStatus' => $request->status,
        ]);
    }

    public function selesai($id)
    {
        $konsultasi = Konsultasi::with('pelanggan')
            ->where('id_karyawan', auth()->id())
            ->findOrFail($id);

        if ($konsultasi->status !== 'dikonfirmasi') {
            return back()->with('error', 'Konsultasi ini sudah selesai atau tidak valid untuk diselesaikan.');
        }

        $konsultasi->update(['status' => 'selesai']);

        ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' menyelesaikan konsultasi "' . $konsultasi->topik . '" untuk ' . ($konsultasi->pelanggan->nm_pelanggan ?? 'Pelanggan'), 'Konsultasi', $konsultasi->id_konsultasi, ['status' => 'dikonfirmasi'], ['status' => 'selesai']);

        if ($konsultasi->pelanggan && $konsultasi->pelanggan->id_user) {
            buatNotif($konsultasi->pelanggan->id_user, 'Konsultasi Selesai', 'Konsultasi "' . $konsultasi->topik . '" telah selesai. Terima kasih telah berkonsultasi dengan kami.', 'Konsultasi', route('pelanggan.konsultasi.index'));
        }

        return back()->with('message', 'Konsultasi ditandai selesai.');
    }
}
