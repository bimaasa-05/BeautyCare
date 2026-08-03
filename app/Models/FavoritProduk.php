<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoritProduk extends Model
{
    protected $table = 'favorit_produk';

    protected $fillable = [
        'id_user',
        'id_produk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
