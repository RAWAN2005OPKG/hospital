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
            --primary: #0066cc;
            --secondary: #00bcd4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --sidebar-width: 280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background: #f4f7fe; color: var(--gray-800); min-height: 100vh; overflow-x: hidden; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: #fff;
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            box-shadow: -5px 0 30px rgba(0,0,0,0.05);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 900;
        }

        .sidebar-brand i {
            width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.2rem;
        }

        .sidebar-nav { list-style: none; padding: 0 1rem; flex: 1; }
        .sidebar-nav li { margin-bottom: 0.5rem; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem;
            color: var(--gray-500); text-decoration: none; border-radius: 12px; font-weight: 600; transition: all 0.3s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(0, 102, 204, 0.08); color: var(--primary);
        }
        .sidebar-nav a i { font-size: 1.1rem; width: 25px; text-align: center; }

        /* Main Content */
        .main-content { margin-right: var(--sidebar-width); padding: 2rem; min-height: 100vh; }

        /* Page Header */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .page-title { font-size: 1.8rem; font-weight: 900; color: var(--gray-900); }
        .page-subtitle { color: var(--gray-500); font-size: 0.95rem; margin-top: 0.25rem; }

        /* Cards */
        .card { background: #fff; border-radius: 20px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .card-title { font-size: 1.2rem; font-weight: 800; color: var(--gray-900); }

        /* Tables */
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: separate; border-spacing: 0 0.75rem; }
        th { padding: 1rem; text-align: right; color: var(--gray-500); font-weight: 700; font-size: 0.9rem; }
        td { padding: 1.25rem 1rem; background: #fff; border-top: 1px solid #f8f9fa; border-bottom: 1px solid #f8f9fa; }
        tr td:first-child { border-right: 1px solid #f8f9fa; border-radius: 0 12px 12px 0; }
        tr td:last-child { border-left: 1px solid #f8f9fa; border-radius: 12px 0 0 12px; }

        /* Form Controls */
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--gray-700); font-size: 0.9rem; }
        .form-control {
            width: 100%; padding: 0.85rem 1.25rem; border: 2px solid var(--gray-100); border-radius: 12px;
            outline: none; transition: all 0.3s; font-size: 0.95rem; background: var(--gray-50);
        }
        .form-control:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1); }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 700; border: none; cursor: pointer;
            transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4); }

        /* Badge */
        .badge { padding: 0.35rem 0.85rem; border-radius: 30px; font-size: 0.75rem; font-weight: 800; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(100%); }
            .main-content { margin-right: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <i class="fa-solid fa-heart-pulse"></i>
            <span>صحتي</span>
        </a>
        
        <ul class="sidebar-nav">
            @php $user = Auth::user(); @endphp
            @if($user->isAdmin())
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> الإحصائيات</a></li>
                <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> المستخدمون</a></li>
                <li><a href="{{ route('admin.doctors') }}" class="{{ request()->routeIs('admin.doctors*') ? 'active' : '' }}"><i class="fa-solid fa-user-doctor"></i> الأطباء</a></li>
                <li><a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check"></i> المواعيد</a></li>
                <li><a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments*') ? 'active' : '' }}"><i class="fa-solid fa-hospital"></i> الأقسام</a></li>
                <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}"><i class="fa-solid fa-gears"></i> الإعدادات</a></li>
            @endif
            <li style="margin-top: auto; padding-bottom: 2rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; background: none; border: none; text-align: right;">
                        <a style="color: var(--danger);"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
