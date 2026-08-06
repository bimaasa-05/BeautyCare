<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoTarget extends Model
{
    protected $table = 'promo_target';
    protected $primaryKey = 'id_promo_target';
    public $timestamps = false;

    protected $fillable = [
        'id_promo',
        'id_pelanggan',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
