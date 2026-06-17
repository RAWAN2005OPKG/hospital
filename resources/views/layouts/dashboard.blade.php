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
            --blue: #0066cc;
            --green: #10b981;
            --purple: #8b5cf6;
            --red: #ef4444;
            --muted: #6b7280;
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background: #f4f7fe; color: var(--gray-800); min-height: 100vh; overflow-x: hidden; }

        /* Top Navbar */
        .topbar {
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        }

        .topbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--primary);
            font-size: 1.35rem;
            font-weight: 900;
        }

        .topbar-brand i {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }

        .topbar-nav {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            margin: 0;
            padding: 0;
        }

        .topbar-nav a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 0.95rem;
            border-radius: 10px;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .topbar-nav a:hover,
        .topbar-nav a.active {
            background: rgba(0, 102, 204, 0.08);
            color: var(--primary);
        }

        .topbar-nav a i { font-size: 0.95rem; }

        .topbar-logout button {
            background: none;
            border: none;
            color: var(--danger);
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 0.95rem;
            border-radius: 10px;
        }

        .topbar-logout button:hover {
            background: rgba(239, 68, 68, 0.08);
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            min-height: calc(100vh - 82px);
        }

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

        /* Compatibility styles for admin pages using app-like classes */
        .container { max-width: 1400px; margin: 0 auto; padding: 0 1rem; }
        .section { padding: 1.25rem 0; }
        .mb-8 { margin-bottom: 2rem; }
        .card-body { padding: 1rem 0 0; }
        .table-responsive { overflow-x: auto; }
        .table { width: 100%; border-collapse: separate; border-spacing: 0 0.75rem; }
        .table th { padding: 1rem; text-align: right; color: var(--gray-500); font-weight: 700; font-size: 0.9rem; }
        .table td { padding: 1.25rem 1rem; background: #fff; border-top: 1px solid #f8f9fa; border-bottom: 1px solid #f8f9fa; }
        .table tr td:first-child { border-right: 1px solid #f8f9fa; border-radius: 0 12px 12px 0; }
        .table tr td:last-child { border-left: 1px solid #f8f9fa; border-radius: 12px 0 0 12px; }
        .badge-blue { background: rgba(0, 102, 204, 0.1); color: #0066cc; }
        .badge-cyan { background: rgba(0, 188, 212, 0.12); color: #0e7490; }
        .badge-gray { background: rgba(107, 114, 128, 0.12); color: #4b5563; }

        @media (max-width: 992px) {
            .topbar-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .topbar-nav {
                flex-wrap: wrap;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
                <i class="fa-solid fa-heart-pulse"></i>
                <span>صحتي - لوحة الإدارة</span>
            </a>

            <ul class="topbar-nav">
                @php $user = Auth::user(); @endphp
                @if($user && ($user->isAdmin() || $user->isStaff()))
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> الإحصائيات</a></li>
                    <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> المستخدمون</a></li>
                    <li><a href="{{ route('admin.doctors') }}" class="{{ request()->routeIs('admin.doctors*') ? 'active' : '' }}"><i class="fa-solid fa-user-doctor"></i> الأطباء</a></li>
                    <li><a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check"></i> المواعيد</a></li>
                    <li><a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments*') ? 'active' : '' }}"><i class="fa-solid fa-hospital"></i> الأقسام</a></li>
                    <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}"><i class="fa-solid fa-gears"></i> الإعدادات</a></li>
                @endif
            </ul>

            <form class="topbar-logout" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</button>
            </form>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
