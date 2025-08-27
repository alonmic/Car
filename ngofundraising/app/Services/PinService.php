<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PinService
{
    public function generatePin(User $user)
    {
        $pin = random_int(100000, 999999); // 6-digit PIN
        $user->pin_hash = Hash::make($pin);
        $user->pin_expires_at = Carbon::now()->addHours(2);
        $user->save();

        return $pin;
    }

    public function verifyPin(User $user, $pin)
    {
        if (!$user->pin_hash || !$user->pin_expires_at) return false;
        if (Carbon::now()->gt($user->pin_expires_at)) return false;
        return Hash::check($pin, $user->pin_hash);
    }
}