<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id_pengaturan';
    public $timestamps = false;

    protected $fillable = [
        'push_notification',
        'sms_notifikasi',
        'email_laporan',
        'konfirmasi_otomatis',
        'nama_salon',
        'telepon',
        'jam_buka',
        'jam_tutup',
    ];

    protected $casts = [
        'push_notification' => 'boolean',
        'sms_notifikasi' => 'boolean',
        'email_laporan' => 'boolean',
        'konfirmasi_otomatis' => 'boolean',
    ];
}
