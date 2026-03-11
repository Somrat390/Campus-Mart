<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // ... (your existing store logic)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');

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

    /**
     * ADD THE SHOW METHOD HERE
     */
    public function show(Product $product)
    {
        // This ensures we can access the seller's name via $product->user->name
        $product->load('user');
        
        return view('products.show', compact('product'));
    }
}