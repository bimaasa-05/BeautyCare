<?php

namespace App\Services;

use App\Models\Pengeluaran;
use App\Models\Transaksi;

class PengeluaranService
{
    public function buatTransaksi(Pengeluaran $pengeluaran, ?int $idSupplier = null, string $sumber = 'admin'): Transaksi
    {
        $nominal = (int) $pengeluaran->nominal;
        $lastId = Transaksi::max('id_transaksi') + 1;
        $noInvoice = 'PGL-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        return Transaksi::create([
            'id_booking' => null,
            'sumber' => $sumber,
            'id_pelanggan' => null,
            'id_supplier' => $idSupplier,
            'id_pengeluaran' => $pengeluaran->id_pengeluaran,
            'jenis_transaksi' => 'Pengeluaran',
            'id_user' => $pengeluaran->id_user ?: auth()->id(),
            'id_kasir' => $sumber === 'kasir' ? $pengeluaran->id_user : null,
            'no_invoice' => $noInvoice,
            'tanggal' => $pengeluaran->tanggal,
            'subtotal' => $nominal,
            'diskon' => 0,
            'pajak' => 0,
            'total' => $nominal,
            'metode_byr' => 'Tunai',
            'dibayar' => $nominal,
            'kembali' => 0,
            'catatan' => $this->formatCatatan($pengeluaran),
            'status' => 'Lunas',
            'no_referensi' => null,
        ]);
    }

    public function sinkronTransaksi(Pengeluaran $pengeluaran): void
    {
        $transaksi = Transaksi::where('id_pengeluaran', $pengeluaran->id_pengeluaran)->first();

        if (!$transaksi) {
            return;
        }

        $nominal = (int) $pengeluaran->nominal;

        $transaksi->update([
            'tanggal' => $pengeluaran->tanggal,
            'subtotal' => $nominal,
            'total' => $nominal,
            'dibayar' => $nominal,
            'catatan' => $this->formatCatatan($pengeluaran),
        ]);
    }

    public function hapusTransaksi(Pengeluaran $pengeluaran): void
    {
        Transaksi::where('id_pengeluaran', $pengeluaran->id_pengeluaran)->delete();
    }

    private function formatCatatan(Pengeluaran $pengeluaran): string
    {
        return $pengeluaran->kategori . ($pengeluaran->keterangan ? ' — ' . $pengeluaran->keterangan : '');
    }
}