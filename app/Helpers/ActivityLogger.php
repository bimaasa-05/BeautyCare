<?php

namespace App\Helpers;

use App\Models\RiwayatAktivitas;

class ActivityLogger
{
    public static function log(
        string $aksi,
        string $deskripsi,
        ?string $tipe = null,
        ?int $idTipe = null,
        ?array $dataLama = null,
        ?array $dataBaru = null
    ): RiwayatAktivitas {
        $user = auth()->user();

        return RiwayatAktivitas::create([
            'id_user'   => $user?->id ?? 0,
            'role'      => $user?->role ?? 'system',
            'aksi'      => $aksi,
            'tipe'      => $tipe,
            'id_tipe'   => $idTipe,
            'deskripsi' => $deskripsi,
            'data_lama' => $dataLama ? json_encode($dataLama) : null,
            'data_baru' => $dataBaru ? json_encode($dataBaru) : null,
        ]);
    }
}
