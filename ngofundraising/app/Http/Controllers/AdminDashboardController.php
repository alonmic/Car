<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\PaymentProof;
use App\Models\Founder;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $donations = Donation::with('user')->latest()->take(10)->get();
        $pendingProofs = PaymentProof::where('verified', false)->count();
        $founders = Founder::all();

        return view('admin.dashboard', compact('usersCount','donations','pendingProofs','founders'));
    }

    public function verifyProof($id)
    {
        $proof = PaymentProof::findOrFail($id);
        $proof->verified = true;
        $proof->save();

        $donation = $proof->donation;
        $donation->status = 'Settled';
        $donation->save();

        return back()->with('success','Payment proof verified.');
    }
}