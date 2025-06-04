<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'town',
        'quarter',
        'latitude',
        'longitude',
        'fees',
    ];


    // Define the relationship with the User model if needed
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
