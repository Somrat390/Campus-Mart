<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        // Only allow the first user (usually the creator/Somrat)
        if (auth()->id() !== 1) abort(403);
        
        $users = User::with('university')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function verify(User $user) {
        if (auth()->id() !== 1) abort(403);

        // Manually verify without needing OTP
        $user->update([
            'is_verified' => true,
            'email_verified_at' => now(),
            'otp' => null // Clear the OTP since it's no longer needed
        ]);

        return back()->with('success', "User {$user->name} verified successfully!");
    }

    public function destroy(User $user)
    {
        // Safety Lock: Prevent the logged-in admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', '🚨 Crisis Averted! You cannot delete the primary Admin account.');
        }

        // Safety Lock: Prevent deleting the account with ID 1 (The Root Admin)
        if ($user->id === 1) {
            return back()->with('error', '🚨 This is the root account. It must stay for the system to work.');
        }

        // If it's anyone else, go ahead and delete
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
}