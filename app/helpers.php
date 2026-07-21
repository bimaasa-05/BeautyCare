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
