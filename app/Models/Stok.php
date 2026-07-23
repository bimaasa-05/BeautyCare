<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';
    protected $primaryKey = 'id_stok';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'tanggal',
        'type',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'ref_id',
        'ref_type',
        'status',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
