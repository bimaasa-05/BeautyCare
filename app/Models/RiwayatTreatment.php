<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatTreatment extends Model
{
    protected $table = 'riwayat_treatment';
    protected $primaryKey = 'id_rwayat';
    public $timestamps = false;

    protected $fillable = [
        'id_booking',
        'sebelum_foto',
        'sesudah_foto',
        'produk_digunakan',
        'catatan',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}
