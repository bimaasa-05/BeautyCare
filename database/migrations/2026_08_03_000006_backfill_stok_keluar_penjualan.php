<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $produks = DB::table('produk')->select('id_produk', 'stok')->get();

        foreach ($produks as $produk) {
            $terakhir = DB::table('stok')
                ->where('id_produk', $produk->id_produk)
                ->orderByDesc('id_stok')
                ->value('stok_sesudah');

            if ($terakhir === null || $produk->stok >= $terakhir) {
                continue;
            }

            $detail = DB::table('detail_transaksi')
                ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
                ->where('detail_transaksi.jenis', 'Produk')
                ->where('detail_transaksi.id_item', $produk->id_produk)
                ->where('transaksi.status', 'Lunas')
                ->orderBy('transaksi.id_transaksi')
                ->get([
                    'detail_transaksi.qty',
                    'transaksi.id_transaksi',
                    'transaksi.tanggal',
                    'transaksi.no_invoice',
                ]);

            $stokSesudah = $terakhir;

            foreach ($detail as $d) {
                $sudahAda = DB::table('stok')
                    ->where('ref_id', $d->id_transaksi)
                    ->where('ref_type', 'Transaksi')
                    ->where('id_produk', $produk->id_produk)
                    ->where('type', 'Keluar')
                    ->exists();

                if ($sudahAda) {
                    continue;
                }

                $stokSebelum = $stokSesudah;
                $stokSesudah = max(0, $stokSesudah - $d->qty);

                DB::table('stok')->insert([
                    'id_produk' => $produk->id_produk,
                    'id_supplier' => null,
                    'tanggal' => $d->tanggal,
                    'type' => 'Keluar',
                    'jumlah' => $d->qty,
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'keterangan' => 'Penjualan online (konfirmasi kasir) ' . $d->no_invoice,
                    'ref_id' => $d->id_transaksi,
                    'ref_type' => 'Transaksi',
                    'status' => 1,
                ]);

                if ($stokSesudah <= $produk->stok) {
                    break;
                }
            }
        }
    }

    public function down(): void
    {
    }
};
