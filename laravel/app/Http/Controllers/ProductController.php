<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Show the form to create a new product
    public function create()
    {
        return view('products.create');
    }

    // Store the product in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle Image Upload
        $path = $request->file('image')->store('products', 'public');

        // Create the product linked to the user's university
        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image_path' => $path,
            'status' => 'active',
            'user_id' => Auth::id(),
            'university_id' => Auth::user()->university_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Item posted successfully!');
    }
}