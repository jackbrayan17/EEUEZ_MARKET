<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CourierAddress extends Model
{
    protected $fillable = ['courier_id', 'longitude', 'latitude', 'address_name'];

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
