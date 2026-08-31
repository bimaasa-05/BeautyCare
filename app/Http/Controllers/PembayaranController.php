<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    protected function getTransaksi($id)
    {
        $transaksi = Transaksi::with(['detail', 'pembayaran.bank'])->findOrFail($id);

        abort_unless((int) $transaksi->id_user === (int) auth()->id() && $transaksi->sumber === 'online', 403);

        return $transaksi;
    }

    public function show($id)
    {
        $transaksi = $this->getTransaksi($id);

        if (in_array($transaksi->status, ['Lunas', 'DP Dibayar', 'Gagal', 'Kadaluarsa', 'Dibatalkan'])) {
            if ($transaksi->jenis_transaksi === 'TopUp Saldo') {
                return redirect()->route('pelanggan.saldo.index');
            }
            if ($transaksi->id_booking) {
                return redirect()->route('pelanggan.booking.detail', $transaksi->id_booking);
            }
            return redirect()->route('pelanggan.pesanan.show', $id);
        }

        // Ensure pembayaran exists
        if (!$transaksi->pembayaran) {
            return redirect()->route('pelanggan.pesanan.show', $id)
                ->with('error', 'Data pembayaran tidak ditemukan untuk pesanan ini.');
        }

        $bankTujuan = CheckoutController::bankTujuan();
        $demoMode = env('CHECKOUT_DEMO_MODE', false);
        $qrisImage = public_path('assets/img/qris-merchant.png');

        return view('pelanggan.pembayaran.show', compact('transaksi', 'bankTujuan', 'demoMode', 'qrisImage'));
    }

    public function berhasil($id)
    {
        $transaksi = $this->getTransaksi($id);

        if (!in_array($transaksi->status, ['Lunas', 'DP Dibayar'])) {
            if ($transaksi->id_booking) {
                return redirect()->route('pelanggan.booking.detail', $transaksi->id_booking);
            }
            return redirect()->route('pelanggan.pesanan.show', $id);
        }

        if ($transaksi->jenis_transaksi === 'TopUp Saldo') {
            return view('pelanggan.pembayaran.berhasil-topup', compact('transaksi'));
        }

        return view('pelanggan.pembayaran.berhasil', compact('transaksi'));
    }

    public function status($id)
    {
        $transaksi = $this->getTransaksi($id);
        $pembayaran = $transaksi->pembayaran;

        return response()->json([
            'status' => $transaksi->status,
            'payment_status' => $pembayaran->status ?? null,
            'expires_at' => $pembayaran ? $pembayaran->expires_at->toIso8601String() : null,
            'paid_at' => $pembayaran && $pembayaran->paid_at ? $pembayaran->paid_at->toIso8601String() : null,
            'no_referensi' => $pembayaran->no_referensi ?? null,
        ]);
    }

    public function sudahBayar(Request $request, $id)
    {
        $transaksi = $this->getTransaksi($id);

        if ($transaksi->status !== 'Menunggu Pembayaran') {
            return back()->with('error', 'Status pesanan tidak valid untuk konfirmasi.');
        }

        if (!$transaksi->bukti_bayar) {
            return back()->with('error', 'Anda harus mengunggah bukti pembayaran terlebih dahulu.');
        }

        $transaksi->update(['status' => 'Sedang Diproses']);

        $petugas = \App\Models\User::whereIn('role', ['kasir', 'admin'])->get();
        foreach ($petugas as $petugasUser) {
            buatNotif($petugasUser->id, 'Menunggu Verifikasi', 'Pelanggan mengklaim sudah membayar pesanan ' . $transaksi->no_invoice . '. Segera verifikasi.', 'Transaksi', route('kasir.pembayaran.pesanan-online'));
        }

        return back()->with('message', 'Konfirmasi pembayaran terkirim. Silakan tunggu verifikasi kasir.');
    }

    public function perpanjang(Request $request, $id)
    {
        $transaksi = $this->getTransaksi($id);

        if (!in_array($transaksi->status, ['Menunggu Pembayaran', 'Kadaluarsa'])) {
            return back()->with('error', 'Pesanan tidak bisa diperpanjang pada status ini.');
        }

        $metode = $transaksi->pembayaran?->metode ?? $transaksi->metode_byr;
        $expiresAt = in_array($metode, ['QRIS', 'E-Wallet'])
            ? now()->addMinutes(3) //Memulai Hitungan Mundur lagi dalam 3 Menit
            : now()->addHours(24); //Memulai Hitungan Mundur lagi dalam 24 Jam

        // Saldo yang dikembalikan saat kadaluarsa harus didebit ulang saat perpanjang
        if ($transaksi->status === 'Kadaluarsa') {
            $saldoTerpakai = (float) ($transaksi->saldo_terpakai ?? 0);
            if ($saldoTerpakai > 0 && $transaksi->id_pelanggan) {
                $debitUlang = (new \App\Services\SaldoAkunService())->pakaiSaldo(
                    $transaksi->id_pelanggan,
                    $saldoTerpakai,
                    $transaksi->id_transaksi,
                    'transaksi',
                    'Saldo dipakai ulang (perpanjang batas waktu) INV ' . $transaksi->no_invoice
                );
                if (!$debitUlang) {
                    return back()->with('error', 'Saldo akun Anda tidak cukup untuk kembali menggunakan saldo sebesar Rp ' . number_format($saldoTerpakai, 0, ',', '.') . '. Silakan isi saldo terlebih dahulu atau pilih metode lain.');
                }
            }

            $transaksi->update(['status' => 'Menunggu Pembayaran']);
        }

        $transaksi->pembayaran?->update([
            'status' => 'Menunggu',
            'expires_at' => $expiresAt,
        ]);

        if ($transaksi->status === 'Kadaluarsa') {
            $transaksi->update(['status' => 'Menunggu Pembayaran']);
        }

        buatNotif($transaksi->id_user, 'Waktu Diperpanjang', 'Batas waktu pembayaran pesanan ' . $transaksi->no_invoice . ' diperpanjang. Silakan selesaikan pembayaran.', 'Transaksi', route('pelanggan.pembayaran.show', $transaksi->id_transaksi));

        return redirect()->route('pelanggan.pembayaran.show', $transaksi->id_transaksi)
            ->with('message', 'Batas waktu pembayaran diperpanjang. Silakan selesaikan pembayaran sebelum waktu habis.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $transaksi = $this->getTransaksi($id);

        if (!in_array($transaksi->status, ['Menunggu Pembayaran', 'Sedang Diproses'])) {
            return back()->with('error', 'Bukti bayar hanya bisa diunggah sebelum pesanan lunas.');
        }

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_bayar.required' => 'Pilih file bukti pembayaran terlebih dahulu.',
            'bukti_bayar.image' => 'File harus berupa gambar.',
            'bukti_bayar.mimes' => 'Format gambar harus JPG/JPEG/PNG.',
            'bukti_bayar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($transaksi->bukti_bayar) {
            Storage::disk('public')->delete($transaksi->bukti_bayar);
        }

        $path = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');

        $transaksi->update(['bukti_bayar' => $path]);

        return back()->with('message', 'Bukti pembayaran berhasil diunggah. Klik "Saya Sudah Bayar" untuk mengirim konfirmasi ke kasir.');
    }

    public function batal(Request $request, $id)
    {
        $transaksi = $this->getTransaksi($id);

        if (!in_array($transaksi->status, ['Menunggu Pembayaran', 'Kadaluarsa'])) {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini.');
        }

        $saldoTerpakai = (float) ($transaksi->saldo_terpakai ?? 0);
        if ($saldoTerpakai > 0 && $transaksi->id_pelanggan) {
            (new \App\Services\SaldoAkunService())->kreditRefund(
                $transaksi->id_pelanggan,
                $saldoTerpakai,
                $transaksi->id_transaksi,
                'Pengembalian saldo — pesanan dibatalkan (INV ' . $transaksi->no_invoice . ')'
            );
        }

        $transaksi->update(['status' => 'Dibatalkan']);
        $transaksi->pembayaran?->update(['status' => 'Dibatalkan']);

        if ($transaksi->id_booking) {
            \App\Models\Booking::where('id_booking', $transaksi->id_booking)->update(['status_pembayaran' => 'belum']);
        }

        $nama = $transaksi->user->nama ?? 'Pelanggan';
        buatNotifRole('kasir', 'Pesanan Dibatalkan', $nama . ' membatalkan pesanan ' . $transaksi->no_invoice . '.', 'Transaksi', route('kasir.pembayaran.pesanan-online'));
        ActivityLogger::log('Menghapus', $nama . ' membatalkan pesanan ' . $transaksi->no_invoice, 'Transaksi', $transaksi->id_transaksi);

        $targetPesanan = $transaksi->jenis_transaksi === 'TopUp Saldo'
            ? route('pelanggan.saldo.index')
            : route('pelanggan.pesanan.show', $transaksi->id_transaksi);

        buatNotif($transaksi->id_user, 'Pesanan Dibatalkan', 'Pesanan ' . $transaksi->no_invoice . ' berhasil dibatalkan.', 'Transaksi', $targetPesanan);

        return redirect($targetPesanan);
    }
}
