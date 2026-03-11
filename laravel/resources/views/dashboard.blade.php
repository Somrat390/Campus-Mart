<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Campus-Mart</h1>
            <div class="flex items-center space-x-4">
                <span>Welcome, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 text-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Marketplace: {{ Auth::user()->university->name }}
            </h2>
            <a href="{{ route('products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + Sell Something
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border hover:shadow-md transition">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="h-48 w-full object-cover">
                    
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-900">{{ $product->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 50) }}</p>
                        
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-blue-600 font-bold text-lg">৳{{ number_format($product->price, 0) }}</span>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-500 uppercase tracking-wider">{{ $product->category }}</span>
                        </div>
                        
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center text-xs text-gray-400">
                            <span>Posted by: {{ $product->user->name }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-lg border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 text-lg">No items for sale in your campus yet.</p>
                    <p class="text-gray-400 text-sm mt-1">Be the first to list a product!</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>