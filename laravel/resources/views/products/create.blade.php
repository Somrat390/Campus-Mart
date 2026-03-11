<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sell Item | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Post a New Item for Sale</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold">Item Name</label>
                <input type="text" name="title" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-semibold">Price (৳)</label>
                    <input type="number" name="price" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block font-semibold">Category</label>
                    <select name="category" class="w-full border p-2 rounded" required>
                        <option value="Books">Books</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Description</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="4" required></textarea>
            </div>

            <div class="mb-6">
                <label class="block font-semibold">Upload Image</label>
                <input type="file" name="image" class="w-full" required>
            </div>

            <div class="flex justify-between items-center border-t pt-4">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:underline">Back to Dashboard</a>
                <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg font-bold hover:bg-blue-700">Post Item</button>
            </div>
        </form>
    </div>
</body>
</html>