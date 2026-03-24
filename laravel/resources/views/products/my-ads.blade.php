<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ads | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="font-bold flex items-center hover:text-blue-200 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Marketplace
            </a>
            <span class="font-semibold text-lg tracking-tight">My Postings</span>
        </div>
    </nav>

    <div class="container mx-auto mt-10 px-4 pb-20">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-800">Manage Your Ads</h2>
            <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-bold transition shadow-sm">
                + New Posting
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm animate-pulse">
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
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-16 h-16 rounded-2xl object-cover mr-4 shadow-sm">
                                        @if($product->is_sold)
                                            <div class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $product->title }}</span>
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="text-blue-600 font-black text-lg">৳{{ number_format($product->price, 0) }}</span>
                            </td>
                            <td class="p-5">
                                @if($product->is_sold)
                                    <span class="px-3 py-1 text-[10px] font-black rounded-full bg-gray-100 text-gray-500 uppercase tracking-tighter">
                                        Sold Out
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-[10px] font-black rounded-full bg-green-100 text-green-600 uppercase tracking-tighter">
                                        Available
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    
                                    @if(!$product->is_sold)
                                        <form action="{{ route('products.sold', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">Mark Sold</button>
                                       </form>

                                        <a href="{{ route('products.edit', $product->id) }}" 
                                           class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            Edit
                                        </a>
                                    @endif

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Permanently delete this ad?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            Delete
                                        </button>
                                    </form>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="text-gray-300 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <h3 class="text-gray-500 text-xl font-medium">No active ads</h3>
                                <p class="text-gray-400 text-sm mt-1">Items you list for sale will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>