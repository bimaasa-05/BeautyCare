<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = true;

    protected $fillable = [
        'nm_pelanggan',
        'no_hp',
        'email',
        'alamat',
        'id_member',
        'tgl_mulai_member',
        'catatan_alergi',
        'foto',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'id_member', 'id_member');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan', 'id_pelanggan');
    }
}
