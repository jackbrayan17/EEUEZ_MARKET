<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends User
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_number',
        'name',
        'vehicle_brand',
        'vehicle_registration_number',
        'vehicle_color',
        'availability',
        'city',
        'neighborhood',
    ];

    public function addresses()
    {
        return $this->hasMany(CourierAddress::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
