<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) // Added Request $request
    {
        // 1. Identify the logged-in student's university
        $myUniversity = auth()->user()->university_id;

        // 2. Start the query: ONLY show items from this university that are NOT SOLD
        $query = Product::where('university_id', $myUniversity)
                        ->where('is_sold', false);

        // 3. Apply Search Filter if user typed something in the search box
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('category', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 4. Execute query: Newest first
        $products = $query->latest()->get();

        return view('dashboard', compact('products'));
    }

    /**
     * Show the user's profile with their Student ID Card
     */
    public function profile()
    {
        // Get the logged-in user and their university info
        $user = Auth::user()->load('university');
        
        return view('auth.profile', compact('user'));
    }
}