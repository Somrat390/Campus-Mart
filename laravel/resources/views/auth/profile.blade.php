@extends('layouts.app')

@section('title', 'My Profile | Campus-Mart')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">My Profile</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 h-32"></div>
        
        <div class="px-8 pb-8">
            <div class="relative -mt-12 mb-6">
                <div class="inline-block p-2 bg-white rounded-full shadow-lg">
                    <div class="h-24 w-24 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-3xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Full Name</label>
                        <p class="text-lg text-gray-800 font-semibold">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">University Email</label>
                        <p class="text-lg text-gray-800 font-semibold">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Campus</label>
                        <p class="text-lg text-gray-800 font-semibold">{{ $user->university->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 block">Uploaded Student ID</label>
                    @if($user->student_id_image)
                        <img src="{{ asset('storage/' . $user->student_id_image) }}" 
                             class="w-full rounded-lg shadow-md border bg-white" 
                             onerror="this.src='https://placehold.co/400x250?text=ID+Image+Pending'">
                    @else
                        <p class="text-gray-400 italic">No ID Image Found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection