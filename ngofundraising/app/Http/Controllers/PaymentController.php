<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\PaymentProof;

class PaymentController extends Controller
{
    public function upload(Request $request, $donationId)
    {
        $donation = Donation::findOrFail($donationId);

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'notes' => 'nullable|string'
        ]);

        $filePath = $request->file('file')->store('uploads', 'public');

        PaymentProof::create([
            'donation_id' => $donation->id,
            'file_path' => $filePath,
            'notes' => $request->notes
        ]);

        return back()->with('success','Payment proof uploaded. Admin will verify shortly.');
    }
}