<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoProduk extends Model
{
    protected $table = 'promo_produk';
    protected $primaryKey = 'id_promo_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_promo',
        'id_produk',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
