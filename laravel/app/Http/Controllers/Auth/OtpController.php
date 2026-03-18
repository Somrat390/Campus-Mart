<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class OtpController extends Controller
{
    /**
     * Show the OTP page. We pass the email in the URL.
     */
    public function show($email)
    {
        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Verify the OTP and Auto-Approve the Admin status.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
        ]);

        // Find the user by the email provided in the hidden form field
        $user = User::where('email', $request->email)->firstOrFail();

        // 1. Check if OTP matches (forced string comparison)
        if (trim((string)$user->otp) === trim((string)$request->otp)) {
            
            // 2. Check if OTP is expired
            if ($user->otp_expires_at && Carbon::now()->isAfter($user->otp_expires_at)) {
                return back()->withErrors(['otp' => 'This OTP has expired. Please request a new one.'])->withInput();
            }

            // 3. Success! Verify Email AND Auto-Approve Admin status
            $user->update([
                'email_verified_at' => now(),
                'otp' => null, 
                'otp_expires_at' => null,
                'is_verified' => true, // This removes the "Admin Verification Pending" message
            ]);

            // 4. Redirect to LOGIN page (as you requested)
            return redirect()->route('login')->with('success', 'Account verified and approved! Please login to continue.');
        }

        // 5. Failure: Return back with a visible error message
        return back()->withErrors(['otp' => 'The code you entered is incorrect.'])->withInput();
    }

    /**
     * Resend OTP logic for non-logged in users
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->firstOrFail();
        
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        Mail::to($user->email)->send(new SendOtpMail($otp));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}