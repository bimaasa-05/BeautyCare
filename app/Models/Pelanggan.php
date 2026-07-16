<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'nm_pelanggan',
        'no_hp',
        'email',
        'alamat',
        'id_member',
        'catatan_alergi',
        'foto',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'id_member', 'id_member');
    }
}
