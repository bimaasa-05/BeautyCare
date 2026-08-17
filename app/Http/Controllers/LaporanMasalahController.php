<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\LaporanMasalah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LaporanMasalahController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $laporan = LaporanMasalah::with('user')
            ->where('id_user', Auth::id())
            ->orderByDesc('id_laporan')
            ->get();

        return view($role . '.laporan-masalah.index', [
            'laporan' => $laporan,
            'routeName' => $role . '.laporan-masalah',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|in:Aplikasi,Pembayaran,Booking/Reservasi,Stok/Produk,Akun,Lainnya',
            'deskripsi' => 'required|string|min:10|max:2000',
            'bukti' => 'nullable|array|max:3',
            'bukti.*' => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,mkv,webm|max:10240',
        ]);

        $bukti = [];
        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $bukti[] = $file->store('laporan-masalah', 'public');
            }
        }

        $laporan = LaporanMasalah::create([
            'id_user' => Auth::id(),
            'role' => auth()->user()->role,
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'bukti' => $bukti ?: null,
            'status' => 'baru',
        ]);

        $pelapor = auth()->user()->nama;
        buatNotifRole(
            'admin',
            'Laporan Masalah Baru',
            $pelapor . ' melaporkan masalah "' . $validated['kategori'] . '": ' . Str::limit($validated['deskripsi'], 100),
            'Laporan',
            route('admin.laporan-masalah.index')
        );

        ActivityLogger::log('Menambahkan', $pelapor . ' melaporkan masalah "' . $validated['kategori'] . '"', 'Laporan', $laporan->id_laporan);

        return redirect()->route(auth()->user()->role . '.laporan-masalah.index')
            ->with('message', 'Laporan masalah berhasil dikirim. Tim kami akan segera menindaklanjuti.');
    }
}