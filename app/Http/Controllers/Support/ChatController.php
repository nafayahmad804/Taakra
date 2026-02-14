<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::whereHas('chatMessages')
            ->withCount(['chatMessages' => function ($query) {
                $query->where('is_read', false)
                    ->where('sender_type', 'user');
            }])
            ->orderByDesc('chat_messages_count')
            ->get();

        return view('support.chats.index', compact('users'));
    }

    public function show(User $user)
    {
        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        ChatMessage::where('user_id', $user->id)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('support.chats.show', compact('user', 'messages'));
    }

    public function sendMessage(Request $request, User $user)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        ChatMessage::create([
            'user_id' => $user->id,
            'support_id' => Auth::id(),
            'message' => $validated['message'],
            'sender_type' => 'support',
            'is_read' => true
        ]);

        return back()->with('success', 'Message sent successfully');
    }

    public function claimChat(User $user)
    {
        ChatMessage::where('user_id', $user->id)
            ->whereNull('support_id')
            ->update(['support_id' => Auth::id()]);

        return redirect()->route('support.chats.show', $user)->with('success', 'Chat claimed successfully');
    }
}
