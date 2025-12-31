<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function notice()
    {
        if (!session('verify_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email_otp' => 'required',
            'phone_otp' => 'required',
        ]);

        $userId = session('verify_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired.');
        }

        // Check OTPs
        if ($request->email_otp == $user->email_otp && $request->phone_otp == $user->phone_otp) {
            
            // Success! Mark verified and clear OTPs
            $user->email_verified_at = now();
            $user->phone_verified_at = now();
            $user->email_otp = null;
            $user->phone_otp = null;
            $user->save();

            // Login the user
            Auth::login($user);
            session()->forget('verify_user_id');

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Invalid OTPs provided. Check your logs/email.']);
    }
}