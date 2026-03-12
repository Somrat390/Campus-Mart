<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->title }} | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="container mx-auto">
            <a href="{{ route('dashboard') }}" class="font-bold hover:text-blue-100 transition">← Back to Marketplace</a>
        </div>
    </nav>

    <div class="container mx-auto mt-10 px-4">
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-1/2">
                <img src="{{ asset('storage/' . $product->image_path) }}" 
                     alt="{{ $product->title }}" 
                     class="w-full h-full object-cover min-h-[400px]">
            </div>

            <div class="md:w-1/2 p-8">
                <span class="text-sm font-bold text-blue-600 uppercase tracking-widest">{{ $product->category }}</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->title }}</h1>
                
                <div class="mt-4">
                    <span class="text-4xl font-bold text-gray-900">৳{{ number_format($product->price, 0) }}</span>
                </div>

                <div class="mt-6 border-t border-b py-6">
                    <h2 class="text-lg font-semibold text-gray-800">Description</h2>
                    <p class="text-gray-600 mt-2 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="mt-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Listed by</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $product->user->name }}</p>
                        </div>
                        <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                            {{ substr($product->user->name, 0, 1) }}
                        </div>
                    </div>

                    <a href="mailto:{{ $product->user->email }}?subject=Interested in your item: {{ $product->title }} on Campus-Mart" 
                       class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition block text-center shadow-md">
                        Contact Seller via Email
                    </a>
                </div>
                
                <p class="text-xs text-center text-gray-400 mt-4 italic">
                    Safety Tip: Meet in a public campus area for the exchange.
                </p>
            </div>
        </div>
    </div>

</body>
</html>