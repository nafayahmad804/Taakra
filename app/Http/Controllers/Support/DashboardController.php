<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activeChats = ChatMessage::where('sender_type', 'user')
            ->where('is_read', false)
            ->whereNull('support_id')
            ->select('user_id')
            ->distinct()
            ->count();

        $myChats = ChatMessage::where('support_id', Auth::id())
            ->select('user_id')
            ->distinct()
            ->count();

        $totalMessages = ChatMessage::where('support_id', Auth::id())->count();

        $pendingChats = User::whereHas('chatMessages', function ($query) {
            $query->where('sender_type', 'user')
                ->where('is_read', false)
                ->whereNull('support_id');
        })->with(['chatMessages' => function ($query) {
            $query->latest()->take(1);
        }])->get();

        return view('support.dashboard', compact('activeChats', 'myChats', 'totalMessages', 'pendingChats'));
    }
}
