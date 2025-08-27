<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\PinService;
use Illuminate\Support\Facades\Mail;

class PinLoginController extends Controller
{
    protected $pinService;

    public function __construct(PinService $pinService)
    {
        $this->pinService = $pinService;
    }

    public function showForm()
    {
        return view('auth.login');
    }

    public function sendPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        $pin = $this->pinService->generatePin($user);

        // Send PIN via email
        Mail::raw("Your login PIN is: $pin", function($message) use ($user){
            $message->to($user->email)
                    ->subject('Your Login PIN');
        });

        return redirect()->route('otp.form')->with('success','PIN sent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'pin' => 'required|digits:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($this->pinService->verifyPin($user, $request->pin)) {
            auth()->login($user);
            return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
        }

        return back()->withErrors(['pin'=>'Invalid or expired PIN']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('otp.form');
    }
}