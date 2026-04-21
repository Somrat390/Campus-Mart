<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat: {{ $product->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col">

    <div class="bg-blue-600 text-white p-4 shadow-md flex items-center gap-4">
        <a href="{{ route('chat.inbox') }}" class="text-xl">←</a>
        <div>
            <h1 class="font-bold text-lg leading-tight">{{ $product->title }}</h1>
            <p class="text-xs opacity-80">Talking with: {{ (auth()->id() == $product->user_id) ? 'Buyer' : 'Seller' }}</p>
        </div>
    </div>

    <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach($messages as $message)
            @php $isMe = $message->sender_id == auth()->id(); @endphp
            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] px-4 py-2 rounded-2xl shadow {{ $isMe ? 'bg-blue-500 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border' }}">
                    <p>{{ $message->content }}</p>
                    <span class="text-[10px] block mt-1 opacity-70">{{ $message->created_at->format('H:i') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white p-4 border-t">
        <form id="chat-form" class="flex gap-2">
            @csrf
            {{-- Pass the buyer_id so the controller knows which channel to trigger --}}
            <input type="hidden" id="buyer_id" value="{{ $buyerId }}">
            
            <input type="text" id="message-input" placeholder="Type your message..." 
                class="flex-1 border border-gray-300 rounded-full px-4 py-2 outline-none">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold">Send</button>
        </form>
    </div>

    <script>
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', { cluster: '{{ env("PUSHER_APP_CLUSTER") }}' });

        // UNIQUE CHANNEL SUBSCRIPTION
        const channel = pusher.subscribe('chat.{{ $product->id }}.{{ $buyerId }}');

        channel.bind('message.sent', function(data) {
            if (data.sender_id != "{{ auth()->id() }}") {
                appendMessage(data.content, 'other');
            }
        });

        $('#chat-form').on('submit', function(e) {
            e.preventDefault();
            const content = $('#message-input').val();
            const buyer_id = $('#buyer_id').val();
            if (content.trim() === '') return;

            appendMessage(content, 'me');
            $('#message-input').val('');

            $.post("{{ route('chat.send', $product->id) }}", {
                _token: "{{ csrf_token() }}",
                content: content,
                buyer_id: buyer_id
            });
        });

        function appendMessage(content, type) {
            const isMe = type === 'me';
            const alignment = isMe ? 'justify-end' : 'justify-start';
            const colors = isMe ? 'bg-blue-500 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border';
            const html = `<div class="flex ${alignment}"><div class="max-w-[80%] px-4 py-2 rounded-2xl shadow ${colors}"><p>${content}</p></div></div>`;
            $('#chat-box').append(html);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    </script>
</body>
</html>