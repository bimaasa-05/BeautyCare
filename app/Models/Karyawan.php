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
        'jabatan',
        'alamat',
        'tgl_lahir',
        'gaji',
        'komisi',
        'tgl_masuk',
        'status',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
