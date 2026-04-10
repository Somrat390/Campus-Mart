@extends('layouts.app')

@section('title', 'Dashboard | Campus-Mart')

@section('content')
<div class="container mx-auto mt-8 px-4 pb-12">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800">Marketplace</h2>
            <p class="text-gray-500 text-sm">Browsing items at **{{ Auth::user()->university->name }}**</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('products.myAds') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition shadow-sm">
                My Ads
            </a>
            <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition text-center">
                + Sell Something
            </a>
        </div>
    </div>

    <div class="mb-10">
        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books, electronics..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition bg-white shadow-sm">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold transition shadow-md">Search</button>
            @if(request('search'))
                <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold flex items-center justify-center">Clear</a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="group block">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden product-card group-hover:shadow-2xl group-hover:-translate-y-2 transition-all duration-300">
                    <div class="relative h-56 bg-gray-200">
                        {{-- SMART IMAGE LOGIC: Checks if it's a Cloudinary URL or Local Storage --}}
                        <img src="{{ str_starts_with($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='https://placehold.co/600x400?text=No+Image+Found'">
                        
                        <span class="absolute top-3 right-3 bg-white/95 px-3 py-1 rounded-full text-[10px] font-black uppercase text-blue-600 shadow-sm">{{ $product->category }}</span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg group-hover:text-blue-600 transition mb-1">{{ $product->title }}</h3>
                        <p class="text-gray-500 text-sm h-10 mb-4 line-clamp-2">{{ $product->description }}</p>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                            <span class="text-blue-600 font-black text-xl">৳{{ number_format($product->price, 0) }}</span>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-tight">{{ $product->user->name }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-24 text-center text-gray-500">
                <h3 class="text-xl font-medium">No items found in your campus</h3>
            </div>
        @endforelse
    </div>
</div>
@endsection