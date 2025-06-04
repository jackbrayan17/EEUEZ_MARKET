<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name',
        'sender_phone',
        'sender_town',
        'sender_quarter',
        'receiver_name',
        'receiver_phone',
        'receiver_town',
        'receiver_quarter',
        'product_info',
        'category',
        'price',
        'payment',
        'payment_number',
        'status',
        'client_id',
        'courier_id',          // Reference to courier
        'verification_code',
        'courier_longitude',   // Courier's longitude
        'courier_latitude',    // Courier's latitude
        'courier_address_name', 
        'merchant_id', // Ensure this is included
        'sender_address_id',  // Reference to sender address
        'receiver_address_id' // Reference to receiver address
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->verification_code = Str::random(7); // Generate the code
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id'); // Ensure courier_id is the foreign key
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function senderAddress()
    {
        return $this->belongsTo(Address::class, 'sender_address_id');
    }
   

    public function receiverAddress()
    {
        return $this->belongsTo(Address::class, 'receiver_address_id');
    }
}
