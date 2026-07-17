<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    protected $table = 'detail_booking';
    protected $primaryKey = 'id_detail_booking';
    public $timestamps = false;

    protected $fillable = [
        'id_booking',
        'id_layanan',
        'harga',
        'diskon',
        'subtotal',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }
}
