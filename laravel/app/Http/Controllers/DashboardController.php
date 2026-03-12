<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request){
        
        $universityId = Auth::user()->university_id;
        $search = $request->input('search');

        $products = Product::where('university_id', $universityId)
            ->where('status', 'active')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('dashboard', compact('products'));
    }
}