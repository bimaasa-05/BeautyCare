<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\User;
use App\Helpers\ActivityLogger;
use App\Support\BookingSlot;
use Illuminate\Http\Request;

class KasirReservasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;

        $TotalReservasi = Booking::count();
        $totalMenunggu = Booking::where('status', 'menunggu')->count();
        $totalSelesai = Booking::where('status', 'selesai')->count();
        $totalDiproses = Booking::where('status', 'diproses')->count();
        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')
            ->when($search, function ($query, $search) {
                return $query->where('tanggal', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q) use ($search) {
                        $q->where('nm_pelanggan', 'like', "%{$search}%");
                    });
            })->orderBy('id_booking', 'desc')->paginate(10);

        return view('kasir.reservasi.index', compact('reservasi', 'TotalReservasi', 'totalMenunggu', 'totalSelesai', 'totalDiproses'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::with('membership')->get();
        $karyawan = User::where('role', 'beautycian')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        $slotJam = BookingSlot::slotJam();
        $bookedJamByKaryawan = BookingSlot::blokirJamKaryawan(request('tanggal', now()->toDateString()));
        $sedangMelayaniDetail = BookingSlot::sedangMelayaniDetail();
        return view('kasir.reservasi.create', compact('pelanggan', 'karyawan', 'layanan', 'slotJam', 'bookedJamByKaryawan', 'sedangMelayaniDetail'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga' => array_map(fn ($h) => (string) preg_replace('/[^0-9]/', '', $h), $request->input('harga', [])),
            'diskon' => array_map(fn ($h) => (string) preg_replace('/[^0-9]/', '', $h), $request->input('diskon', [])),
        ]);

        $request->validate([
            'id_pelanggan' => 'required|integer',
            'id_karyawan' => 'required|integer',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'status' => 'required|in:menunggu,dikonfirmasi,diproses,selesai,dibatalkan',
            'catatan' => 'nullable|string',
            'id_layanan' => 'required|array|min:1',
            'id_layanan.*' => 'required|integer',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'diskon' => 'nullable|array',
            'diskon.*' => 'nullable|numeric|min:0',
        ]);

        $jam = BookingSlot::normalJam($request->jam);

        if (!BookingSlot::validJamSlot($jam)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam harus berada dalam jam operasional toko (' . BookingSlot::formatJamIndo(BookingSlot::jamBuka()) . ' - ' . BookingSlot::formatJamIndo(BookingSlot::jamTutup()) . ').']);
        }

        if ($request->tanggal < now()->toDateString()) {
            return redirect()->back()->withInput()->withErrors(['tanggal' => 'Tanggal booking tidak boleh di masa lalu.']);
        }

        if (in_array($request->status, ['diproses', 'selesai']) && $request->tanggal . ' ' . $jam > now()) {
            return redirect()->back()->withInput()->withErrors(['status' => 'Status ' . $request->status . ' tidak valid untuk jadwal yang akan datang.']);
        }

        $durasi = (int) Layanan::whereIn('id_layanan', $request->id_layanan)->sum('durasi');
        if (BookingSlot::jamBentrok($request->id_karyawan, $request->tanggal, $jam, null, $durasi)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam tersebut sudah dibooking untuk terapis yang dipilih (sudah memperhitungkan durasi layanan). Silakan pilih jam lain.']);
        }

        $booking = Booking::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $jam,
            'status' => $request->status,
            'catatan' => $request->catatan ?? '',
        ]);

        foreach ($request->id_layanan as $i => $id_layanan) {
            $harga = (int) str_replace('.', '', $request->harga[$i] ?? '0');
            $diskon = (int) str_replace('.', '', $request->diskon[$i] ?? '0');
            $subtotal = $harga - $diskon;

            DetailBooking::create([
                'id_booking' => $booking->id_booking,
                'id_layanan' => $id_layanan,
                'harga' => $harga,
                'diskon' => $diskon,
                'subtotal' => $subtotal,
            ]);
        }

        buatNotif(auth()->user()->id, 'Reservasi Baru', 'Reservasi untuk ' . ($booking->pelanggan->nm_pelanggan ?? 'Pelanggan') . ' berhasil dibuat', 'Booking', route('kasir.reservasi.show', $booking->id_booking));

        if ($booking->id_karyawan && $booking->status === 'dikonfirmasi') {
            buatNotif($booking->id_karyawan, 'Jadwal Treatment Baru', 'Reservasi untuk ' . ($booking->pelanggan->nm_pelanggan ?? 'Pelanggan') . ' pada ' . $booking->tanggal . ' ' . $booking->jam . '.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Reservasi Baru', 'Reservasi baru oleh ' . auth()->user()->nama . ' untuk ' . ($booking->pelanggan->nm_pelanggan ?? 'Pelanggan'), 'Booking', url('/admin/dashboard'));
        }

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan reservasi untuk ' . ($booking->pelanggan->nm_pelanggan ?? 'Pelanggan'), 'Reservasi', $booking->id_booking);

        return redirect('kasir/reservasi')->with('message', 'Reservasi berhasil dibuat');
    }

    public function show($id)
    {
        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')->findOrFail($id);
        return view('kasir.reservasi.show', compact('reservasi'));
    }

    public function edit($id)
    {
        $reservasi = Booking::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::with('membership')->get();
        $karyawan = User::where('role', 'beautycian')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        $slotJam = BookingSlot::slotJam();
        $bookedJamByKaryawan = BookingSlot::blokirJamKaryawan($reservasi->tanggal, $reservasi->id_booking);
        $sedangMelayaniDetail = BookingSlot::sedangMelayaniDetail();
        return view('kasir.reservasi.edit', compact('reservasi', 'pelanggan', 'karyawan', 'layanan', 'slotJam', 'bookedJamByKaryawan', 'sedangMelayaniDetail'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'harga' => array_map(fn ($h) => (string) preg_replace('/[^0-9]/', '', $h), $request->input('harga', [])),
            'diskon' => array_map(fn ($h) => (string) preg_replace('/[^0-9]/', '', $h), $request->input('diskon', [])),
        ]);

        $request->validate([
            'id_pelanggan' => 'required|integer',
            'id_karyawan' => 'required|integer',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'status' => 'required|in:menunggu,dikonfirmasi,diproses,selesai,dibatalkan',
            'catatan' => 'nullable|string',
            'id_layanan' => 'required|array|min:1',
            'id_layanan.*' => 'required|integer',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'diskon' => 'nullable|array',
            'diskon.*' => 'nullable|numeric|min:0',
        ]);

        $bookingLama = Booking::with('pelanggan')->findOrFail($id);

        $jam = BookingSlot::normalJam($request->jam);

        if (!BookingSlot::validJamSlot($jam)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam harus berada dalam jam operasional toko (' . BookingSlot::formatJamIndo(BookingSlot::jamBuka()) . ' - ' . BookingSlot::formatJamIndo(BookingSlot::jamTutup()) . ').']);
        }

        if ($request->tanggal < now()->toDateString()) {
            return redirect()->back()->withInput()->withErrors(['tanggal' => 'Tanggal booking tidak boleh di masa lalu.']);
        }

        if (in_array($request->status, ['diproses', 'selesai']) && $request->tanggal . ' ' . $jam > now()) {
            return redirect()->back()->withInput()->withErrors(['status' => 'Status ' . $request->status . ' tidak valid untuk jadwal yang akan datang.']);
        }

        $durasi = (int) Layanan::whereIn('id_layanan', $request->id_layanan)->sum('durasi');
        if (BookingSlot::jamBentrok($request->id_karyawan, $request->tanggal, $jam, $id, $durasi)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam tersebut sudah dibooking untuk terapis yang dipilih (sudah memperhitungkan durasi layanan). Silakan pilih jam lain.']);
        }

        $dataBooking = [
            'id_pelanggan' => $request->id_pelanggan,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $jam,
            'status' => $request->status,
            'catatan' => $request->catatan ?? '',
        ];

        $dataLama = $bookingLama->toArray();

        Booking::where('id_booking', $id)->update($dataBooking);

        DetailBooking::where('id_booking', $id)->delete();

        foreach ($request->id_layanan as $i => $id_layanan) {
            $harga = (int) str_replace('.', '', $request->harga[$i] ?? '0');
            $diskon = (int) str_replace('.', '', $request->diskon[$i] ?? '0');
            $subtotal = $harga - $diskon;

            DetailBooking::create([
                'id_booking' => $id,
                'id_layanan' => $id_layanan,
                'harga' => $harga,
                'diskon' => $diskon,
                'subtotal' => $subtotal,
            ]);
        }

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT), 'Reservasi', $id, $dataLama, $dataBooking);

        buatNotif(auth()->user()->id, 'Reservasi Diperbarui', 'Reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT) . ' berhasil diperbarui', 'Booking', route('kasir.reservasi.index'));

        if ($request->id_karyawan && $request->status === 'dikonfirmasi') {
            buatNotif($request->id_karyawan, 'Jadwal Treatment Diperbarui', 'Reservasi untuk ' . ($bookingLama->pelanggan->nm_pelanggan ?? 'Pelanggan') . ' diubah menjadi ' . $request->tanggal . ' ' . $request->jam . '.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        if ($bookingLama->id_karyawan && $bookingLama->id_karyawan != $request->id_karyawan && $request->status === 'dikonfirmasi') {
            buatNotif($bookingLama->id_karyawan, 'Booking Dipindahkan', 'Booking ' . ($bookingLama->pelanggan->nm_pelanggan ?? '-') . ' dipindahkan ke terapis lain.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        return redirect('kasir/reservasi')->with('message', 'Reservasi berhasil diperbarui');
    }

    public function konfirmasi($id)
    {
        $booking = Booking::with('pelanggan')->findOrFail($id);

        if (!in_array($booking->status, ['menunggu'])) {
            return redirect()->back()->with('error', 'Only pending bookings can be confirmed');
        }

        $booking->update(['status' => 'dikonfirmasi']);

        ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' mengkonfirmasi reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT), 'Reservasi', $id);

        buatNotif(auth()->id(), 'Booking Dikonfirmasi', 'Booking ' . ($booking->pelanggan->nm_pelanggan ?? '-') . ' telah dikonfirmasi', 'Booking', route('kasir.reservasi.show', $id));

        $pelanggan = $booking->pelanggan;
        if ($pelanggan && $pelanggan->id_user) {
            buatNotif($pelanggan->id_user, 'Booking Dikonfirmasi', 'Booking treatment Anda telah dikonfirmasi untuk ' . $booking->tanggal . ' ' . $booking->jam . '.', 'Booking', route('pelanggan.booking'));
        }

        if ($booking->id_karyawan) {
            buatNotif($booking->id_karyawan, 'Booking Dikonfirmasi', 'Booking ' . ($pelanggan->nm_pelanggan ?? '-') . ' telah dikonfirmasi. Segera siapkan treatment.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $pelangganUser = $booking->pelanggan?->id_user;
        $karyawanId = $booking->id_karyawan;
        $nmPelanggan = $booking->pelanggan?->nm_pelanggan ?? '-';
        $tanggalJam = $booking->tanggal . ' ' . $booking->jam;

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT), 'Reservasi', $id);
        DetailBooking::where('id_booking', $id)->delete();
        $booking->delete();

        buatNotif(auth()->user()->id, 'Reservasi Dihapus', 'Reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT) . ' berhasil dihapus', 'Booking', route('kasir.reservasi.index'));

        if ($karyawanId) {
            buatNotif($karyawanId, 'Reservasi Dibatalkan', 'Reservasi ' . $nmPelanggan . ' (' . $tanggalJam . ') dibatalkan oleh kasir.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        if ($pelangganUser) {
            buatNotif($pelangganUser, 'Reservasi Dibatalkan', 'Reservasi Anda pada ' . $tanggalJam . ' dibatalkan oleh kasir.', 'Booking', route('pelanggan.booking'));
        }

        return redirect('/kasir/reservasi')->with('message', 'Reservasi berhasil dihapus');
    }

    public function getLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        return response()->json($layanan);
    }

    public function slotData(Request $request)
    {
        $tanggal = $request->tanggal ?: now()->toDateString();
        return response()->json([
            'slots' => BookingSlot::slotJam(),
            'booked' => BookingSlot::blokirJamKaryawan($tanggal, $request->except),
        ]);
    }
}
