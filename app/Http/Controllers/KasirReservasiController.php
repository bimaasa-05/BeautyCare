<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\User;
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
        $reservasi = Booking::with('pelanggan', 'karyawan')
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
        $pelanggan = Pelanggan::all();
        $karyawan = User::where('role', 'beautycian')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        return view('kasir.reservasi.create', compact('pelanggan', 'karyawan', 'layanan'));
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

        buatNotif(auth()->user()->id, 'Reservasi Baru', 'Reservasi untuk ' . ($booking->pelanggan->nm_pelanggan ?? 'Pelanggan') . ' berhasil dibuat', 'Booking', route('kasir.reservasi.show', $booking->id_booking));

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
        $pelanggan = Pelanggan::all();
        $karyawan = User::where('role', 'beautycian')->get();
        $layanan = Layanan::where('status', 'Tersedia')->get();
        return view('kasir.reservasi.edit', compact('reservasi', 'pelanggan', 'karyawan', 'layanan'));
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

        Booking::where('id_booking', $id)->update([
            'id_pelanggan' => $request->id_pelanggan,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => $request->status,
            'catatan' => $request->catatan ?? '',
        ]);

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

        return redirect('kasir/reservasi')->with('message', 'Reservasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        DetailBooking::where('id_booking', $id)->delete();
        Booking::findOrFail($id)->delete();
        return redirect('/kasir/reservasi')->with('message', 'Reservasi berhasil dihapus');
    }

    public function getLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        return response()->json($layanan);
    }
}
