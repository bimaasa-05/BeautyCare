<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriLayanan extends Model
{
    protected $table = 'kategori_layanan';
    protected $primaryKey = 'id_kategori_layanan';
    public $timestamps = false;

    protected $fillable = [
        'nm_layanan',
        'deskripsi',
        'status',
    ];
}
