<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'courier_id',
        'client_id',
        'merchant_id',
        'order_id',
        'status',
    ];

    // Define relationships if needed
    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Add other relationships as needed
}