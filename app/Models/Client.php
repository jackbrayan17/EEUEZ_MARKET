<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends User
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        //'address_id',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function address() {
        return $this->belongsTo(Address::class);
    }
    
    public function orders() {
        return $this->hasMany(Order::class);
    }
    
    public function cart() {
        return $this->hasOne(Cart::class);
    }
    
}
