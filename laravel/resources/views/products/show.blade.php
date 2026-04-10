@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            
            <div class="md:w-1/2 bg-gray-50">
                {{-- Smart Image Logic: Cloudinary vs Local Storage --}}
                <img src="{{ str_starts_with($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}" 
                     alt="{{ $product->title }}" 
                     class="w-full h-[400px] object-cover"
                     onerror="this.src='https://placehold.co/600x400?text=Product+Image+Not+Found'">
            </div>

            <div class="md:w-1/2 p-8 md:p-12 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">{{ $product->category }}</span>
                        <h1 class="text-3xl font-black text-gray-800 mt-1">{{ $product->title }}</h1>
                    </div>
                    <div class="text-2xl font-black text-blue-600">৳{{ number_format($product->price, 0) }}</div>
                </div>

                <p class="text-gray-600 leading-relaxed mb-8">
                    {{ $product->description }}
                </p>

                <div class="mt-auto p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-3">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Seller</p>
                            <p class="text-sm font-bold text-gray-800">{{ $product->user->name }}</p>
                        </div>
                    </div>
                    
                    @if(auth()->id() !== $product->user_id)
                        <a href="{{ route('chat.show', $product->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition shadow-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Chat Now
                        </a>
                    @else
                        <span class="text-xs font-bold text-gray-400 italic">This is your listing</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection