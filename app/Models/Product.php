<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'storefront_id',
        'price',
        'stock',
        'category_id',
        'merchant_id',
    ];

    public function storefront()
    {
        return $this->belongsTo(Storefront::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class); // Define a relationship to the Merchant
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
