<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Identify the logged-in student's university
        $myUniversity = auth()->user()->university_id;

        // 2. Fetch only relevant products
        $products = Product::where('university_id', $myUniversity)
                    ->where('is_sold', false)
                    ->latest()
                    ->get();

        return view('dashboard', compact('products'));
    }

    /**
     * Show the user's profile with their Student ID Card
     */
    public function profile()
    {
        // We use 'with' to get the University name automatically
        $user = Auth::user()->load('university');
        
        return view('auth.profile', compact('user'));
    }
}