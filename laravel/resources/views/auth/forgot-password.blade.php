@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-screen">
    <form action="{{ route('password.email') }}" method="POST" class="bg-white p-8 rounded shadow-md w-96">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Forgot Password</h2>
        <input type="email" name="email" placeholder="Enter your email" class="w-full border p-2 mb-4" required>
        <button type="submit" class="bg-blue-600 text-white w-full py-2 rounded">Send Reset Link</button>
    </form>
</div>
@endsection