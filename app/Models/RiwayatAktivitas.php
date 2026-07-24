<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    protected $table = 'riwayat_aktivitas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'role',
        'aksi',
        'tipe',
        'id_tipe',
        'deskripsi',
        'data_lama',
        'data_baru',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function getDataLamaArray(): array
    {
        return json_decode($this->data_lama, true) ?? [];
    }

    public function getDataBaruArray(): array
    {
        return json_decode($this->data_baru, true) ?? [];
    }
}
