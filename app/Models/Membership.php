<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'membership';
    protected $primaryKey = 'id_member';
    public $timestamps = false;

    protected $fillable = [
        'nm_member',
        'tingkat',
        'diskon',
        'min_transaksi',
        'min_pembelian',
        'masa_berlaku',
        'status',
    ];
}