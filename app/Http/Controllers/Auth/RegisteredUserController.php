<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Twilio\Rest\Client;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'digits:10', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // 2. Generate OTPs
        $emailOtp = rand(100000, 999999);
        $phoneOtp = rand(100000, 999999);

        // 3. Store data in session, NOT the database yet
        // This prevents "email already taken" errors if verification fails
        session([
            'pending_user' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'email_otp' => $emailOtp,
                'phone_otp' => $phoneOtp,
            ]
        ]);

        Log::info("PENDING REGISTRATION OTPS | Email: $emailOtp | Phone: $phoneOtp");

        // 4. Send SMS via Twilio
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $client = new Client($sid, $token);

            $client->messages->create(
                '+91' . $request->phone, 
                [
                    'from' => config('services.twilio.from'),
                    'body' => "Your MediAI verification code is: $phoneOtp"
                ]
            );
        } catch (\Exception $e) {
            Log::error("SMS sending failed: " . $e->getMessage());
        }

        // 5. Send Email via OtpMail
        try {
            Mail::to($request->email)->send(new OtpMail($emailOtp));
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
        }

        // 6. Redirect to verification page
        return redirect()->route('verification.notice');
    }
}