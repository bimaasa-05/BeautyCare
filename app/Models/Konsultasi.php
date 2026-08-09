<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';
    protected $primaryKey = 'id_konsultasi';

    protected $fillable = [
        'id_pelanggan',
        'id_karyawan',
        'tanggal',
        'jam',
        'mode',
        'media',
        'topik',
        'pesan',
        'status',
        'periode',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'id_karyawan', 'id');
    }
}
