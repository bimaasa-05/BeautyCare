<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';
    protected $primaryKey = 'id_promo';
    public $timestamps = false;

    protected $fillable = [
        'nm_promo',
        'jenis_promo',
        'nilai',
        'mulai',
        'selesai',
        'status',
    ];

    public function klaim()
    {
        return $this->hasMany(PromoKlaim::class, 'id_promo', 'id_promo');
    }

    public function promoLayanan()
    {
        return $this->hasMany(PromoLayanan::class, 'id_promo', 'id_promo');
    }

    public function promoProduk()
    {
        return $this->hasMany(PromoProduk::class, 'id_promo', 'id_promo');
    }


}
