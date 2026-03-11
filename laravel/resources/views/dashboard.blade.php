<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth transition for card hovers */
        .product-card { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-tight">Campus-Mart</h1>
            <div class="flex items-center space-x-6">
                <span class="hidden md:block">Welcome, **{{ Auth::user()->name }}**</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-1.5 rounded-md text-sm font-semibold transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4 pb-12">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Marketplace</h2>
                <p class="text-gray-500 text-sm">Browsing items at **{{ Auth::user()->university->name }}**</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition text-center">
                + Sell Something
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="group block">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden product-card group-hover:shadow-xl group-hover:-translate-y-1">
                        
                        <div class="relative h-56 w-full bg-gray-200">
                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                 alt="{{ $product->title }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <span class="bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold uppercase text-gray-600 shadow-sm">
                                    {{ $product->category }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition mb-1">
                                {{ $product->title }}
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-2 h-10 mb-4">
                                {{ Str::limit($product->description, 60) }}
                            </p>
                            
                            <div class="flex justify-between items-center">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-400 font-medium">Price</span>
                                    <span class="text-blue-600 font-extrabold text-xl">৳{{ number_format($product->price, 0) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-gray-400 block">Posted by</span>
                                    <span class="text-xs font-semibold text-gray-700">{{ $product->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center">
                    <div class="bg-gray-50 p-4 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="box"></path>
                        </svg>
                    </div>
                    <h3 class="text-gray-500 text-xl font-medium">No items available</h3>
                    <p class="text-gray-400 mt-1">Be the first student to post something for sale!</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>