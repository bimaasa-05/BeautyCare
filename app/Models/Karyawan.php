<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'NIP',
        'nama',
        'jabatan',
        'alamat',
        'tgl_lahir',
        'gaji',
        'komisi',
        'tgl_masuk',
        'status',
    ];
}
