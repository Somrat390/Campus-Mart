<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | Campus Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-2 text-blue-600">Verify Your Email</h2>
        <p class="text-gray-600 mb-6">We sent a 6-digit code to <br><span class="font-bold text-blue-800">{{ $email }}</span></p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm font-bold">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 text-green-600 p-3 rounded-lg mb-4 text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <input type="text" name="otp" placeholder="Enter 6-digit code" 
                   class="w-full px-4 py-3 border-2 rounded-lg text-center text-2xl tracking-widest focus:border-blue-500 outline-none mb-4" 
                   maxlength="6" required autofocus>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                Verify Account
            </button>
        </form>

        <form action="{{ route('otp.resend') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <button type="submit" class="text-sm text-blue-500 hover:underline">
                Didn't get the code? Resend OTP
            </button>
        </form>
        
        <div class="mt-6">
            <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-blue-600 underline">Back to Login</a>
        </div>
    </div>
</body>
</html>