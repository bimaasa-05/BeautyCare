<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    public $timestamps = false;

    protected $fillable = [
        'nm_supplier',
        'no_hp',
        'alamat',
        'id_produk',
        'status',
    ];

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'id_supplier', 'id_supplier');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
