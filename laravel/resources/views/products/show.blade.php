<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->title }} | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold">Campus-Mart</a>
            <a href="{{ route('dashboard') }}" class="text-sm bg-blue-700 px-4 py-2 rounded-lg hover:bg-blue-800 transition">← Back to Marketplace</a>
        </div>
    </nav>

    <div class="container mx-auto mt-10 px-4 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-[500px] object-cover" alt="{{ $product->title }}">
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-blue-600 font-bold uppercase text-xs tracking-widest">{{ $product->category }}</span>
                            <h1 class="text-4xl font-black text-gray-900 mt-1">{{ $product->title }}</h1>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-black text-blue-600">৳{{ number_format($product->price, 0) }}</p>
                            <p class="text-gray-400 text-sm">Posted {{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <hr class="my-6 border-gray-100">
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        {{ $product->description }}
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-blue-100 sticky top-10">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Seller Details
                    </h3>

                    <div class="flex items-center space-x-4 mb-6">
                        <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-black">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $product->user->name }}</h4>
                            <p class="text-gray-500 text-sm">Verified Student</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-2xl">
                            <p class="text-xs font-bold text-gray-400 uppercase">University</p>
                            <p class="text-gray-800 font-semibold">{{ $product->user->university->name }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-2xl">
                            <p class="text-xs font-bold text-gray-400 uppercase">Contact Email</p>
                            <p class="text-gray-800 font-semibold break-all">{{ $product->user->email }}</p>
                        </div>
                    </div>

                    <a href="{{ route('chat.show', $product->id) }}" 
                    class="block w-full mt-8 bg-blue-600 text-white text-center py-4 rounded-2xl font-bold hover:bg-blue-700 transition">
                        Chat with Seller (Live)
                    </a>
                    
                    <p class="text-center text-[10px] text-gray-400 mt-4 uppercase font-bold tracking-tighter">
                        Safety Tip: Meet on campus for the transaction.
                    </p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>