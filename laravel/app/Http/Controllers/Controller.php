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
    // Step 1: Show the Registration Form
    public function showRegistrationForm()
    {
        // We fetch all universities so the user can select one in a dropdown
        $universities = University::all();
        return view('auth.register', compact('universities'));
    }

    // Step 2: Handle the Registration Logic
    public function register(Request $request)
    {
        // 1. Validation: Ensure all data is present and correct
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'university_id' => 'required|exists:universities,id',
            'student_id_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // 2. Handle the File Upload
        if ($request->hasFile('student_id_image')) {
            // Save the image in 'storage/app/public/id_cards'
            $path = $request->file('student_id_image')->store('id_cards', 'public');
        }

        // 3. Create the User in the Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Always hash passwords!
            'university_id' => $request->university_id,
            'student_id_image' => $path, // Save the file path string
            'is_verified' => false, // Default is false until Admin checks the ID
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin verification.');
    }
}