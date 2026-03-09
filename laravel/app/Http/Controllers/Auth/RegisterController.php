<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        // 1. Validate the incoming data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'university_id' => ['required', 'exists:universities,id'],
            'student_id_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ]);

        // 2. Handle the Student ID Image Upload
        // This saves the file to storage/app/public/id_cards
        $imagePath = null;
        if ($request->hasFile('student_id_image')) {
            $imagePath = $request->file('student_id_image')->store('id_cards', 'public');
        }

        // 3. Create the User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Securely hash the password
            'university_id' => $request->university_id,
            'student_id_image' => $imagePath,
            'is_verified' => false, // Set to false by default for admin review
        ]);

        // 4. Redirect with a success message
        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin verification.');
    }
}