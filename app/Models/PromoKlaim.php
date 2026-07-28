<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoKlaim extends Model
{
    protected $table = 'promo_klaim';
    protected $primaryKey = 'id_promo_klaim';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_promo',
        'status',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
