<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = ['email', 'code', 'expires_at', 'used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function isValid(): bool
    {
        return ! $this->used && $this->expires_at && now()->lessThanOrEqualTo($this->expires_at);
    }
}