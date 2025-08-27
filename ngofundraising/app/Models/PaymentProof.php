<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id', 'file_path', 'notes', 'verified'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}