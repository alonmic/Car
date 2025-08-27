<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',     // optional if only PIN login
        'pin_hash',
        'pin_expires_at',
        'tier',
        'role',      // user / admin
    ];

    protected $hidden = [
        'pin_hash',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}