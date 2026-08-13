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
        'sumber',
        'id_pelanggan',
        'id_supplier',
        'id_pengeluaran',
        'jenis_transaksi',
        'id_user',
        'id_kasir',
        'no_invoice',
        'tanggal',
        'subtotal',
        'diskon',
        'pajak',
        'total',
        'saldo_terpakai',
        'metode_byr',
        'ewallet_type',
        'dibayar',
        'kembali',
        'catatan',
        'status',
        'bukti_bayar',
        'no_referensi',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir', 'id');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi', 'id_transaksi');
    }

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'id_pengeluaran', 'id_pengeluaran');
    }
}
