<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['kyc_id', 'path'];

    public function kyc()
    {
        return $this->belongsTo(KYC::class);
    }
}
