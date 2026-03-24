<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatController extends Controller
{
    // 1. Open the chat window
    public function show(Product $product)
    {
        if ($product->user_id === Auth::id()) {
            return back()->with('error', 'You cannot message yourself!');
        }

        $messages = Message::where('product_id', $product->id)
            ->where(function($q) use ($product) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $product->user_id);
            })->orWhere(function($q) use ($product) {
                $q->where('sender_id', $product->user_id)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();

        return view('chat.show', compact('product', 'messages'));
    }

    // 2. Send message and trigger Pusher
    public function send(Request $request, Product $product)
    {
        $request->validate(['content' => 'required|string']);

        $message = Message::create([
            'product_id' => $product->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $product->user_id,
            'content' => $request->content,
        ]);

        // Trigger Pusher Live Event
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]
        );

        $pusher->trigger('chat.' . $product->id, 'message.sent', [
            'content' => $message->content,
            'sender_id' => Auth::id(),
        ]);

        return response()->json(['status' => 'success']);
    }
}