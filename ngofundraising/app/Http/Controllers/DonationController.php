<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Services\BankPaymentService;
use App\Services\CryptoPaymentService;

class DonationController extends Controller
{
    protected $bankService;
    protected $cryptoService;

    public function __construct(BankPaymentService $bank, CryptoPaymentService $crypto)
    {
        $this->bankService = $bank;
        $this->cryptoService = $crypto;
    }

    public function create(Request $request)
    {
        return view('user.donations');
    }

    public function store(Request $request)
    {
        $request->validate([
            'project' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:Bank,Crypto',
        ]);

        $donation = Donation::create([
            'user_id' => auth()->id(),
            'project' => $request->project,
            'amount' => $request->amount,
            'method' => $request->method,
        ]);

        if($request->method === 'Crypto'){
            $invoice = $this->cryptoService->createInvoice($donation);
            return view('user.crypto_invoice', compact('invoice'));
        }

        return redirect()->route('user.dashboard')->with('success','Donation recorded. Awaiting bank confirmation.');
    }
}