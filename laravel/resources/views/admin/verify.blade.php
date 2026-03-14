<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Verification | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Pending Student Verifications</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-600 font-semibold">← Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($users as $user)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col gap-4">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    </div>

                    <div class="border rounded-lg overflow-hidden bg-gray-50">
                        <p class="text-[10px] p-1 text-gray-400 uppercase font-bold text-center border-b bg-white">Uploaded ID Card</p>
                        <img src="{{ asset('storage/' . $user->student_id_image) }}" 
                             alt="Student ID" 
                             class="w-full h-48 object-contain p-2">
                    </div>

                    <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white py-2.5 rounded-lg font-bold hover:bg-green-700 transition shadow-md">
                            Approve Student
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-20 bg-white rounded-xl border-2 border-dashed border-gray-200 text-center">
                    <p class="text-gray-500 text-lg font-medium">No pending verifications.</p>
                    <p class="text-gray-400 text-sm">All registered students are currently verified!</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>