<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function show(Product $product)
    {
        // If I am the owner, I should probably be coming from the Inbox, 
        // but let's allow viewing the chat.
        $messages = Message::where('product_id', $product->id)
            ->where(function($q) use ($product) {
                $q->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();

        // Optional: Mark messages as read when opening the chat
        Message::where('product_id', $product->id)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);

        return view('chat.show', compact('product', 'messages'));
    }

    public function send(Request $request, Product $product)
    {
        $request->validate(['content' => 'required|string']);

        // LOGIC FIX: Determine who the receiver is
        // If I am the owner of the product, the receiver is the other person in the chat
        // (We get the receiver from the last message sent in this thread)
        $receiverId = $product->user_id;
        if (Auth::id() == $product->user_id) {
            $lastMessage = Message::where('product_id', $product->id)
                ->where('receiver_id', Auth::id())
                ->first();
            $receiverId = $lastMessage ? $lastMessage->sender_id : null;
        }

        if (!$receiverId) return response()->json(['error' => 'Receiver not found'], 400);

        $message = Message::create([
            'product_id' => $product->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'content' => $request->content,
        ]);

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]
        );

        // Update the specific chat window
        $pusher->trigger('chat.' . $product->id, 'message.sent', [
            'content' => $message->content,
            'sender_id' => Auth::id(),
        ]);

        // Trigger the red notification dot for the receiver
        $pusher->trigger('user.' . $receiverId, 'message.new', [
            'product_id' => $product->id
        ]);

        return response()->json(['status' => 'success']);
    }

    public function inbox()
    {
        $userId = auth()->id();

        // When the user opens the Inbox, we can mark all their received messages as read
        // or you can do this specifically when they click a chat.
        Message::where('receiver_id', $userId)->update(['is_read' => true]);

        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['product', 'sender', 'receiver'])
            ->latest()
            ->get()
            ->unique('product_id');

        return view('chat.inbox', compact('conversations'));
    }
}