@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Messages</h1>
    
    <div class="bg-white rounded-xl shadow divide-y">
        @forelse($conversations as $chat)
            @php
                $otherUser = ($chat->sender_id == auth()->id()) ? $chat->receiver : $chat->sender;
                // Important: If you are the owner, the other person is the buyer
                $buyerId = (auth()->id() == $chat->product->user_id) ? $otherUser->id : auth()->id();
            @endphp
            
            <a href="{{ route('chat.show', $chat->product->id) }}?buyer_id={{ $buyerId }}" class="flex items-center p-4 hover:bg-gray-50 transition">
                <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-4 text-xl">
                    {{ substr($otherUser->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-gray-900">{{ $otherUser->name }}</h3>
                        <span class="text-xs text-gray-400">{{ $chat->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 truncate">Item: {{ $chat->product->title }}</p>
                    <p class="text-xs text-blue-500 font-semibold mt-1">Click to chat →</p>
                </div>
            </a>
        @empty
            <div class="p-8 text-center text-gray-500">
                <p>No conversations yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection