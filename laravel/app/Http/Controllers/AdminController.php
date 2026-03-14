<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Get all users who are NOT yet verified
        $users = User::where('is_verified', false)->get();
        return view('admin.verify', compact('users'));
    }

    public function approve(User $user)
    {
        $user->is_verified = true;
        $user->save();

        return back()->with('success', "Student {$user->name} has been verified!");
    }
}