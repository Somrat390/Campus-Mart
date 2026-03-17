<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Campus Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Join Your Campus Market</h2>
        
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 shadow-sm">
            <strong class="font-bold">Wait! </strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
            @csrf <div class="mb-4">
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">University Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Select Your University</label>
                <select name="university_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Select University --</option>
                    @foreach($universities as $university)
                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Upload Student ID Card (Image)</label>
                <input type="file" name="student_id_image" accept="image/*" class="w-full px-4 py-2 border rounded-lg" required>
                <p class="text-xs text-gray-500 mt-1">This is used for fraud prevention.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Create Account
            </button>
        </form>
    </div>

</body>
</html>