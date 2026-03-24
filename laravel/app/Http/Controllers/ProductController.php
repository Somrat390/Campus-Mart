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
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'category' => 'required',
        'image' => 'required|image|max:2048',
    ]);

    // Handle image upload
    $path = $request->file('image')->store('products', 'public');

    // Create the product
    \App\Models\Product::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'category' => $request->category,
        'image_path' => $path,
        'user_id' => auth()->id(), // The Student ID
        
        // --- THIS IS THE ISOLATION LOGIC ---
        // Automatically tag the product with the student's university
        'university_id' => auth()->user()->university_id, 
        
        'is_sold' => false,
    ]);

    return redirect()->route('dashboard')->with('success', 'Ad posted to your university community!');
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
    // Show only the items posted by the logged-in student
    public function myAds()
    {
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('products.my-ads', compact('products'));
    }

// Delete an ad
    public function destroy(Product $product)
    {
        // Security check: Ensure the user owns the product they are deleting
        if ($product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $product->delete();

        return redirect()->route('products.myAds')->with('success', 'Ad removed successfully!');
    }

    public function edit(Product $product)
    {
        // Security: Only the owner can edit
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'price', 'category']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.myAds')->with('success', 'Ad updated successfully!');
    }

    public function markAsSold(Product $product)
    {
    // 1. Security check
    if ($product->user_id !== auth()->id()) {
        abort(403);
    }

    // 2. Direct assignment (bypasses fillable issues)
    $product->is_sold = 1; 
    $product->save();

    return redirect()->route('products.myAds')->with('success', 'Item marked as sold!');
    }
}