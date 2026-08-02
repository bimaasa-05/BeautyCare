<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use Illuminate\Console\Command;

class ExpirePesanan extends Command
{
    protected $signature = 'pesanan:expire';

    protected $description = 'Kadaluarsakan pesanan online yang melewati batas waktu pembayaran';

    public function handle(): int
    {
        $expired = Pembayaran::with('transaksi')
            ->where('status', 'Menunggu')
            ->where('expires_at', '<', now())
            ->get();

        $count = 0;

        foreach ($expired as $bayar) {
            $transaksi = $bayar->transaksi;

            if (!$transaksi || $transaksi->sumber !== 'online' || $transaksi->status !== 'Menunggu Pembayaran') {
                continue;
            }

            $transaksi->update(['status' => 'Kadaluarsa']);
            $bayar->update(['status' => 'Kadaluarsa']);

            buatNotif($transaksi->id_user, 'Pesanan Kadaluarsa', 'Pesanan ' . $transaksi->no_invoice . ' kadaluarsa karena melewati batas waktu pembayaran.', 'Transaksi', route('pelanggan.pesanan.show', $transaksi->id_transaksi));

            $count++;
        }

        $this->info("{$count} pesanan dikadaluarsakan.");

        return Command::SUCCESS;
    }
}
