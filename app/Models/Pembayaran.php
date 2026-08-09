<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'id_transaksi',
        'metode',
        'provider',
        'bank_id',
        'kode_pembayaran',
        'nominal',
        'status',
        'expires_at',
        'paid_at',
        'no_referensi',
        'no_rekening_tujuan',
        'atas_nama_tujuan',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'paid_at' => 'datetime',
            'nominal' => 'float',
        ];
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}