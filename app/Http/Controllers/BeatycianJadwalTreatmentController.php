<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\RiwayatTreatment;
use App\Helpers\ActivityLogger;
use Carbon\Carbon;

class BeatycianJadwalTreatmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter_status = $request->input('filter_status');

        $user = auth()->user();
        $id_karyawan = $user->id;

        $query = Booking::with(['detail.layanan', 'karyawan', 'pelanggan'])
            ->where('id_karyawan', $id_karyawan)
            ->where('status', 'dikonfirmasi')
            ->whereDate('tanggal', '>=', now()->toDateString());

        if ($filter_status) {
            $query->where('status', $filter_status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q2) use ($search) {
                        $q2->where('nm_pelanggan', 'like', "%{$search}%");
                    });
            });
        }

        $jadwal = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)->withQueryString();

        $total_jadwal = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dikonfirmasi')->whereDate('tanggal', '>=', now()->toDateString())->count();
        $dikonfirmasi = $total_jadwal;
        $diproses = Booking::where('id_karyawan', $id_karyawan)->where('status', 'diproses')->whereDate('tanggal', now()->toDateString())->count();
        $selesai = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')->whereDate('tanggal', now()->toDateString())->count();
        $dibatalkan = Booking::where('id_karyawan', $id_karyawan)->where('status', 'dibatalkan')->whereDate('tanggal', now()->toDateString())->count();

        return view('beautycian.jadwal-treatment.index', compact(
            'jadwal', 'search',
            'total_jadwal', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'
        ));
    }

    public function updateStatus(Request $request)
    {
        $request->validate(['id_booking' => 'required|exists:booking,id_booking']);

        $booking = Booking::where('id_booking', $request->id_booking)
            ->where('id_karyawan', auth()->id())
            ->firstOrFail();

        if ($booking->status === 'dikonfirmasi') {
            $booking->update(['status' => 'diproses']);
            ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' memulai treatment booking #' . $booking->id_booking, 'Reservasi', $booking->id_booking);
            return back()->with('message', 'Treatment telah dimulai!');
        }

        if ($booking->status === 'diproses') {
            $booking->update(['status' => 'selesai']);
            ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' menyelesaikan treatment booking #' . $booking->id_booking, 'Reservasi', $booking->id_booking);
            $this->notifTreatmentSelesai($booking);
            return back()->with('message', 'Treatment telah selesai!');
        }

        return back()->with('error', 'Status tidak valid untuk diubah.');
    }

    public function statusTreatment()
    {
        $user = auth()->user();
        $id_karyawan = $user->id;
        $today = now()->toDateString();

        $akanDimulai = Booking::with(['detail.layanan', 'pelanggan', 'riwayatTreatment'])
            ->where('id_karyawan', $id_karyawan)
            ->where('status', 'dikonfirmasi')
            ->whereDate('tanggal', $today)
            ->orderBy('jam')
            ->get();

        $sedangBerjalan = Booking::with(['detail.layanan', 'pelanggan', 'riwayatTreatment'])
            ->where('id_karyawan', $id_karyawan)
            ->where('status', 'diproses')
            ->whereDate('tanggal', $today)
            ->orderBy('jam')
            ->get();

        $selesaiHariIni = Booking::with(['detail.layanan', 'pelanggan', 'riwayatTreatment'])
            ->where('id_karyawan', $id_karyawan)
            ->where('status', 'selesai')
            ->whereDate('tanggal', $today)
            ->orderBy('jam')
            ->get();

        $now = Carbon::now();

        $akanDimulai = $akanDimulai->map(function ($b) use ($now) {
            $jamMulai = Carbon::parse($b->jam);
            $b->terlambatMenit = $jamMulai->lessThan($now) ? (int) $jamMulai->diffInMinutes($now) : 0;
            return $b;
        });

        $sedangBerjalan = $sedangBerjalan->map(function ($b) use ($now) {
            $jamMulai = Carbon::parse($b->jam);
            $b->berjalanMenit = $jamMulai->lessThan($now) ? (int) $jamMulai->diffInMinutes($now) : 0;
            return $b;
        });

        $totalAkanDimulai = $akanDimulai->count();
        $totalDiproses = $sedangBerjalan->count();
        $totalSelesai = $selesaiHariIni->count();

        return view('beautycian.status-treatment.index', compact(
            'akanDimulai', 'sedangBerjalan', 'selesaiHariIni',
            'totalAkanDimulai', 'totalDiproses', 'totalSelesai'
        ));
    }

    public function completeWithDoc(Request $request)
    {
        $request->validate(['id_booking' => 'required|exists:booking,id_booking']);

        $booking = Booking::where('id_booking', $request->id_booking)
            ->where('id_karyawan', auth()->id())
            ->firstOrFail();

        if ($booking->status === 'diproses' || $booking->status === 'selesai') {
            $booking->update(['status' => 'selesai']);
            ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' menyelesaikan treatment booking #' . $booking->id_booking, 'Reservasi', $booking->id_booking);
            $this->notifTreatmentSelesai($booking);
            return back()->with('message', 'Treatment telah diselesaikan!');
        }

        return back()->with('error', 'Status tidak valid untuk diubah.');
    }

    public function riwayatTreatment(Request $request)
    {
        $search = $request->input('search');
        $filter_bulan = $request->input('filter_bulan');

        $user = auth()->user();
        $id_karyawan = $user->id;

        $query = Booking::with(['detail.layanan', 'pelanggan', 'riwayatTreatment'])
            ->where('id_karyawan', $id_karyawan)
            ->where('status', 'selesai');

        if ($filter_bulan) {
            $query->whereMonth('tanggal', $filter_bulan);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('pelanggan', function ($q2) use ($search) {
                    $q2->where('nm_pelanggan', 'like', "%{$search}%");
                });
            });
        }

        $riwayat = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)->withQueryString();

        $total_selesai = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')->count();
        $total_bulan_ini = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')
            ->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count();
        $total_minggu_ini = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')
            ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $total_dengan_dokumen = Booking::where('id_karyawan', $id_karyawan)->where('status', 'selesai')
            ->whereHas('riwayatTreatment')->count();

        return view('beautycian.riwayat-treatment.index', compact(
            'riwayat', 'search',
            'total_selesai', 'total_bulan_ini', 'total_minggu_ini', 'total_dengan_dokumen'
        ));
    }

    public function showRiwayat($id)
    {
        $user = auth()->user();
        $id_karyawan = $user->id;

        $booking = Booking::with(['detail.layanan', 'pelanggan', 'riwayatTreatment', 'transaksi'])
            ->where('id_karyawan', $id_karyawan)
            ->findOrFail($id);

        $statusLabels = [
            'dikonfirmasi' => 'Terjadwal',
            'diproses'     => 'Diproses',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
        ];

        return view('beautycian.riwayat-treatment.show', compact('booking', 'statusLabels'));
    }

    public function storeDokumentasi(Request $request)
    {
        $request->validate([
            'id_booking' => 'required|exists:booking,id_booking',
            'sebelum_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'sesudah_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'produk_digunakan' => 'nullable|string|max:1000',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $booking = Booking::where('id_booking', $request->id_booking)
            ->where('id_karyawan', auth()->id())
            ->firstOrFail();

        $data = [];
        if ($request->hasFile('sebelum_foto')) {
            $data['sebelum_foto'] = $request->file('sebelum_foto')->store('dokumentasi-treatment', 'public');
        }
        if ($request->hasFile('sesudah_foto')) {
            $data['sesudah_foto'] = $request->file('sesudah_foto')->store('dokumentasi-treatment', 'public');
        }
        if ($request->produk_digunakan) {
            $data['produk_digunakan'] = $request->produk_digunakan;
        }
        if ($request->catatan) {
            $data['catatan'] = $request->catatan;
        }
        $data['id_booking'] = $booking->id_booking;

        RiwayatTreatment::updateOrCreate(
            ['id_booking' => $booking->id_booking],
            $data
        );

        $booking->update(['status' => 'selesai']);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menyimpan dokumentasi treatment booking #' . $booking->id_booking, 'Dokumentasi', $booking->id_booking);

        $this->notifTreatmentSelesai($booking);

        return back()->with('message', 'Dokumentasi treatment berhasil disimpan!');
    }

    private function notifTreatmentSelesai($booking)
    {
        $nama = $booking->pelanggan->nm_pelanggan ?? 'Pelanggan';
        $isi = 'Treatment ' . $nama . ' telah diselesaikan.';

        buatNotifRole('kasir', 'Treatment Selesai', $isi, 'Booking', route('kasir.checkin.index'));

        $pelanggan = $booking->pelanggan;
        if ($pelanggan && $pelanggan->id_user) {
            buatNotif($pelanggan->id_user, 'Treatment Selesai', 'Treatment Anda telah selesai. Terima kasih!', 'Booking', route('pelanggan.booking'));
        }
    }
}
