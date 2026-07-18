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
}
