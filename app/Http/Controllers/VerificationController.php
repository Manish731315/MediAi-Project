<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * Show the OTP entry page.
     */
    public function notice()
    {
        // Check for the temporary session data instead of verify_user_id
        if (!session('pending_user')) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }
        return view('auth.verify-otp');
    }

    /**
     * Verify the OTPs and create the User account.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email_otp' => 'required',
            'phone_otp' => 'required',
        ]);

        $pendingUser = session('pending_user');

        if (!$pendingUser) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        // Check if entered OTPs match the ones stored in session
        if ($request->email_otp == $pendingUser['email_otp'] && $request->phone_otp == $pendingUser['phone_otp']) {
            
            // --- SUCCESS: Create the user in the database NOW ---
            $user = User::create([
                'name'     => $pendingUser['name'],
                'email'    => $pendingUser['email'],
                'phone'    => $pendingUser['phone'],
                'password' => $pendingUser['password'], // Already hashed in RegisteredUserController
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]);

            // Login the user
            Auth::login($user);

            // Clear the temporary session data
            session()->forget('pending_user');

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Invalid OTPs provided. Please try again.']);
    }

    /**
     * Resend OTP logic.
     */
    public function resend(Request $request)
    {
        $pendingUser = session('pending_user');

        if (!$pendingUser) {
            return redirect()->route('register')->with('error', 'Session expired.');
        }

        // Generate new codes
        $emailOtp = rand(100000, 999999);
        $phoneOtp = rand(100000, 999999);

        // Update the session
        $pendingUser['email_otp'] = $emailOtp;
        $pendingUser['phone_otp'] = $phoneOtp;
        session(['pending_user' => $pendingUser]);

        Log::info("RESENT OTPS | Email: $emailOtp | Phone: $phoneOtp");

        // Send Email
        try {
            Mail::to($pendingUser['email'])->send(new OtpMail($emailOtp));
        } catch (\Exception $e) {
            Log::error("Resend Email failed: " . $e->getMessage());
        }

        // Send SMS
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.from');

            if (!$sid || !$token) {
                throw new \Exception("Twilio credentials are not set in the configuration.");
            }
            $client = new \Twilio\Rest\Client($sid, $token);
            $client->messages->create(
                '+91' . $pendingUser['phone'],
                [
                    'from' => $from, 
                    'body' => "Your new MediAI code is: $phoneOtp"
                ]
            );
        } catch (\Exception $e) {
            Log::error("Resend SMS failed: " . $e->getMessage());
        }

        return back()->with('status', 'New verification codes have been sent!');
    }
}