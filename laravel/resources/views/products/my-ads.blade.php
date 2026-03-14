<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Ads | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('dashboard') }}" class="font-bold">← Back to Marketplace</a>
            <span class="font-semibold">My Postings</span>
        </div>
    </nav>

    <div class="container mx-auto mt-10 px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage Your Ads</h2>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">Product</th>
                        <th class="p-4 font-semibold text-gray-600">Price</th>
                        <th class="p-4 font-semibold text-gray-600">Status</th>
                        <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-4 flex items-center">
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="w-12 h-12 rounded object-cover mr-4">
                                <span class="font-medium text-gray-900">{{ $product->title }}</span>
                            </td>
                            <td class="p-4 text-blue-600 font-bold">৳{{ number_format($product->price, 0) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-600 uppercase">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end items-center gap-4">
                                    
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                    class="text-blue-600 hover:text-blue-800 font-bold text-sm transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm transition">
                                            Delete
                                        </button>
                                    </form>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400">
                                You haven't posted any ads yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>