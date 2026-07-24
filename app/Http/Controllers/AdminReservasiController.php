<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\User;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class AdminReservasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;

        $TotalReservasi = Booking::count();
        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')
            ->when($search, function ($query, $search) {
                return $query->where('tanggal', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q) use ($search) {
                        $q->where('nm_pelanggan', 'like', "%{$search}%");
                    });
            })
            ->when($request->filled('id_karyawan'), function ($query) use ($request) {
                return $query->where('id_karyawan', $request->id_karyawan);
            })
            ->orderBy('id_booking', 'desc')->paginate(10);

        return view('admin.reservasi.index', compact('reservasi', 'TotalReservasi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $karyawan = User::where('role', 'beautycian')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        return view('admin.reservasi.create', compact('pelanggan', 'karyawan', 'layanan'));
    }

    public function store(Request $request)
    {
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

        $booking = Booking::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => $request->status,
            'catatan' => $request->catatan ?? '',
        ]);

        foreach ($request->id_layanan as $i => $id_layanan) {
            $harga = $request->harga[$i] ?? 0;
            $diskon = $request->diskon[$i] ?? 0;
            $subtotal = $harga - $diskon;

            DetailBooking::create([
                'id_booking' => $booking->id_booking,
                'id_layanan' => $id_layanan,
                'harga' => $harga,
                'diskon' => $diskon,
                'subtotal' => $subtotal,
            ]);
        }

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan reservasi untuk ' . ($booking->pelanggan->nm_pelanggan ?? 'Pelanggan'), 'Reservasi', $booking->id_booking);

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dibuat');
    }

    public function show($id)
    {
        $reservasi = Booking::with('pelanggan', 'karyawan', 'detail.layanan')->findOrFail($id);
        return view('admin.reservasi.show', compact('reservasi'));
    }

    public function edit($id)
    {
        $reservasi = Booking::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $karyawan = User::where('role', 'beautycian')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        return view('admin.reservasi.edit', compact('reservasi', 'pelanggan', 'karyawan', 'layanan'));
    }

    public function update(Request $request, $id)
    {
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

        $dataBooking = [
            'id_pelanggan' => $request->id_pelanggan,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => $request->status,
            'catatan' => $request->catatan ?? '',
        ];

        $bookingLama = Booking::with('pelanggan')->findOrFail($id);
        $dataLama = $bookingLama->toArray();

        Booking::where('id_booking', $id)->update($dataBooking);

        DetailBooking::where('id_booking', $id)->delete();

        foreach ($request->id_layanan as $i => $id_layanan) {
            $harga = $request->harga[$i] ?? 0;
            $diskon = $request->diskon[$i] ?? 0;
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

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil diperbarui');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,diproses,selesai,dibatalkan',
        ]);

        $bookingLama = Booking::findOrFail($id);
        $statusLama = $bookingLama->status;

        Booking::where('id_booking', $id)->update([
            'status' => $request->status,
        ]);

        ActivityLogger::log('Mengubah Status', auth()->user()->nama . ' mengubah status reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT) . ' dari ' . $statusLama . ' menjadi ' . $request->status, 'Reservasi', $id);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus reservasi #' . str_pad($id, 3, '0', STR_PAD_LEFT), 'Reservasi', $id);
        DetailBooking::where('id_booking', $id)->delete();
        $booking->delete();
        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus');
    }

    public function getLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        return response()->json($layanan);
    }
}
