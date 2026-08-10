<?php

namespace App\Services;

use App\Models\Pelanggan;
use App\Models\SaldoMutasi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class SaldoAkunService
{
    public function getSaldo(int $idPelanggan): float
    {
        $pelanggan = Pelanggan::find($idPelanggan);
        return $pelanggan ? (float) $pelanggan->saldo : 0;
    }

    public function kreditCashback(int $idPelanggan, float $nominal, int $refId, string $refType = 'transaksi', string $keterangan = 'Cashback transaksi'): ?SaldoMutasi
    {
        if ($nominal <= 0) return null;

        // Guard anti-dobel: sekali kredit per referensi
        $sudahAda = SaldoMutasi::where('id_pelanggan', $idPelanggan)
            ->where('type', 'kredit')
            ->where('ref_type', $refType)
            ->where('ref_id', $refId)
            ->exists();

        if ($sudahAda) return null;

        return DB::transaction(function () use ($idPelanggan, $nominal, $refId, $refType, $keterangan) {
            $pelanggan = Pelanggan::lockForUpdate()->find($idPelanggan);
            if (!$pelanggan) return null;

            $sebelum = (float) $pelanggan->saldo;
            $sesudah = $sebelum + $nominal;

            $pelanggan->update(['saldo' => $sesudah]);

            return SaldoMutasi::create([
                'id_pelanggan' => $idPelanggan,
                'type' => 'kredit',
                'nominal' => $nominal,
                'saldo_sebelum' => $sebelum,
                'saldo_sesudah' => $sesudah,
                'keterangan' => $keterangan,
                'ref_type' => $refType,
                'ref_id' => $refId,
            ]);
        });
    }

    public function pakaiSaldo(int $idPelanggan, float $nominal, int $refId, string $refType = 'transaksi', string $keterangan = 'Pembayaran pakai saldo'): ?SaldoMutasi
    {
        if ($nominal <= 0) return null;

        return DB::transaction(function () use ($idPelanggan, $nominal, $refId, $refType, $keterangan) {
            $pelanggan = Pelanggan::lockForUpdate()->find($idPelanggan);
            if (!$pelanggan) return null;

            $sebelum = (float) $pelanggan->saldo;
            if ($sebelum < $nominal) return null;

            $sesudah = $sebelum - $nominal;
            $pelanggan->update(['saldo' => $sesudah]);

            return SaldoMutasi::create([
                'id_pelanggan' => $idPelanggan,
                'type' => 'debit',
                'nominal' => $nominal,
                'saldo_sebelum' => $sebelum,
                'saldo_sesudah' => $sesudah,
                'keterangan' => $keterangan,
                'ref_type' => $refType,
                'ref_id' => $refId,
            ]);
        });
    }

    public function prosesCheckout(int $idPelanggan, float $totalBayar, float $pakaiSaldo, int $idTransaksi, ?int $idPromo = null, bool $kreditCashback = true): array
    {
        $saldoTersedia = $this->getSaldo($idPelanggan);
        $pakaiSaldo = min($pakaiSaldo, $saldoTersedia, $totalBayar);
        $sisaBayar = $totalBayar - $pakaiSaldo;

        $cashback = 0;
        if ($idPromo) {
            $promo = \App\Models\Promo::find($idPromo);
            if ($promo && $promo->jenis_promo === 'Cashback') {
                $cashback = (float) $promo->nilai;
            }
        }

        if ($pakaiSaldo > 0) {
            $this->pakaiSaldo($idPelanggan, $pakaiSaldo, $idTransaksi, 'transaksi', 'Pembayaran pakai saldo');
        }

        $mutasiCashback = null;
        if ($cashback > 0 && $kreditCashback) {
            $mutasiCashback = $this->kreditCashback($idPelanggan, $cashback, $idTransaksi, 'transaksi', "Cashback promo {$promo->nm_promo}");
        }

        if ($pakaiSaldo > 0) {
            Transaksi::where('id_transaksi', $idTransaksi)->update([
                'saldo_terpakai' => $pakaiSaldo,
            ]);
        }

        return [
            'pakai_saldo' => $pakaiSaldo,
            'sisa_bayar' => $sisaBayar,
            'cashback' => $cashback,
            'saldo_akhir' => $this->getSaldo($idPelanggan),
            'mutasi_saldo' => $mutasiCashback ? $mutasiCashback->id_mutasi : null,
        ];
    }
}