<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nm_layanan',
        'durasi',
        'harga',
        'foto',
        'status',
    ];
}
