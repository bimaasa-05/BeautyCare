<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori_produk',
        'nm_produk',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'foto',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'id_kategori_produk', 'id_kategori_produk');
    }

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'id_produk', 'id_produk');
    }

    public function stokMasuk()
    {
        return $this->hasMany(Stok::class, 'id_produk', 'id_produk')->where('type', 'Masuk');
    }
}
