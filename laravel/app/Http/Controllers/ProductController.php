<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

        // --- CLOUDINARY UPLOAD ---
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'products'
        ])->getSecurePath();

        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image_path' => $uploadedFileUrl, // Stores full HTTPS Cloudinary URL
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
            // Upload new image to Cloudinary
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'products'
            ])->getSecurePath();
            
            $data['image_path'] = $uploadedFileUrl;
        }

        $product->update($data);
        return redirect()->route('products.myAds')->with('success', 'Ad updated!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) return back()->with('error', 'Unauthorized.');
        
        // Note: For Cloudinary, you'd usually delete by Public ID, 
        // but for a student project, simply deleting the DB record is fine.
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