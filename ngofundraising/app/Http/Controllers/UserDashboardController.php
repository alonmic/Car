<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $donations = $user->donations()->latest()->take(5)->get();

        $totalDonated = $user->donations()->sum('amount');
        $pendingDonations = $user->donations()->where('status','Pending')->count();

        return view('user.dashboard', compact('user','donations','totalDonated','pendingDonations'));
    }
}