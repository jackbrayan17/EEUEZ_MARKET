<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storekeeper extends User
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_number',
        'name',
        'availability',
        'city',
        'neighborhood',
    ];
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
