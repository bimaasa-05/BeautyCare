<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';
    protected $primaryKey = 'id_kategori_produk';
    public $timestamps = false;

    protected $fillable = [
        'nm_produk',
        'status',
    ];
}
