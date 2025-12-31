<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Important for seeing OTPs
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'digits:10', 'unique:'.User::class], // Validate Phone
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // 1. Generate OTPs
        $emailOtp = rand(100000, 999999);
        $phoneOtp = rand(100000, 999999);

        // 2. Log them (Since we don't have a real SMS gateway yet)
        Log::info("REGISTRATION OTPS: Email: $emailOtp | Phone: $phoneOtp");

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'email_otp' => $emailOtp,
            'phone_otp' => $phoneOtp,
        ]);

        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $client = new Client($sid, $token);

            $client->messages->create(
                // The user's phone number (Must include country code, e.g., +91)
                '+91' . $request->phone, 
                [
                    'from' => env('TWILIO_FROM'),
                    'body' => "Your MediAI verification code is: $phoneOtp"
                ]
            );
        } catch (\Exception $e) {
            Log::error("SMS sending failed: " . $e->getMessage());
        }
        // 3. Send Emails/SMS here (Mocked by logging above)
        // Mail::to($user)->send(new VerifyEmailOtp($emailOtp));
        // Send Email
        try {
            Mail::to($user->email)->send(new OtpMail($emailOtp));
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
        }
        
        // 4. Do NOT login yet. Redirect to verification page.
        // We store the user ID in session to know who is verifying
        session(['verify_user_id' => $user->id]);

        return redirect()->route('verification.notice');
    }
}