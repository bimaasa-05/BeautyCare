<?php

namespace App\Models;

use Carbon\Carbon;
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
        'harga',
        'masa_berlaku',
        'deskripsi',
        'status',
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'id_member', 'id_member');
    }

    public function tanggalBerakhir(?string $tglMulai): ?Carbon
    {
        if (!$tglMulai) {
            return null;
        }

        return Carbon::parse($tglMulai)->addDays((int) $this->masa_berlaku);
    }

    public function sudahKadaluarsa(?string $tglMulai): bool
    {
        if ((int) $this->masa_berlaku <= 0) {
            return false;
        }

        $akhir = $this->tanggalBerakhir($tglMulai);
        if (!$akhir) {
            return true;
        }

        return $akhir->startOfDay()->lt(Carbon::today());
    }

    public function sisaHari(?string $tglMulai): int
    {
        if ((int) $this->masa_berlaku <= 0 || !$tglMulai) {
            return 0;
        }

        $akhir = $this->tanggalBerakhir($tglMulai);
        $sisa = (int) ceil(Carbon::today()->diffInDays($akhir->startOfDay(), false));

        return max(0, $sisa);
    }
}
