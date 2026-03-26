<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Show the Form to create a new ad
    public function create()
    {
        // We fetch the user's products so the table on the side/bottom doesn't error out
        $products = Product::where('user_id', Auth::id())->latest()->get();
        return view('products.create', compact('products'));
    }

    // Handle saving the new ad
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        // Handle image upload
        $path = $request->file('image')->store('products', 'public');

        // Create the product with University Isolation logic
        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image_path' => $path,
            'user_id' => auth()->id(),
            'university_id' => auth()->user()->university_id, 
            'is_sold' => false,
        ]);

        return redirect()->route('products.myAds')->with('success', 'Ad posted to your university community!');
    }

    public function show(Product $product)
    {
        $product->load('user');
        return view('products.show', compact('product'));
    }

    // This is the "Manage My Ads" page
    public function myAds()
    {
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('products.my-ads', compact('products'));
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $product->delete();
        return redirect()->route('products.myAds')->with('success', 'Ad removed successfully!');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
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
            'image' => 'nullable|image|max:2048',
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
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        $product->is_sold = 1; 
        $product->save();

        return redirect()->route('products.myAds')->with('success', 'Item marked as sold!');
    }
}