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
            <a href="{{ route('dashboard') }}" class="font-bold">← Back to Marketplace</a>
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

                <div class="mt-8 bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Listed by</p>
                        <p class="font-bold text-gray-800">{{ $product->user->name }}</p>
                    </div>
                    <a href="mailto:{{ $product->user->email }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                        Contact Seller
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