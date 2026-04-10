<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $products = Product::where('user_id', Auth::id())->latest()->get();
        return view('products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        // Save to 'public' folder inside storage
        $path = $request->file('image')->store('products', 'public');

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

        return redirect()->route('products.myAds')->with('success', 'Ad posted successfully!');
    }

    public function show(Product $product)
    {
        $product->load('user');
        return view('products.show', compact('product'));
    }

    public function myAds()
    {
        $products = Product::where('user_id', Auth::id())->latest()->get();
        return view('products.my-ads', compact('products'));
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'price', 'category']);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.myAds')->with('success', 'Ad updated!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) return back()->with('error', 'Unauthorized.');
        if ($product->image_path) Storage::disk('public')->delete($product->image_path);
        $product->delete();
        return redirect()->route('products.myAds')->with('success', 'Ad removed!');
    }

    public function markAsSold(Product $product)
    {
        if ($product->user_id !== auth()->id()) abort(403);
        $product->update(['is_sold' => true]);
        return redirect()->route('products.myAds')->with('success', 'Item marked as sold!');
    }
}