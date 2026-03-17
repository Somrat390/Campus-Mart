<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your Campus-Mart Verification Code')
                    ->view('emails.otp'); // We will create this view next
    }

    public function resend(Request $request)
    {
        $user = Auth::user();

        // Generate a new 6-digit OTP
        $newOtp = rand(100000, 999999);

        // Update user record with new OTP and fresh expiration (15 mins)
        $user->update([
            'otp' => $newOtp,
            'otp_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Send the new OTP email
        Mail::to($user->email)->send(new SendOtpMail($newOtp));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}

