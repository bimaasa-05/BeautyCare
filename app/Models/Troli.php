<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troli extends Model
{
    use HasFactory;

    protected $table = 'troli';

    protected $fillable = [
        'id_user',
        'nm_produk',
        'produk_slug',
        'kategori',
        'harga_satuan',
        'qty',
        'total_harga',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
