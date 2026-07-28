<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoLayanan extends Model
{
    protected $table = 'promo_layanan';
    protected $primaryKey = 'id_promo_layanan';
    public $timestamps = false;

    protected $fillable = [
        'id_promo',
        'id_layanan',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }
}
