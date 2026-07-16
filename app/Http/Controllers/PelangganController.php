<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Layanan;
use App\Models\Karyawan;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $id_pelanggan = $user->id;

        $bookings = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_pelanggan', $id_pelanggan)
            ->get();

        $total_booking = $bookings->count();
        $menunggu = $bookings->where('status', 'menunggu')->count();
        $dikonfirmasi = $bookings->where('status', 'dikonfirmasi')->count();
        $selesai = $bookings->where('status', 'selesai')->count();
        $dibatalkan = $bookings->where('status', 'dibatalkan')->count();

        $search = $request->search;

        if ($search) {
            $bookings = $bookings->filter(function ($b) use ($search) {
                $keyword = strtolower($search);
                $idBooking = '#' . str_pad($b->id_booking, 3, '0', STR_PAD_LEFT);
                $namaKaryawan = $b->karyawan ? strtolower($b->karyawan->nama) : '';
                $nmLayanan = $b->detail && $b->detail->layanan ? strtolower($b->detail->layanan->nm_layanan) : '';

                return str_contains(strtolower($b->status), $keyword)
                    || str_contains(strtolower($b->tanggal), $keyword)
                    || str_contains(strtolower($b->jam), $keyword)
                    || str_contains(strtolower($b->catatan), $keyword)
                    || str_contains($namaKaryawan, $keyword)
                    || str_contains($nmLayanan, $keyword)
                    || str_contains(strtolower($idBooking), $keyword);
            });
        }

        return view('pelanggan.booking.index', compact(
            'bookings',
            'total_booking',
            'menunggu',
            'dikonfirmasi',
            'selesai',
            'dibatalkan',
            'search'
        ));
    }

    public function create()
    {
        $layanans = Layanan::where('status', 'aktif')->get();
        $karyawans = Karyawan::where('status', 1)->get();

        return view('pelanggan.booking.create', compact('layanans', 'karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required|integer|exists:layanan,id_layanan',
            'id_karyawan' => 'required|integer',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $diskon = (float) ($request->diskon ?? 0);
        $harga = (float) $request->harga;
        $subtotal = $harga - $diskon;

        $booking = Booking::create([
            'id_pelanggan' => auth()->id(),
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => 'menunggu',
            'catatan' => $request->catatan ?? '',
        ]);

        DetailBooking::create([
            'id_booking' => $booking->id_booking,
            'id_layanan' => $request->id_layanan,
            'harga' => $harga,
            'diskon' => $diskon,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('pelanggan.booking')->with('success', 'Booking berhasil dibuat!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $booking = Booking::where('id_booking', $id)
            ->where('id_pelanggan', $user->id)
            ->firstOrFail();

        $detail = DetailBooking::where('id_booking', $booking->id_booking)->first();
        $layanans = Layanan::where('status', 'aktif')->get();
        $karyawans = Karyawan::where('status', 1)->get();

        return view('pelanggan.booking.edit', compact('booking', 'detail', 'layanans', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_layanan' => 'required|integer|exists:layanan,id_layanan',
            'id_karyawan' => 'required|integer',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $booking = Booking::where('id_booking', $id)
            ->where('id_pelanggan', auth()->id())
            ->firstOrFail();

        $booking->update([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'catatan' => $request->catatan ?? '',
        ]);

        $diskon = (float) ($request->diskon ?? 0);
        $harga = (float) $request->harga;
        $subtotal = $harga - $diskon;

        DetailBooking::updateOrCreate(
            ['id_booking' => $booking->id_booking],
            [
                'id_layanan' => $request->id_layanan,
                'harga' => $harga,
                'diskon' => $diskon,
                'subtotal' => $subtotal,
            ]
        );

        return redirect()->route('pelanggan.booking')->with('success', 'Booking berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $booking = Booking::where('id_booking', $id)
            ->where('id_pelanggan', auth()->id())
            ->firstOrFail();

        DetailBooking::where('id_booking', $booking->id_booking)->delete();
        $booking->delete();

        return redirect()->route('pelanggan.booking')->with('success', 'Booking berhasil dihapus!');
    }
}
