<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoMutasi extends Model
{
    protected $table = 'saldo_mutasi';
    protected $primaryKey = 'id_mutasi';

    protected $fillable = [
        'id_pelanggan',
        'type',
        'nominal',
        'saldo_sebelum',
        'saldo_sesudah',
        'keterangan',
        'ref_type',
        'ref_id',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'ref_id', 'id_transaksi');
    }
}