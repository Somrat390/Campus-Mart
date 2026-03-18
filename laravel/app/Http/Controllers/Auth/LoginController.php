<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. First, check if the user exists and if their email is verified
        $user = User::where('email', $request->email)->first();

        if ($user && !$user->email_verified_at) {
            // If not verified, kick them back to OTP page with their email
            return redirect()->route('otp.show', ['email' => $user->email])
                             ->with('error', 'Please verify your email address first.');
        }

        // 2. Attempt the actual login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Success! Go to dashboard
            return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }

        // 3. If login fails
        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}