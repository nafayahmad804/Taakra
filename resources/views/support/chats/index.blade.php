@extends('support.layouts.app')
@section('title', 'All Chats')
@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
    @forelse($users as $user)
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #4A90E2, #87CEEB); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px;">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div style="flex: 1;">
                <h3 style="font-size: 18px; font-weight: 700; color: #2c3e50;">{{ $user->name }}</h3>
                <p style="font-size: 13px; color: #6c757d;">{{ $user->email }}</p>
            </div>
            @if($user->chat_messages_count > 0)
            <span style="background: #e74c3c; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                {{ $user->chat_messages_count }}
            </span>
            @endif
        </div>
        <a href="{{ route('support.chats.show', $user) }}" class="btn-primary" style="width: 100%; text-align: center;">
            <i class="fas fa-comments"></i> Open Chat
        </a>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">
        <i class="fas fa-comments" style="font-size: 64px; color: #e9ecef; margin-bottom: 20px;"></i>
        <p style="font-size: 18px; color: #95a5a6;">No active chats yet</p>
    </div>
    @endforelse
</div>
@endsection