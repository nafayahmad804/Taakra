<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Taakra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f4f8; }
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #87CEEB 0%, #4A90E2 100%); color: white; position: fixed; height: 100vh; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo { font-size: 26px; font-weight: 700; color: white; text-decoration: none; }
        .sidebar-menu { padding: 20px 0; }
        .menu-item { padding: 14px 20px; color: rgba(255,255,255,0.9); text-decoration: none; display: flex; align-items: center; transition: all 0.3s; border-left: 3px solid transparent; }
        .menu-item:hover, .menu-item.active { background: rgba(255,255,255,0.15); border-left-color: white; color: white; }
        .menu-item i { width: 24px; margin-right: 12px; font-size: 16px; }
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        .top-bar { background: white; padding: 20px 30px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .page-title { font-size: 28px; font-weight: 700; color: #2c3e50; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: #87CEEB; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .content-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .btn-primary { background: #4A90E2; color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; }
        .btn-primary:hover { background: #357ABD; transform: translateY(-2px); }
        .btn-success { background: #27ae60; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; }
        .btn-danger { background: #e74c3c; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; }
        .btn-warning { background: #f39c12; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { background: #f8f9fa; padding: 12px; text-align: left; font-weight: 600; color: #495057; border-bottom: 2px solid #dee2e6; }
        .table td { padding: 12px; border-bottom: 1px solid #dee2e6; }
        .table tr:hover { background: #f8f9fa; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #495057; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; }
        .form-control:focus { outline: none; border-color: #4A90E2; box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }
        textarea.form-control { min-height: 120px; resize: vertical; }
        #toast-container > div { opacity: 1 !important; }
        .toast-success { background-color: #27ae60 !important; }
        .toast-error { background-color: #e74c3c !important; }
        .toast-info { background-color: #4A90E2 !important; }
        .toast-warning { background-color: #f39c12 !important; }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">Taakra Admin</a>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i> Categories
                </a>
                <a href="{{ route('admin.competitions.index') }}" class="menu-item {{ request()->routeIs('admin.competitions.*') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i> Competitions
                </a>
                <a href="{{ route('admin.registrations.index') }}" class="menu-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> Registrations
                </a>
                <a href="{{ route('admin.support.index') }}" class="menu-item {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                    <i class="fas fa-headset"></i> Support Team
                </a>
                {{-- <a href="{{ route('dashboard') }}" class="menu-item">
                    <i class="fas fa-home"></i> User Dashboard
                </a> --}}
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
                <div class="user-profile">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
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

        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>
</html>