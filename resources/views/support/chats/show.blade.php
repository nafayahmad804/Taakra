@extends('support.layouts.app')
@section('title', 'Chat with ' . $user->name)
@section('content')
<div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); height: calc(100vh - 200px); display: flex; flex-direction: column;">
    <div style="padding: 24px; border-bottom: 2px solid #e9ecef;">
        <h2 style="font-size: 24px; font-weight: 700; color: #2c3e50;">Chat with {{ $user->name }}</h2>
        <p style="font-size: 14px; color: #6c757d;">{{ $user->email }}</p>
    </div>
    
    <div id="chatMessages" style="flex: 1; padding: 24px; overflow-y: auto; background: #f8f9fa;">
        @foreach($messages as $message)
        <div style="margin-bottom: 16px; display: flex; {{ $message->sender_type === 'user' ? 'justify-content: flex-start' : 'justify-content: flex-end' }};">
            <div style="max-width: 70%;">
                <div style="background: {{ $message->sender_type === 'user' ? 'white' : 'linear-gradient(135deg, #4A90E2, #357ABD)' }}; color: {{ $message->sender_type === 'user' ? '#2c3e50' : 'white' }}; padding: 12px 16px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    {{ $message->message }}
                </div>
                <div style="font-size: 11px; color: #95a5a6; margin-top: 4px; {{ $message->sender_type === 'user' ? 'text-align: left' : 'text-align: right' }};">
                    {{ $message->created_at->format('H:i') }} • {{ $message->sender_type === 'bot' ? 'Bot' : ($message->sender_type === 'support' ? 'You' : $user->name) }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <form action="{{ route('support.chats.send', $user) }}" method="POST" style="padding: 24px; border-top: 2px solid #e9ecef; background: white;">
        @csrf
        <div style="display: flex; gap: 12px;">
            <input type="text" name="message" placeholder="Type your message..." required style="flex: 1; padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px;" autofocus>
            <button type="submit" class="btn-primary" style="padding: 12px 32px;">
                <i class="fas fa-paper-plane"></i> Send
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
</script>

@push('scripts')
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    const socket = io('http://localhost:3000');
    const userId = {{ $user->id }};

    socket.on('connect', () => {
        socket.emit('user:join', {
            userId: {{ auth()->id() }},
            userName: "{{ auth()->user()->name }}",
            userEmail: "{{ auth()->user()->email }}",
            role: "{{ auth()->user()->role }}"
        });
    });

    socket.on('message:receive', (message) => {
        if (message.userId == userId) {
            const messagesDiv = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.style.marginBottom = '16px';
            messageDiv.style.display = 'flex';
            messageDiv.style.justifyContent = 'flex-start';
            
            messageDiv.innerHTML = `
                <div style="max-width: 70%;">
                    <div style="background: white; color: #2c3e50; padding: 12px 16px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        ${escapeHtml(message.message)}
                    </div>
                    <div style="font-size: 11px; color: #95a5a6; margin-top: 4px; text-align: left;">
                        Just now • ${message.userName}
                    </div>
                </div>
            `;
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    });

    function sendSocketMessage(formData) {
        const message = formData.get('message');
        if (message && message.trim()) {
            socket.emit('message:send', {
                message: message.trim(),
                targetUserId: userId,
                timestamp: new Date().toISOString()
            });
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const formData = new FormData(this);
        sendSocketMessage(formData);
    });
</script>
@endpush
@endsection