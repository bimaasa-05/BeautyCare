<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_booking',
        'id_pelanggan',
        'id_user',
        'no_invoice',
        'tanggal',
        'subtotal',
        'diskon',
        'pajak',
        'total',
        'metode_byr',
        'dibayar',
        'kembali',
        'catatan',
        'status',
        'bukti_bayar',
        'atas_nama',
        'dari_rekening',
        'ke_rekening',
        'bank_asal',
        'bank_tujuan',
        'no_referensi',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
