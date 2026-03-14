<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .product-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-tight">Campus-Mart</h1>
            <div class="flex items-center space-x-6">
                @if(Auth::user()->is_admin)
                <a href="{{ route('admin.verify') }}" class="bg-yellow-400 text-blue-900 px-3 py-1 rounded-md text-sm font-bold hover:bg-yellow-300 transition">
                    Admin: Verify Users
                </a>
                @endif
                <span class="hidden md:block">Welcome, **{{ Auth::user()->name }}**</span>
                
                <form action="{{ route('logout') }}" method="POST" class="inline" id="logout-form">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-1.5 rounded-md text-sm font-semibold transition shadow-sm">
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
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
    
    <div class="flex gap-2">
        <a href="{{ route('products.myAds') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition">
            My Ads
        </a>
        <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition text-center">
            + Sell Something
        </a>
    </div>
</div>
        </div>

        <div class="mb-8">
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books, electronics..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold transition">Search</button>
                @if(request('search'))
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-semibold flex items-center justify-center">Clear</a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="group block">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden product-card group-hover:shadow-xl group-hover:-translate-y-1">
                        <div class="relative h-56 bg-gray-200">
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover">
                            <span class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-[10px] font-bold uppercase text-gray-600">{{ $product->category }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg group-hover:text-blue-600 mb-1">{{ $product->title }}</h3>
                            <p class="text-gray-500 text-sm h-10 mb-4">{{ Str::limit($product->description, 60) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-extrabold text-xl">৳{{ number_format($product->price, 0) }}</span>
                                <span class="text-xs font-semibold text-gray-700">{{ $product->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <h3 class="text-gray-500 text-xl">No items found</h3>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>