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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $universities = University::all();
        return view('auth.register', compact('universities'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'university_id' => 'required|exists:universities,id',
            'student_id_image' => 'required|image|max:2048',
        ]);

        $university = University::findOrFail($request->university_id);
        $emailDomain = substr(strrchr($request->email, "@"), 1);

        if ($emailDomain !== $university->domain) {
            return back()->withErrors([
                'email' => "Access Denied. Please use your @{$university->domain} email address."
            ])->withInput();
        }

        // --- CLOUDINARY UPLOAD START ---
        // This sends the ID card to Cloudinary instead of Render's temporary storage
        $uploadedFileUrl = Cloudinary::upload($request->file('student_id_image')->getRealPath(), [
            'folder' => 'id_cards'
        ])->getSecurePath();
        // --- CLOUDINARY UPLOAD END ---

        $otp = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'university_id' => $request->university_id,
            'student_id_image' => $uploadedFileUrl, // Now storing the HTTPS Cloudinary URL
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15),
            'is_verified' => false,
            'email_verified_at' => null, 
        ]);

        Mail::to($user->email)->send(new SendOtpMail($otp));

        return redirect()->route('otp.show', ['email' => $user->email])
                         ->with('success', 'Registration successful! Check your university email for OTP.');
    }
}