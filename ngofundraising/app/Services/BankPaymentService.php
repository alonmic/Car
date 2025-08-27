<?php

namespace App\Services;

use App\Models\Donation;

class BankPaymentService
{
    public function confirmDonation(Donation $donation)
    {
        $donation->status = 'Settled';
        $donation->save();
        // Trigger PIN generation via PinService if first donation
    }
}