<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Konsultasi;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;

class KasirKonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with(['pelanggan', 'karyawan'])
            ->orderByRaw("FIELD(status, 'menunggu', 'dikonfirmasi', 'selesai', 'ditolak')")
            ->orderByDesc('tanggal');

        if ($request->filled('status') && in_array($request->status, ['menunggu', 'dikonfirmasi', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $karyawan = User::where('role', 'beautycian')->get();

        return view('kasir.konsultasi.index', [
            'konsultasi' => $query->get(),
            'karyawan' => $karyawan,
            'filterStatus' => $request->status,
        ]);
    }

    public function konfirmasi(Request $request, $id)
    {
        $konsultasi = Konsultasi::with('pelanggan')->findOrFail($id);

        if ($konsultasi->status !== 'menunggu') {
            return back()->with('error', 'Konsultasi ini sudah tidak dalam status menunggu.');
        }

        $request->validate([
            'id_karyawan' => 'required|exists:users,id',
        ]);

        $konsultasi->update([
            'id_karyawan' => $request->id_karyawan,
            'status' => 'dikonfirmasi',
        ]);

        $nama = $konsultasi->pelanggan->nm_pelanggan ?? 'Pelanggan';

        ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' mengkonfirmasi konsultasi ' . $nama . ' "' . $konsultasi->topik . '" dan menugaskan ke terapis', 'Konsultasi', $konsultasi->id_konsultasi, ['status' => 'menunggu'], ['status' => 'dikonfirmasi', 'id_karyawan' => $request->id_karyawan]);

        buatNotif($konsultasi->id_karyawan, 'Konsultasi Ditugaskan', 'Konsultasi ' . $nama . ' "' . $konsultasi->topik . '" ditugaskan ke Anda. Segera hubungi pelanggan.', 'Konsultasi', route('beautycian.konsultasi.index'));

        if ($konsultasi->pelanggan && $konsultasi->pelanggan->id_user) {
            buatNotif($konsultasi->pelanggan->id_user, 'Konsultasi Dikonfirmasi', 'Konsultasi "' . $konsultasi->topik . '" dikonfirmasi. Terapis akan segera menghubungi Anda.', 'Konsultasi', route('pelanggan.konsultasi.index'));
        }

        return back()->with('message', 'Konsultasi dikonfirmasi dan ditugaskan ke terapis.');
    }

    public function tolak(Request $request, $id)
    {
        $konsultasi = Konsultasi::with('pelanggan')->findOrFail($id);

        if ($konsultasi->status !== 'menunggu') {
            return back()->with('error', 'Konsultasi ini sudah tidak dalam status menunggu.');
        }

        $request->validate([
            'alasan' => 'nullable|string|max:500',
        ]);

        $konsultasi->update(['status' => 'ditolak']);

        ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' menolak konsultasi "' . $konsultasi->topik . '"' . ($request->alasan ? ' dengan alasan: ' . $request->alasan : ''), 'Konsultasi', $konsultasi->id_konsultasi, ['status' => 'menunggu'], ['status' => 'ditolak']);

        if ($konsultasi->pelanggan && $konsultasi->pelanggan->id_user) {
            buatNotif($konsultasi->pelanggan->id_user, 'Konsultasi Ditolak', 'Konsultasi "' . $konsultasi->topik . '" ditolak' . ($request->alasan ? ' dengan alasan: ' . $request->alasan : '.') . ' Kuota Anda tidak terpakai.', 'Konsultasi', route('pelanggan.konsultasi.index'));
        }

        return back()->with('message', 'Konsultasi ditolak.');
    }
}
