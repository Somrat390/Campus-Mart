<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SendOtpMail;

class RegisterController extends Controller
{
    /**
     * Show the registration form with the list of universities.
     */
    public function showRegistrationForm()
    {
        $universities = University::all();
        return view('auth.register', compact('universities'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'university_id' => 'required|exists:universities,id',
            'student_id_image' => 'required|image|max:2048',
        ]);

        // 2. DOMAIN VALIDATION
        $university = University::findOrFail($request->university_id);
        $emailDomain = substr(strrchr($request->email, "@"), 1);

        if ($emailDomain !== $university->domain) {
            return back()->withErrors([
                'email' => "Access Denied. Please use your @{$university->domain} email address."
            ])->withInput();
        }

        // 3. STORAGE & OTP GENERATION
        $imagePath = $request->file('student_id_image')->store('id_cards', 'public');
        $otp = rand(100000, 999999);

        // 4. Create User (Unverified)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'university_id' => $request->university_id,
            'student_id_image' => $imagePath,
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15), // Increased to 15 for better UX
            'is_verified' => false, // Initial Admin status
            'email_verified_at' => null, 
        ]);

        // 5. SEND MAIL
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // 6. REDIRECT to OTP page (passing email to identify user)
        return redirect()->route('otp.show', ['email' => $user->email])
                         ->with('success', 'Registration successful! An OTP has been sent to your university email.');
    }
}