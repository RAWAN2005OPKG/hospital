<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم - صحتي')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Cairo', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f7ff 0%, #f5f7fa 100% );
            color: var(--gray-700);
            line-height: 1.6;
            min-height: 100vh;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--gray-900), var(--gray-800));
            color: #fff;
            padding: 2rem 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 999;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0 1.5rem;
            margin-bottom: 2rem;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
        }

        .sidebar-brand i {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin: 0.5rem 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(0, 102, 204, 0.2);
            color: #fff;
            border-right: 3px solid var(--primary);
        }

        .sidebar-nav i {
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .topbar-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .topbar-actions {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .topbar-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--gray-100);
            border: none;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .topbar-action-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--gray-900);
        }

        .page-subtitle {
            color: var(--gray-500);
            font-size: 0.95rem;
        }

        /* Card */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card-icon.primary {
            background: rgba(0, 102, 204, 0.1);
            color: var(--primary);
        }

        .stat-card-icon.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-card-icon.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .stat-card-icon.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 900;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .stat-card-label {
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        .stat-card-change {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .stat-card-change.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-card-change.negative {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .topbar {
                padding: 0 1rem;
            }

            .content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ route('home') }}" class="sidebar-brand">
                <i class="fa-solid fa-heart-pulse"></i>
                <span>صحتي</span>
            </a>
            
            <ul class="sidebar-nav">
                @if(Auth::user()->isPatient())
                    <li><a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> لوحتي</a></li>
                    <li><a href="{{ route('patient.appointments') }}" class="{{ request()->routeIs('patient.appointments') ? 'active' : '' }}"><i class="fa-solid fa-calendar"></i> مواعيدي</a></li>
                    <li><a href="{{ route('appointments.create') }}" class="{{ request()->routeIs('appointments.create') ? 'active' : '' }}"><i class="fa-solid fa-calendar-plus"></i> حجز موعد</a></li>
                    <li><a href="{{ route('patient.medical-records') }}" class="{{ request()->routeIs('patient.medical-records') ? 'active' : '' }}"><i class="fa-solid fa-file-medical"></i> السجلات الطبية</a></li>
                    {{-- prescriptions & chats routes may not be implemented yet --}}
                    {{-- <li><a href="{{ route('patient.prescriptions') }}" class="{{ request()->routeIs('patient.prescriptions') ? 'active' : '' }}"><i class="fa-solid fa-prescription-bottle"></i> الوصفات</a></li> --}}
                    {{-- <li><a href="{{ route('chats.index') }}" class="{{ request()->routeIs('chats.index') ? 'active' : '' }}"><i class="fa-solid fa-comments"></i> المحادثات</a></li> --}}

                    <li><a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}"><i class="fa-solid fa-user"></i> الملف الشخصي</a></li>
                @elseif(Auth::user()->isDoctor())
                    <li><a href="{{ route('doctor.dashboard') }}" class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> لوحتي</a></li>
                    <li><a href="{{ route('doctor.appointments') }}" class="{{ request()->routeIs('doctor.appointments') ? 'active' : '' }}"><i class="fa-solid fa-calendar"></i> المواعيد</a></li>
                    <li><a href="{{ route('doctor.patient-records') }}" class="{{ request()->routeIs('doctor.patient-records') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> المرضى</a></li>
                    {{-- prescriptions & chats routes may not be implemented yet --}}
                    {{-- <li><a href="{{ route('doctor.prescriptions') }}" class="{{ request()->routeIs('doctor.prescriptions') ? 'active' : '' }}"><i class="fa-solid fa-prescription-bottle"></i> الوصفات</a></li> --}}
                    <li><a href="{{ route('doctor.schedule') }}" class="{{ request()->routeIs('doctor.schedule') ? 'active' : '' }}"><i class="fa-solid fa-clock"></i> الجدول الزمني</a></li>
                    {{-- <li><a href="{{ route('chats.index') }}" class="{{ request()->routeIs('chats.index') ? 'active' : '' }}"><i class="fa-solid fa-comments"></i> المحادثات</a></li> --}}

                    <li><a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}"><i class="fa-solid fa-user"></i> الملف الشخصي</a></li>
                @elseif(Auth::user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> لوحة التحكم</a></li>
                    <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> المستخدمون</a></li>
                    <li><a href="{{ route('admin.doctors') }}" class="{{ request()->routeIs('admin.doctors') ? 'active' : '' }}"><i class="fa-solid fa-user-doctor"></i> الأطباء</a></li>
                    <li><a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments') ? 'active' : '' }}"><i class="fa-solid fa-calendar"></i> المواعيد</a></li>
                    <li><a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.index') ? 'active' : '' }}"><i class="fa-solid fa-hospital"></i> الأقسام</a></li>
                    <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> الإعدادات</a></li>
                @endif
            </ul>
        </aside>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <div class="topbar-title">@yield('page-title', 'لوحة التحكم')</div>
                <div class="topbar-actions">
                    <button class="topbar-action-btn" id="notificationBtn">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="dropdown">
                        <button class="topbar-action-btn" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">الملف الشخصي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.0/apexcharts.min.js"></script>
    
    @stack('scripts' )
</body>
</html>