<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notif';

    protected $fillable = [
        'id_user',
        'judul',
        'isi',
        'type',
        'status',
        'url',
        'read_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 0);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
