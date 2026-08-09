<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    protected $table = 'banks';
    protected $primaryKey = 'id';
    
    use SoftDeletes;

    protected $fillable = [
        'nama_bank',
        'kode_bank',
        'no_rekening',
        'atas_nama',
        'logo',
        'tipe',
        'nomor_telepon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTransfer($query)
    {
        return $query->where('tipe', 'transfer');
    }

    public function scopeEwallet($query)
    {
        return $query->where('tipe', 'ewallet');
    }

    public function scopeQris($query)
    {
        return $query->where('tipe', 'qris');
    }
}