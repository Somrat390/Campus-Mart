<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Campus-Mart')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        .product-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight">Campus-Mart</a>
            
            <div class="flex items-center space-x-4 md:space-x-6">
                
                @php
                    // Check database for unread messages for the logged-in user
                    $hasUnread = \App\Models\Message::where('receiver_id', auth()->id())
                                                    ->where('is_read', false)
                                                    ->exists();
                @endphp

                <a href="{{ route('chat.inbox') }}" id="inbox-link" class="flex items-center hover:text-blue-200 transition relative">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <span class="hidden sm:block text-sm font-semibold">Messages</span>

                    <span id="global-msg-dot" class="{{ $hasUnread ? '' : 'hidden' }} absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </a>

                <a href="{{ route('profile') }}" class="flex items-center hover:text-blue-200 transition">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="hidden sm:block text-sm font-semibold">My Profile</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-1.5 rounded-md text-sm font-semibold transition shadow-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script>
        // 1. Initialize Pusher
        const globalPusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}'
        });

        // 2. Subscribe to user-specific channel
        const globalChannel = globalPusher.subscribe('user.{{ auth()->id() }}');
        
        globalChannel.bind('message.new', function(data) {
            const currentUrl = window.location.href;
            // Only show dot if we aren't already looking at that specific chat
            if (!currentUrl.includes('/chat/' + data.product_id)) {
                document.getElementById('global-msg-dot').classList.remove('hidden');
            }
        });

        // 3. Hide dot immediately when clicking the Inbox link
        document.getElementById('inbox-link').addEventListener('click', function() {
            document.getElementById('global-msg-dot').classList.add('hidden');
        });
    </script>

</body>
</html>