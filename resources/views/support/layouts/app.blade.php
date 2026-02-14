<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Support Dashboard') - Taakra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f4f8; }
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #27ae60 0%, #229954 100%); color: white; position: fixed; height: 100vh; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo { font-size: 26px; font-weight: 700; color: white; text-decoration: none; }
        .sidebar-menu { padding: 20px 0; }
        .menu-item { padding: 14px 20px; color: rgba(255,255,255,0.9); text-decoration: none; display: flex; align-items: center; transition: all 0.3s; border-left: 3px solid transparent; }
        .menu-item:hover, .menu-item.active { background: rgba(255,255,255,0.15); border-left-color: white; color: white; }
        .menu-item i { width: 24px; margin-right: 12px; font-size: 16px; }
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        .top-bar { background: white; padding: 20px 30px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .page-title { font-size: 28px; font-weight: 700; color: #2c3e50; }
        .btn-primary { background: #4A90E2; color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-weight: 600; }
        .btn-primary:hover { background: #357ABD; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('support.dashboard') }}" class="sidebar-logo">Taakra Support</a>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('support.dashboard') }}" class="menu-item {{ request()->routeIs('support.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('support.chats.index') }}" class="menu-item {{ request()->routeIs('support.chats.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i> Live Chats
                </a>
                <a href="{{ route('dashboard') }}" class="menu-item">
                    <i class="fas fa-home"></i> User Dashboard
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <i class="fas fa-crown"></i> Admin Panel
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="menu-item" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #27ae60; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if(session('error')) toastr.error("{{ session('error') }}"); @endif
    </script>
</body>
</html>