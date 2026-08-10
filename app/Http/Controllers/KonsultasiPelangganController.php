<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Konsultasi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiPelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::dariUser(auth()->user());

        if (!$pelanggan) {
            return view('pelanggan.konsultasi.index', [
                'konsultasi' => collect(),
                'sisaKuota' => 0,
                'totalKuota' => 0,
                'memberLabel' => 'Belum punya membership',
            ]);
        }

        $member = $pelanggan->membershipAktif();
        $periode = now()->format('Y-m');
        $totalKuota = $member ? (int) $member->jml_konsultasi : 0;
        $terpakai = Konsultasi::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('periode', $periode)
            ->where('status', '!=', 'ditolak')
            ->count();
        $sisaKuota = max(0, $totalKuota - $terpakai);

        $konsultasi = Konsultasi::with(['karyawan'])
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->orderByDesc('tanggal')
            ->orderByDesc('jam')
            ->get();

        return view('pelanggan.konsultasi.index', [
            'konsultasi' => $konsultasi,
            'sisaKuota' => $sisaKuota,
            'totalKuota' => $totalKuota,
            'memberLabel' => $member ? 'Member ' . $member->nm_member : 'Belum punya membership',
        ]);
    }

    public function create()
    {
        $pelanggan = Pelanggan::dariUser(auth()->user());
        $member = $pelanggan?->membershipAktif();

        $periode = now()->format('Y-m');
        $totalKuota = $member ? (int) $member->jml_konsultasi : 0;
        $terpakai = $pelanggan
            ? Konsultasi::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('periode', $periode)
                ->where('status', '!=', 'ditolak')
                ->count()
            : 0;
        $sisaKuota = max(0, $totalKuota - $terpakai);

        if (!$member || $sisaKuota <= 0) {
            return redirect()->route('pelanggan.konsultasi.index')
                ->with('error', 'Kuota konsultasi Anda sudah habis atau belum punya membership aktif.');
        }

        return view('pelanggan.konsultasi.create', [
            'sisaKuota' => $sisaKuota,
            'memberLabel' => 'Member ' . $member->nm_member,
        ]);
    }

    public function store(Request $request)
    {
        $pelanggan = Pelanggan::dariUser(auth()->user());
        $member = $pelanggan?->membershipAktif();

        if (!$member) {
            return back()->with('error', 'Konsultasi hanya untuk member yang aktif.');
        }

        $periode = now()->format('Y-m');
        $totalKuota = (int) $member->jml_konsultasi;
        $terpakai = Konsultasi::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('periode', $periode)
            ->where('status', '!=', 'ditolak')
            ->count();

        if ($terpakai >= $totalKuota) {
            return back()->with('error', 'Kuota konsultasi bulan ini sudah habis.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required|date_format:H:i',
            'mode' => 'required|in:online,offline',
            'media' => 'nullable|required_if:mode,online|in:whatsapp_chat,whatsapp_video',
            'topik' => 'required|string|max:200',
            'pesan' => 'nullable|string|max:2000',
        ]);

        $konsultasi = Konsultasi::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_karyawan' => null,
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'] . ':00',
            'mode' => $validated['mode'],
            'media' => $validated['media'] ?? null,
            'topik' => $validated['topik'],
            'pesan' => $validated['pesan'] ?? null,
            'status' => 'menunggu',
            'periode' => $periode,
        ]);

        buatNotifRole('kasir', 'Permintaan Konsultasi Baru', $pelanggan->nm_pelanggan . ' mengajukan konsultasi "' . $validated['topik'] . '" dan menunggu konfirmasi.', 'Konsultasi', route('kasir.konsultasi.index'));

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mengajukan konsultasi "' . $validated['topik'] . '" via ' . ($validated['mode'] === 'online' ? 'online (' . $validated['media'] . ')' : 'offline'), 'Konsultasi', $konsultasi->id_konsultasi);

        return redirect()->route('pelanggan.konsultasi.index')
            ->with('message', 'Permintaan konsultasi terkirim. Silakan tunggu konfirmasi dari kasir.');
    }
}
