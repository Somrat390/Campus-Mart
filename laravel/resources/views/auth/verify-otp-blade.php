<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Account | Campus-Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Verify Your Email</h2>
        <p class="text-gray-500 mb-8 text-sm">We've sent a 6-digit verification code to your university email address.</p>

        @if($errors->any())
            <p class="text-red-500 text-sm mb-4">{{ $errors->first('otp') }}</p>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf
            <input type="text" name="otp" maxlength="6" 
                   class="w-full text-center text-4xl font-mono tracking-[1rem] py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 outline-none mb-6" 
                   placeholder="000000" required autofocus>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                Verify & Proceed
            </button>
        </form>
        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif
        <div class="mt-6">
            <form action="{{ route('otp.resend') }}" method="POST">
                @csrf
                <button type="submit" class="text-blue-600 hover:underline text-sm font-semibold">
                    Didn't receive a code? Resend
                </button>
            </form>
        </div>
    </div>
</body>
</html>