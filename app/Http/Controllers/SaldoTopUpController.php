<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Bank;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaldoTopUpController extends Controller
{
    public function create()
    {
        $pelanggan = Pelanggan::dariUser(auth()->user());

        if (!$pelanggan) {
            return redirect()->route('pelanggan.saldo.index')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        return view('pelanggan.saldo.topup', [
            'pelanggan' => $pelanggan,
            'banks' => CheckoutController::getBanksForTransfer(),
            'bankTujuan' => CheckoutController::bankTujuan(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:10000|max:2000000',
            'metode' => 'required|in:QRIS,Transfer',
            'provider' => 'required|string|max:50',
            'bank_id' => 'nullable|required_if:metode,Transfer|integer|exists:banks,id',
        ]);

        $providers = [
            'QRIS' => ['QRIS'],
            'Transfer' => Bank::active()->transfer()->pluck('nama_bank')->toArray(),
        ];

        abort_unless(in_array($request->provider, $providers[$request->metode]), 422);

        $bank = null;
        if ($request->metode === 'Transfer' && $request->bank_id) {
            $bank = Bank::find($request->bank_id);
        }

        $user = auth()->user();
        $pelanggan = Pelanggan::dariUserOrCreate($user);
        $nominal = (int) round((float) $request->nominal);

        $lastId = Transaksi::max('id_transaksi') + 1;
        $noInvoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        return DB::transaction(function () use ($request, $user, $pelanggan, $nominal, $bank, $noInvoice) {
            $transaksi = Transaksi::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_user' => $user->id,
                'sumber' => 'online',
                'jenis_transaksi' => 'TopUp Saldo',
                'no_invoice' => $noInvoice,
                'tanggal' => now()->toDateString(),
                'subtotal' => $nominal,
                'diskon' => 0,
                'pajak' => 0,
                'total' => $nominal,
                'metode_byr' => $request->provider,
                'dibayar' => 0,
                'kembali' => 0,
                'catatan' => 'Top up saldo akun',
                'status' => 'Menunggu Pembayaran',
            ]);

            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis' => 'TopUp',
                'id_item' => 0,
                'nm_item' => 'Top Up Saldo',
                'qty' => 1,
                'harga' => $nominal,
                'diskon' => 0,
                'subtotal' => $nominal,
                'id_promo' => null,
            ]);

            $expiresAt = $request->metode === 'QRIS'
                ? now()->addMinutes(3)
                : now()->addMinutes(15);

            $pembayaranData = [
                'id_transaksi' => $transaksi->id_transaksi,
                'metode' => $request->metode,
                'provider' => $request->provider,
                'kode_pembayaran' => CheckoutController::generateKodePembayaran($request->metode, $transaksi->id_transaksi, $bank),
                'nominal' => $nominal,
                'status' => 'Menunggu',
                'expires_at' => $expiresAt,
            ];

            if ($bank) {
                $pembayaranData['bank_id'] = $bank->id;
                $pembayaranData['no_rekening_tujuan'] = $bank->no_rekening;
                $pembayaranData['atas_nama_tujuan'] = $bank->atas_nama;
            }

            Pembayaran::create($pembayaranData);

            $nominalRupiah = number_format($nominal, 0, ',', '.');
            ActivityLogger::log('Menambahkan', $user->nama . ' membuat top up saldo ' . $noInvoice . ' sebesar Rp ' . $nominalRupiah . ' via ' . $request->provider . ' (menunggu pembayaran)', 'Transaksi', $transaksi->id_transaksi);

            $petugas = \App\Models\User::whereIn('role', ['kasir', 'admin'])->get();
            foreach ($petugas as $petugasUser) {
                buatNotif($petugasUser->id, 'Top Up Saldo Baru', $user->nama . ' melakukan top up saldo sebesar Rp ' . $nominalRupiah . ' (' . $noInvoice . '). Segera verifikasi.', 'Transaksi', route('kasir.pembayaran.pesanan-online'));
            }

            return redirect()->route('pelanggan.pembayaran.show', $transaksi->id_transaksi);
        });
    }
}