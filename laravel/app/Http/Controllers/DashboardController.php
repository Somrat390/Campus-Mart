<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the university ID of the logged-in student
        $universityId = Auth::user()->university_id;

        // Fetch only products from the same university that are 'active'
        $products = Product::where('university_id', $universityId)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('dashboard', compact('products'));
    }
}