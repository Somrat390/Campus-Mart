@extends('layouts.app')

@section('title', 'My Ads | Campus-Mart')

@section('content')
<div class="container mx-auto mt-10 px-4 pb-20">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-black text-gray-800">Manage Your Ads</h2>
        <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-bold transition shadow-sm">
            + New Posting
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-5 font-bold text-gray-400 uppercase text-xs tracking-wider">Product</th>
                    <th class="p-5 font-bold text-gray-400 uppercase text-xs tracking-wider">Price</th>
                    <th class="p-5 font-bold text-gray-400 uppercase text-xs tracking-wider">Status</th>
                    <th class="p-5 font-bold text-gray-400 uppercase text-xs tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                    <tr class="hover:bg-blue-50/30 transition group">
                        <td class="p-5">
                            <div class="flex items-center">
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="w-16 h-16 rounded-2xl object-cover mr-4 shadow-sm">
                                <span class="font-bold text-gray-800">{{ $product->title }}</span>
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="text-blue-600 font-black text-lg">৳{{ number_format($product->price, 0) }}</span>
                        </td>
                        <td class="p-5">
                            <span class="px-3 py-1 text-[10px] font-black rounded-full {{ $product->is_sold ? 'bg-gray-100 text-gray-500' : 'bg-green-100 text-green-600' }} uppercase">
                                {{ $product->is_sold ? 'Sold Out' : 'Available' }}
                            </span>
                        </td>
                        <td class="p-5 text-right flex justify-end gap-2">
                            @if(!$product->is_sold)
                                <form action="{{ route('products.sold', $product->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold">Mark Sold</button>
                                </form>
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold">Edit</a>
                            @endif
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this ad?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-500 px-3 py-1.5 rounded-lg text-xs font-bold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-20 text-center text-gray-500">No active ads</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection