@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-screen">
    <form action="{{ route('password.update') }}" method="POST" class="bg-white p-8 rounded shadow-md w-96">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <h2 class="text-2xl font-bold mb-4">New Password</h2>
        <input type="email" name="email" value="{{ request()->email }}" class="w-full border p-2 mb-4" readonly>
        <input type="password" name="password" placeholder="New Password" class="w-full border p-2 mb-4" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border p-2 mb-4" required>
        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded">Update Password</button>
    </form>
</div>
@endsection