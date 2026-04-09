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
        // If already logged in, go to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
        }

        // 2. Check if email is verified OR if your admin-verify flag is false
        // Based on your previous files, 'is_verified' is your main check
        if (!$user->email_verified_at || !$user->is_verified) {
            return redirect()->route('otp.show', ['email' => $user->email])
                             ->with('error', 'Please verify your email address first.');
        }

        // 3. Attempt the actual login
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                             ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // 4. If password fails
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