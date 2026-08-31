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
        'email_laporan',
        'konfirmasi_otomatis',
        'nama_salon',
        'telepon',
        'alamat',
        'email',
        'jam_buka',
        'jam_tutup',
        'syarat_ketentuan',
        'kebijakan_privasi',
        'pusat_bantuan_kategori',
        'pusat_bantuan_faq',
        'sosmed',
    ];

    protected $casts = [
        'push_notification' => 'boolean',
        'email_laporan' => 'boolean',
        'konfirmasi_otomatis' => 'boolean',
    ];
}
