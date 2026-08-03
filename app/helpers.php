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

if (!function_exists('hitungPerubahanData')) {
    function hitungPerubahanData()
    {
        static $cached = null;

        if ($cached !== null) {
            return $cached;
        }

        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return 0;
        }

        $lastSeen = $user->perubahan_last_seen ?? now()->startOfDay();

        $jumlah = \App\Models\RiwayatAktivitas::where('role', '!=', 'admin')
            ->where('created_at', '>', $lastSeen)
            ->count();

        $user->update(['perubahan_last_seen' => now()]);

        $cached = $jumlah;

        return $jumlah;
    }
}

if (!function_exists('hitungMutasiStokBaru')) {
    function hitungMutasiStokBaru()
    {
        static $cached = null;

        if ($cached !== null) {
            return $cached;
        }

        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return 0;
        }

        $lastSeen = $user->stok_last_seen;

        $terakhir = \App\Models\Stok::max('id_stok') ?? 0;

        if ($lastSeen === null) {
            $user->update(['stok_last_seen' => $terakhir]);
            return 0;
        }

        $jumlah = \App\Models\Stok::whereIn('type', ['Masuk', 'Refund'])->where('id_stok', '>', $lastSeen)->count();

        $user->update(['stok_last_seen' => $terakhir]);

        $cached = $jumlah;

        return $jumlah;
    }
}

if (!function_exists('catatStok')) {    function catatStok($idProduk, $type, $jumlah, $stokSebelum, $stokSesudah, $keterangan = '', $idSupplier = null, $refId = null, $refType = null)
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
