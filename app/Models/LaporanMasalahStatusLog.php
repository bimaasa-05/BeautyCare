<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasalahStatusLog extends Model
{
    protected $table = 'laporan_masalah_status_log';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_laporan',
        'status',
        'catatan',
        'id_admin',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanMasalah::class, 'id_laporan');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}