<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class OtpController extends Controller
{
    public function show()
    {
        // If they are already verified, don't show the OTP page
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6' // Added 'digits:6' for better validation
        ]);

        $user = Auth::user();

        // Check if OTP matches and hasn't expired
        if ($user->otp == $request->otp && $user->otp_expires_at && Carbon::now()->lt($user->otp_expires_at)) {
            
            $user->update([
                'email_verified_at' => Carbon::now(),
                'otp' => null, 
                'otp_expires_at' => null
            ]);

            return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
        }

        return back()->withErrors(['otp' => 'The code you entered is invalid or has expired.']);
    }

    /**
     * Handle Resending the OTP
     */
    public function resend(Request $request)
    {
        $user = Auth::user();
        
        // Generate new code
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Send Mail
        Mail::to($user->email)->send(new SendOtpMail($otp));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}