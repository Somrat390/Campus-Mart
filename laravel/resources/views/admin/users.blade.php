@extends('layouts.app')

@section('title', 'Admin - User Management')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-800">User Management</h1>
            <p class="text-gray-500">Verify new students and manage accounts</p>
        </div>
        <div class="flex gap-4">
            <div class="bg-blue-50 px-6 py-3 rounded-2xl border border-blue-100">
                <span class="block text-xs font-bold text-blue-400 uppercase">Total Users</span>
                <span class="text-2xl font-black text-blue-600">{{ $users->count() }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">Student Info</th>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">University</th>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Control</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="text-sm font-semibold text-gray-600">{{ $user->university->name ?? 'Unknown' }}</span>
                        </td>
                        <td class="p-5">
                            @if($user->is_verified)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                                    VERIFIED
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-600">
                                    PENDING
                                </span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex justify-end items-center gap-3">
                                @if(!$user->is_verified)
                                    <form action="{{ route('admin.verify', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                            Verify User
                                        </button>
                                    </form>
                                @endif

                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection