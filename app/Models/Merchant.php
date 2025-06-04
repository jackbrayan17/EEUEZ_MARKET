<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends User
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'phone', 'address',
    ];

    // Merchant belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function storefronts()
{
    return $this->hasMany(Storefront::class);
}
public function products()
{
    return $this->hasMany(Product::class);
}
}
