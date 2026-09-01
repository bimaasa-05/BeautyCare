<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'password',
        'role',
        'foto',
        'status',
        'suspend_until',
        'perubahan_last_seen',
        'stok_last_seen',
        'provider',
        'provider_id',
        'avatar',
        'email_verified_at',
        'last_login_at',
        'perubahan_last_seen',
        'stok_last_seen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

/**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'suspend_until' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Accessor untuk URL foto profil dengan fallback UI Avatars
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=FF4F87&color=fff&size=140';
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id_user');
    }

    public function dataPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_user');
    }
}
