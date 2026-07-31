<?php

use App\Models\Notifikasi;

if (!function_exists('buatNotif')) {
    function buatNotif($userId, $judul, $isi, $type = 'Lainnya', $url = null, $aktorId = null)
    {
        try {
            return Notifikasi::create([
                'id_user' => $userId,
                'aktor_id' => $aktorId ?? auth()->id(),
                'judul' => $judul,
                'isi' => $isi,
                'type' => $type,
                'url' => $url,
                'status' => 0,
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('catatStok')) {
    function catatStok($idProduk, $type, $jumlah, $stokSebelum, $stokSesudah, $keterangan = '', $idSupplier = null, $refId = null, $refType = null)
    {
        try {
            return \App\Models\Stok::create([
                'id_produk'    => $idProduk,
                'id_supplier'  => $idSupplier,
                'tanggal'      => now()->toDateString(),
                'type'         => $type,
                'jumlah'       => $jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan'   => $keterangan,
                'ref_id'       => $refId,
                'ref_type'     => $refType,
                'status'       => 1,
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }
}
