<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Added for automatic login
use Illuminate\Support\Facades\Mail; // Added for sending emails
use Carbon\Carbon; // Added for OTP expiration time

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

    // 2. DOMAIN VALIDATION (The "Software Engineer" Check)
    $university = \App\Models\University::findOrFail($request->university_id);
    $emailDomain = substr(strrchr($request->email, "@"), 1);

    if ($emailDomain !== $university->domain) {
        return back()->withErrors([
            'email' => "Access Denied. Please use your @{$university->domain} email address."
        ])->withInput();
    }

    // 3. TEMP STORAGE (Create User but Unverified)
    $imagePath = $request->file('student_id_image')->store('id_cards', 'public');
    $otp = rand(100000, 999999);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'university_id' => $request->university_id,
        'student_id_image' => $imagePath,
        'otp' => $otp,
        'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(15),
        'email_verified_at' => null, // The "Lock"
    ]);

    // 4. OTP GENERATION & MAIL
    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

    // 5. THE WALL (Login and Redirect)
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('otp.show');
    }
}