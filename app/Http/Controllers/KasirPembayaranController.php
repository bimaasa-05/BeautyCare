<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\DB;

class KasirPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $bookedIds = Transaksi::whereNotNull('id_booking')->pluck('id_booking');

        $search = $request->keyword;

        $reservasiSelesai = Booking::with(['pelanggan', 'detail.layanan'])
            ->whereIn('status', ['diproses', 'selesai'])
            ->whereNotIn('id_booking', $bookedIds)
            ->when($search, function ($query, $search) {
                return $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nm_pelanggan', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalTagihan = Booking::whereIn('status', ['diproses', 'selesai'])->whereNotIn('id_booking', $bookedIds)
            ->when($search, function ($query, $search) {
                return $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nm_pelanggan', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->count();

        $totalSudahDibayar = Transaksi::where('status', 'Lunas')->count();

        return view('kasir.pembayaran.index', compact('reservasiSelesai', 'totalTagihan', 'totalSudahDibayar'));
    }

    public function create($id)
    {
        $booking = Booking::with(['pelanggan', 'karyawan', 'detail.layanan'])->findOrFail($id);

        if (!in_array($booking->status, ['diproses', 'selesai'])) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking belum check-in, tidak bisa diproses');
        }

        $transaksiExists = Transaksi::where('id_booking', $id)->exists();
        if ($transaksiExists) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking ini sudah memiliki pembayaran');
        }

        $bankTujuan = [
            'BRI' => '10101010',
            'BCA' => '20202020',
            'Mandiri' => '30303030',
            'BNI' => '40404040',
            'BSI' => '50505050',
        ];

        return view('kasir.pembayaran.create', compact('booking', 'bankTujuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_booking' => 'required|integer|exists:booking,id_booking',
            'metode_byr' => 'required|in:Tunai,Transfer,Debit,E-Wallet',
            'total' => 'required|numeric|min:0',
            'dibayar' => 'required|numeric|min:0|gte:total',
            'catatan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'atas_nama' => 'nullable|string|max:100',
            'dari_rekening' => 'nullable|string|max:50',
            'ke_rekening' => 'nullable|string|max:50',
            'bank_asal' => 'nullable|string|max:50',
            'bank_tujuan' => 'nullable|string|max:50',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|string|max:50',
        ]);

        $booking = Booking::with(['pelanggan', 'detail.layanan'])->findOrFail($request->id_booking);

        $transaksiExists = Transaksi::where('id_booking', $request->id_booking)->exists();
        if ($transaksiExists) {
            return redirect()->route('kasir.pembayaran.index')->with('error', 'Booking ini sudah memiliki pembayaran');
        }

        $total = $request->total;
        $dibayar = $request->dibayar;
        $kembali = max(0, $dibayar - $total);

        $statusPembayaran = in_array($request->metode_byr, ['Tunai', 'E-Wallet']) ? 'Lunas' : 'Pending';

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $buktiBayar = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiBayar = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        $transaksi = Transaksi::create([
            'id_booking' => $request->id_booking,
            'id_pelanggan' => $booking->id_pelanggan,
            'id_user' => auth()->id(),
            'no_invoice' => $no_invoice,
            'tanggal' => date('Y-m-d'),
            'subtotal' => $total,
            'diskon' => 0,
            'pajak' => 0,
            'total' => $total,
            'metode_byr' => $request->metode_byr,
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'catatan' => $request->catatan ?? '',
            'status' => $statusPembayaran,
            'bukti_bayar' => $buktiBayar,
            'atas_nama' => $request->atas_nama,
            'dari_rekening' => $request->dari_rekening,
            'ke_rekening' => $request->ke_rekening,
            'bank_asal' => $request->bank_asal ?? $request->ewallet_type,
            'bank_tujuan' => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ]);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan pembayaran ' . $no_invoice, 'Pembayaran', $transaksi->id_transaksi);

        foreach ($booking->detail as $d) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis' => 'Layanan',
                'id_item' => $d->id_layanan,
                'nm_item' => $d->layanan->nm_layanan ?? 'Layanan',
                'qty' => 1,
                'harga' => $d->harga,
                'diskon' => $d->diskon ?? 0,
                'subtotal' => ($d->harga ?? 0) - ($d->diskon ?? 0),
            ]);
        }

        Booking::where('id_booking', $request->id_booking)->update(['status' => 'selesai']);

        buatNotif(auth()->user()->id, 'Pembayaran Berhasil', 'Pembayaran ' . $no_invoice . ' berhasil diproses (' . $request->metode_byr . ')', 'Transaksi', route('kasir.pembayaran.show', $transaksi->id_transaksi));

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Pembayaran Masuk', 'Pembayaran ' . $no_invoice . ' oleh ' . auth()->user()->nama . ' (' . $request->metode_byr . ')', 'Transaksi', url('/admin/dashboard'));
        }

        return redirect()->route('kasir.pembayaran.show', $transaksi->id_transaksi)
            ->with('message', 'Pembayaran berhasil diproses');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'user', 'detail'])->findOrFail($id);
        return view('kasir.pembayaran.show', compact('transaksi'));
    }
}
