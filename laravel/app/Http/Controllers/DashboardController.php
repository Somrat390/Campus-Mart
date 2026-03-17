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
    $products = \App\Models\Product::where('university_id', $myUniversity)
                ->where('is_sold', false) // Don't show sold items
                ->latest()                // Newest first
                ->get();

    // 3. Pass data to the view
    return view('dashboard', compact('products'));
    }
}