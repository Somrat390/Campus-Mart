<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function show(Product $product, Request $request)
    {
        $userId = Auth::id();
        
        // If the seller is visiting, we need to know WHICH buyer they are talking to
        $buyerId = $request->query('buyer_id');

        $query = Message::where('product_id', $product->id);

        if ($userId == $product->user_id) {
            // I am the Seller: Show only messages with this specific buyer
            if (!$buyerId) return redirect()->route('chat.inbox');
            
            $query->where(function($q) use ($userId, $buyerId) {
                $q->where(function($sq) use ($userId, $buyerId) {
                    $sq->where('sender_id', $userId)->where('receiver_id', $buyerId);
                })->orWhere(function($sq) use ($userId, $buyerId) {
                    $sq->where('sender_id', $buyerId)->where('receiver_id', $userId);
                });
            });
        } else {
            // I am a Buyer: Show only MY messages with the seller for this product
            $buyerId = $userId;
            $query->where(function($q) use ($userId) {
                $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            });
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('product_id', $product->id)
            ->where('receiver_id', $userId)
            ->update(['is_read' => true]);

        return view('chat.show', compact('product', 'messages', 'buyerId'));
    }

    public function send(Request $request, Product $product)
    {
        $request->validate(['content' => 'required|string']);
        $userId = Auth::id();

        // If I am the owner, I'm replying to a buyer. Otherwise, I'm sending to the owner.
        if ($userId == $product->user_id) {
            $receiverId = $request->buyer_id; // Passed from the hidden input in show.blade
            $buyerId = $receiverId; 
        } else {
            $receiverId = $product->user_id;
            $buyerId = $userId;
        }

        $message = Message::create([
            'product_id' => $product->id,
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
            'content' => $request->content,
        ]);

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]
        );

        // CHANNEL FORMAT: chat.PRODUCT_ID.BUYER_ID
        $channelName = 'chat.' . $product->id . '.' . $buyerId;

        $pusher->trigger($channelName, 'message.sent', [
            'content' => $message->content,
            'sender_id' => $userId,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function inbox()
    {
        $userId = auth()->id();

        // Get unique conversations based on Product + the other person
        // This ensures a seller sees multiple rows if 5 buyers message about 1 laptop
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['product', 'sender', 'receiver'])
            ->latest()
            ->get()
            ->unique(function ($item) use ($userId) {
                $otherPersonId = ($item->sender_id == $userId) ? $item->receiver_id : $item->sender_id;
                return $item->product_id . '-' . $otherPersonId;
            });

        return view('chat.inbox', compact('conversations'));
    }
}