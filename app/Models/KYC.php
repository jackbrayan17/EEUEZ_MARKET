<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'family_member_name', 'family_member_phone', 'relation'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
