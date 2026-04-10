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
        // 1. Validate Input (Strict Validation)
        $request->validate([
            // regex:/^[a-zA-Z\s]+$/ allows only letters and spaces
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            
            // unique:users checks if email/phone already exists before proceeding
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'digits:10', 'unique:users,phone'],
            
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            // Custom error messages for the interview/user experience
            'name.regex' => 'The name field must only contain letters and spaces.',
            'email.unique' => 'This email is already registered with MediAI.',
            'phone.unique' => 'This phone number is already in use.',
        ]);

        // --- AT THIS POINT, WE KNOW THE USER IS UNIQUE AND DATA IS VALID ---

        // 2. Generate OTPs
        $emailOtp = rand(100000, 999999);
        $phoneOtp = rand(100000, 999999);

        // 3. Store data in session
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
            Log::error("Twilio SMS failed: " . $e->getMessage());
            // In a real app, you might want to return with an error if SMS fails
        }

        // 5. Send Email
        try {
            Mail::to($request->email)->send(new OtpMail($emailOtp));
        } catch (\Exception $e) {
            Log::error("Mail failed: " . $e->getMessage());
        }

        return redirect()->route('verification.notice');
    }
}