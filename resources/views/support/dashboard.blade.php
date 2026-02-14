@extends('support.layouts.app')
@section('title', 'Support Dashboard')
@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #e74c3c;">
        <div style="font-size: 14px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Pending Chats</div>
        <div style="font-size: 48px; font-weight: 800; color: #e74c3c; margin-bottom: 8px;">{{ $activeChats }}</div>
        <div style="font-size: 13px; color: #95a5a6;">Need immediate attention</div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #4A90E2;">
        <div style="font-size: 14px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">My Active Chats</div>
        <div style="font-size: 48px; font-weight: 800; color: #4A90E2; margin-bottom: 8px;">{{ $myChats }}</div>
        <div style="font-size: 13px; color: #95a5a6;">Currently handling</div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #27ae60;">
        <div style="font-size: 14px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Total Messages</div>
        <div style="font-size: 48px; font-weight: 800; color: #27ae60; margin-bottom: 8px;">{{ $totalMessages }}</div>
        <div style="font-size: 13px; color: #95a5a6;">Messages sent today</div>
    </div>
</div>

<div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <h2 style="font-size: 24px; font-weight: 700; color: #2c3e50; margin-bottom: 24px;">Pending User Chats</h2>
    
    @forelse($pendingChats as $user)
    <div style="padding: 20px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
        <div style="flex: 1;">
            <h3 style="font-size: 18px; font-weight: 600; color: #2c3e50; margin-bottom: 8px;">{{ $user->name }}</h3>
            <p style="font-size: 14px; color: #6c757d; margin-bottom: 4px;">{{ $user->email }}</p>
            @if($user->chatMessages->first())
            <p style="font-size: 13px; color: #95a5a6;">Last message: {{ $user->chatMessages->first()->created_at->diffForHumans() }}</p>
            @endif
        </div>
        <a href="{{ route('support.chats.show', $user) }}" class="btn-primary">View Chat</a>
    </div>
    @empty
    <div style="text-align: center; padding: 60px 20px; color: #95a5a6;">
        <i class="fas fa-check-circle" style="font-size: 64px; margin-bottom: 20px;"></i>
        <p style="font-size: 18px;">All caught up! No pending chats.</p>
    </div>
    @endforelse
</div>
@endsection