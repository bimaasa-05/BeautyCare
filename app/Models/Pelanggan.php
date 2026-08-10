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
        'saldo',
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

    public function membershipAktif(): ?Membership
    {
        $member = $this->membership;

        if (!$member || $member->status !== 'aktif') {
            return null;
        }

        if ($member->sudahKadaluarsa($this->tgl_mulai_member)) {
            return null;
        }

        return $member;
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Resolusi pelanggan milik user login.
     * Prioritas: id_user -> email -> nama.
     * Kalau ketemu lewat email/nama tapi id_user masih kosong, otomatis diikat
     * supaya semua alur (checkout, membership, dashboard) memakai baris yang sama.
     */
    /**
     * Accessor untuk URL foto profil dengan fallback UI Avatars
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nm_pelanggan) . '&background=FF4F87&color=fff&size=140';
    }

    public static function dariUser($user): ?self
    {
        if (!$user || !$user->id) {
            return null;
        }

        $pelanggan = static::where('id_user', $user->id)->first();
        if ($pelanggan) {
            return $pelanggan;
        }

        $pelanggan = static::where('email', $user->email)->first();
        if (!$pelanggan) {
            $pelanggan = static::where('nm_pelanggan', $user->nama)->first();
        }

        if ($pelanggan) {
            if (!$pelanggan->id_user) {
                $pelanggan->id_user = $user->id;
                $pelanggan->save();
            }
            return $pelanggan;
        }

        return null;
    }

    public static function dariUserOrCreate($user): self
    {
        $pelanggan = static::dariUser($user);

        if (!$pelanggan) {
            $pelanggan = static::create([
                'nm_pelanggan' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_user' => $user->id,
                'id_member' => null,
            ]);
        }

        return $pelanggan;
    }
}
