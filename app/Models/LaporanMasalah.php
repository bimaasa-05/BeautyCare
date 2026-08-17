<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    protected $table = 'laporan_masalah';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user',
        'role',
        'kategori',
        'deskripsi',
        'bukti',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'bukti' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }
}