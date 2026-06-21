<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم - صحتي')</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius: 16px;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1 ), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background: var(--bg-body); color: var(--text-main); min-height: 100vh; overflow-x: hidden; line-height: 1.6; }

        .topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border-color);
        }

        .topbar-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--primary);
            font-size: 1.4rem;
            font-weight: 800;
        }

        .topbar-brand i {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .topbar-nav {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
            padding: 0;
        }

        .topbar-nav a {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .topbar-nav a:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .topbar-nav a.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .topbar-logout button {
            background: #fff;
            border: 1px solid var(--danger);
            color: var(--danger);
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .topbar-logout button:hover {
            background: var(--danger);
            color: #fff;
        }

        .main-content {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        .page-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem; 
            flex-wrap: wrap;
            gap: 1rem;
        }
        .page-title { font-size: 2rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.025em; }
        .page-subtitle { color: var(--text-muted); font-size: 1rem; margin-top: 0.25rem; }

        .card { 
            background: var(--bg-card); 
            border-radius: var(--radius); 
            padding: 2rem; 
            box-shadow: var(--shadow); 
            border: 1px solid var(--border-color);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .card-title { font-size: 1.25rem; font-weight: 700; color: var(--text-main); }

        .table-container { 
            overflow-x: auto; 
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }
        table { width: 100%; border-collapse: collapse; }
        th { 
            padding: 1rem 1.5rem; 
            text-align: right; 
            color: var(--text-muted); 
            font-weight: 700; 
            font-size: 0.85rem; 
            background: #f8fafc;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td { 
            padding: 1.25rem 1.5rem; 
            background: #fff; 
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f1f5f9; }

        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.6rem; font-weight: 600; color: var(--text-main); font-size: 0.9rem; }
        .form-control {
            width: 100%; 
            padding: 0.75rem 1rem; 
            border: 1px solid var(--border-color); 
            border-radius: 10px;
            outline: none; 
            transition: all 0.2s; 
            font-size: 1rem; 
            background: #fff;
            color: var(--text-main);
        }
        .form-control:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); 
        }

        .btn {
            padding: 0.75rem 1.5rem; 
            border-radius: 10px; 
            font-weight: 600; 
            border: none; 
            cursor: pointer;
            transition: all 0.2s; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.6rem; 
            text-decoration: none;
            font-size: 0.95rem;
        }
        .btn-primary { 
            background: var(--primary); 
            color: #fff; 
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); 
        }
        .btn-primary:hover { 
            background: #1d4ed8;
            transform: translateY(-1px); 
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); 
        }
        .btn-light { background: var(--primary-light); color: var(--primary); }

        .badge { 
            padding: 0.4rem 0.8rem; 
            border-radius: 8px; 
            font-size: 0.8rem; 
            font-weight: 700; 
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .badge-primary { background: var(--primary-light); color: var(--primary); }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-warning { background: #fef3c7; color: #b45309; }

        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        @media (max-width: 768px) {
            .grid-2 { grid-template-columns: 1fr; }
            .topbar-nav { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
                <i class="fa-solid fa-hospital"></i>
                <span>لوحة التحكم</span>
            </a>

            <nav class="topbar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> {{ __('messages.nav_statistics') }}</a>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> {{ __('messages.nav_users') }}</a>
                <a href="{{ route('admin.doctors') }}" class="{{ request()->routeIs('admin.doctors*') ? 'active' : '' }}"><i class="fa-solid fa-user-md"></i> {{ __('messages.nav_doctors') }}</a>
                <a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-alt"></i> {{ __('messages.appointments') }}</a>
                <a href="{{ route('admin.medicines.index') }}" class="{{ request()->routeIs('admin.medicines*') ? 'active' : '' }}"><i class="fa-solid fa-pills"></i> الأدوية</a>
                <a href="{{ route('admin.contact-messages') }}" class="{{ request()->routeIs('admin.contact-messages*') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i> رسائل التواصل</a>
                <a href="{{ route('admin.departments') }}" class="{{ request()->routeIs('admin.departments*') ? 'active' : '' }}"><i class="fa-solid fa-building"></i> الأقسام</a>
                <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}"><i class="fa-solid fa-cog"></i> {{ __('messages.nav_settings') }}</a>
            </nav>

            <form class="topbar-logout" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fa-solid fa-sign-out-alt"></i> خروج</button>
            </form>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="badge badge-success" style="width: 100%; padding: 1rem; margin-bottom: 1.5rem; border-radius: 12px; font-size: 1rem;">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
