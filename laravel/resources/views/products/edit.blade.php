<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ad | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-2xl border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Your Listing</h2>
            <a href="{{ route('products.myAds') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Product Title</label>
                    <input type="text" name="title" value="{{ $product->title }}" 
                           class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Price (৳)</label>
                    <input type="number" name="price" value="{{ $product->price }}" 
                           class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Category</label>
                    <select name="category" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Electronics" {{ $product->category == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Books" {{ $product->category == 'Books' ? 'selected' : '' }}>Books</option>
                        <option value="Stationery" {{ $product->category == 'Stationery' ? 'selected' : '' }}>Stationery</option>
                        <option value="Other" {{ $product->category == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>{{ $product->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Update Image (Optional)</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-16 h-16 object-cover rounded-lg border">
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <p class="text-xs text-gray-400 mt-2 italic">Keep blank to use the current image.</p>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-grow bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                    Update Listing
                </button>
                <a href="{{ route('products.myAds') }}" class="px-6 py-3 border border-gray-300 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</body>
</html>