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
        'status',
        'catatan',
    ];

    public function detail()
    {
        return $this->hasOne(DetailBooking::class, 'id_booking', 'id_booking');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }
}
