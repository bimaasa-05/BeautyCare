<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';
    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_karyawan',
        'tanggal',
        'jam',
        'jam_mulai_aktual',
        'jam_selesai_aktual',
        'status',
        'status_pembayaran',
        'tipe_pembayaran',
        'catatan',
        'reminder_h1',
        'reminder_jam',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'id_karyawan', 'id');
    }

    public function detail()
    {
        return $this->hasMany(DetailBooking::class, 'id_booking', 'id_booking');
    }

    public function riwayatTreatment()
    {
        return $this->hasOne(RiwayatTreatment::class, 'id_booking', 'id_booking');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_booking', 'id_booking')->latest('id_transaksi');
    }
}
