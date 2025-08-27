<?php

namespace App\Services;

use App\Models\Donation;

class CryptoPaymentService
{
    public function createInvoice(Donation $donation)
    {
        // Return invoice data with amount & wallet address
        return [
            'invoice_id' => 'CRYPTO-'.uniqid(),
            'amount' => $donation->amount,
            'address' => config('crypto.wallet_address')
        ];
    }
}