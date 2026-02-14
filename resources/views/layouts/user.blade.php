<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Taakra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Sora', -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f4f8; }
        
        .navbar { background: white; box-shadow: 0 2px 20px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1400px; margin: 0 auto; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .navbar-brand { font-size: 28px; font-weight: 800; background: linear-gradient(135deg, #4A90E2, #87CEEB); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-decoration: none; }
        .navbar-menu { display: flex; gap: 32px; align-items: center; }
        .navbar-link { color: #495057; text-decoration: none; font-weight: 600; font-size: 15px; transition: all 0.3s; position: relative; }
        .navbar-link:hover { color: #4A90E2; }
        .navbar-link.active { color: #4A90E2; }
        .navbar-link.active::after { content: ''; position: absolute; bottom: -8px; left: 0; right: 0; height: 2px; background: #4A90E2; }
        .user-menu { position: relative; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4A90E2, #87CEEB); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; cursor: pointer; transition: all 0.3s; }
        .user-avatar:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(74,144,226,0.3); }
        
        .main-content { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
        
        .btn-primary { background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; padding: 12px 28px; border-radius: 10px; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-weight: 600; font-size: 15px; box-shadow: 0 4px 12px rgba(74,144,226,0.2); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(74,144,226,0.3); }
        
        .badge { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        
        .chat-widget { position: fixed; bottom: 24px; right: 24px; z-index: 1000; }
        .chat-button { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; border: none; cursor: pointer; font-size: 24px; box-shadow: 0 8px 24px rgba(74,144,226,0.4); transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .chat-button:hover { transform: scale(1.1); box-shadow: 0 12px 32px rgba(74,144,226,0.5); }
        .chat-button.active { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        
        .chat-window { position: fixed; bottom: 100px; right: 24px; width: 400px; height: 600px; background: white; border-radius: 16px; box-shadow: 0 12px 48px rgba(0,0,0,0.15); display: none; flex-direction: column; overflow: hidden; }
        .chat-window.active { display:contents; }
        .chat-header { background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .chat-header h3 { font-size: 18px; font-weight: 700; }
        .chat-close { background: none; border: none; color: white; font-size: 20px; cursor: pointer; }
        .chat-messages { flex: 1; padding: 20px; overflow-y: auto; background: #f8f9fa; }
        .chat-message { margin-bottom: 16px; }
        .chat-message.user { text-align: right; }
        .chat-bubble { display: inline-block; padding: 12px 16px; border-radius: 12px; max-width: 80%; }
        .chat-message.bot .chat-bubble { background: white; color: #2c3e50; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .chat-message.user .chat-bubble { background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; }
        .chat-input-area { padding: 16px; background: white; border-top: 1px solid #e9ecef; display: flex; gap: 12px; }
        .chat-input { flex: 1; padding: 12px; border: 1px solid #e9ecef; border-radius: 8px; font-size: 14px; }
        .chat-send { background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; }
        
        .typing-indicator { display: none; margin-bottom: 16px; }
        .typing-indicator.active { display: block; }
        .typing-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #95a5a6; margin: 0 2px; animation: typing 1.4s infinite; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typing { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-10px); } }
        
        #toast-container > div { opacity: 1 !important; }
        .toast-success { background-color: #27ae60 !important; }
        .toast-error { background-color: #e74c3c !important; }
        
        @media (max-width: 768px) {
            .navbar-menu { display: none; }
            .chat-window { width: calc(100vw - 48px); height: calc(100vh - 150px); }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">Taakra</a>
            <div class="navbar-menu">
                <a href="{{ route('dashboard') }}" class="navbar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('competitions.index') }}" class="navbar-link {{ request()->routeIs('competitions.index') ? 'active' : '' }}">Competitions</a>
                <a href="{{ route('competitions.my') }}" class="navbar-link {{ request()->routeIs('competitions.my') ? 'active' : '' }}">My Competitions</a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="navbar-link">Admin</a>
                @endif
                <div class="user-menu">
                    <div class="user-avatar" onclick="toggleUserMenu()">{{ substr(auth()->user()->name, 0, 1) }}</div>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <div class="chat-widget">
        <button class="chat-button" onclick="toggleChat()" id="chatButton">
            <i class="fas fa-comments"></i>
        </button>
        <div class="chat-window" id="chatWindow">
            <div class="chat-header">
                <div>
                    <h3>Taakra Support</h3>
                    <small style="opacity: 0.9;">AI Assistant & Live Support</small>
                </div>
                <button class="chat-close" onclick="toggleChat()"><i class="fas fa-times"></i></button>
            </div>
            <div class="chat-messages" id="chatMessages">
                <div class="chat-message bot">
                    <div class="chat-bubble">
                        👋 Hi! I'm your Taakra AI assistant. How can I help you today?
                    </div>
                </div>
            </div>
            <div class="typing-indicator" id="typingIndicator">
                <div class="chat-bubble" style="background: white; padding: 16px;">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            </div>
            <div class="chat-input-area">
                <input type="text" class="chat-input" id="chatInput" placeholder="Type your message..." onkeypress="if(event.key==='Enter') sendMessage()">
                <button class="chat-send" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        function toggleChat() {
            const chatWindow = document.getElementById('chatWindow');
            const chatButton = document.getElementById('chatButton');
            chatWindow.classList.toggle('active');
            chatButton.classList.toggle('active');
        }

        function openChat() {
            document.getElementById('chatWindow').classList.add('active');
            document.getElementById('chatButton').classList.add('active');
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (!message) return;

            addMessage(message, 'user');
            input.value = '';

            document.getElementById('typingIndicator').classList.add('active');

            fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('typingIndicator').classList.remove('active');
                addMessage(data.response, 'bot');
            })
            .catch(() => {
                document.getElementById('typingIndicator').classList.remove('active');
                addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            });
        }

        function addMessage(text, sender) {
            const messagesDiv = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}`;
            messageDiv.innerHTML = `<div class="chat-bubble">${text}</div>`;
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    const socket = io('http://localhost:3000');
    let isConnected = false;

    socket.on('connect', () => {
        console.log('Connected to chat server');
        isConnected = true;
        
        socket.emit('user:join', {
            userId: {{ auth()->id() }},
            userName: "{{ auth()->user()->name }}",
            userEmail: "{{ auth()->user()->email }}",
            role: "{{ auth()->user()->role }}"
        });
    });

    socket.on('connection:success', (data) => {
        console.log(data.message);
    });

    socket.on('message:receive', (message) => {
        addMessage(message.message, message.senderType === 'user' ? 'user' : 'bot');
        document.getElementById('typingIndicator').classList.remove('active');
    });

    socket.on('typing:show', (data) => {
        document.getElementById('typingIndicator').classList.add('active');
    });

    socket.on('typing:hide', (data) => {
        document.getElementById('typingIndicator').classList.remove('active');
    });

    socket.on('message:sent', (message) => {
        console.log('Message sent successfully');
    });

    function sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        if (!message || !isConnected) return;

        addMessage(message, 'user');
        input.value = '';

        socket.emit('message:send', {
            message: message,
            timestamp: new Date().toISOString()
        });
    }

    function addMessage(text, sender) {
        const messagesDiv = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}`;
        messageDiv.innerHTML = `<div class="chat-bubble">${escapeHtml(text)}</div>`;
        messagesDiv.appendChild(messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    let typingTimeout;
    document.getElementById('chatInput')?.addEventListener('input', function() {
        clearTimeout(typingTimeout);
        
        socket.emit('typing:start', {
            targetRoom: 'support'
        });

        typingTimeout = setTimeout(() => {
            socket.emit('typing:stop', {
                targetRoom: 'support'
            });
        }, 1000);
    });
</script>
    @stack('scripts')
</body>
</html>