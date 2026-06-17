<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name').' | MediFlow Gaza')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --blue: #0077B6;
            --green: #10b981;
            --purple: #8b5cf6;
            --red: #ef4444;
            --muted: #6b7280;
            --text: #374151;
            --success: #10b981;
            --primary: #0077B6;
            --secondary: #00B4D8;
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
            --bg: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Cairo', 'Poppins', sans-serif;
            background: linear-gradient(165deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%);
            color: #374151;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .navbar.scrolled {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.35rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0077B6, #00B4D8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand i {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0077B6, #00B4D8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 8px 20px rgba(0, 119, 182, 0.28);
        }

        .navbar-nav {
            display: flex !important;
            flex-direction: row !important;
            gap: 1.5rem !important;
            list-style: none !important;
            align-items: center !important;
            margin: 0 !important;
            padding: 0 !important;
            flex-wrap: nowrap !important;
        }

        .navbar-nav li {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            white-space: nowrap !important;
        }

        .navbar-nav a {
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav a:hover,
        .navbar-nav a.active {
            color: #0077B6;
        }

        .navbar-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #0077B6, #00B4D8);
            border-radius: 2px;
        }

        .navbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .btn {
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0077B6, #00B4D8);
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 119, 182, 0.28);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 102, 204, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: #0077B6;
            border: 2px solid #0077B6;
        }

        .btn-outline:hover {
            background: #0077B6;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 119, 182, 0.28);
        }

        .btn-white {
            background: #fff;
            color: #0077B6;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-white:hover {
            background: #f9fafb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-sm {
            padding: 0.45rem 1rem;
            font-size: 0.85rem;
        }

        .active-lang {
            background: #e0f4ff !important;
            color: #0077B6 !important;
            border-color: #0077B6 !important;
        }

        .dropdown-item {
            color: #374151;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
            color: #0077B6;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        main {
            padding-top: 100px;
        }

        /* Container & Spacing */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .section {
            padding: 2rem 0;
        }

        .section-sm {
            padding: 1.25rem 0;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        /* Page Header Styles */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding: 0 1.5rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--gray-900);
        }

        .page-subtitle {
            color: var(--gray-500);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        /* Card Styles */
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--gray-900);
        }

        .card-body {
            padding: 0;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 700;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1.25rem;
            border: 2px solid var(--gray-100);
            border-radius: 12px;
            outline: none;
            transition: all 0.3s;
            font-size: 0.95rem;
            background: var(--gray-50);
            font-family: 'Cairo', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
        }

        th {
            padding: 1rem;
            text-align: right;
            color: var(--gray-500);
            font-weight: 700;
            font-size: 0.9rem;
        }

        td {
            padding: 1.25rem 1rem;
            background: #fff;
            border-top: 1px solid #f8f9fa;
            border-bottom: 1px solid #f8f9fa;
        }

        tr td:first-child {
            border-right: 1px solid #f8f9fa;
            border-radius: 0 12px 12px 0;
        }

        tr td:last-child {
            border-left: 1px solid #f8f9fa;
            border-radius: 12px 0 0 12px;
        }

        /* Badge Styles */
        .badge {
            padding: 0.35rem 0.85rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-block;
        }

        .badge-blue {
            background: rgba(0, 102, 204, 0.1);
            color: #0066cc;
        }

        .badge-cyan {
            background: rgba(0, 188, 212, 0.12);
            color: #0e7490;
        }

        .badge-gray {
            background: rgba(107, 114, 128, 0.12);
            color: #4b5563;
        }

        .badge-yellow {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .badge-green {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .badge-red {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Grid Utilities */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .navbar {
                padding: 0 1rem;
                height: 60px;
            }

            .navbar-nav {
                display: none;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #111827, #1f2937);
            color: #fff;
            padding: 4rem 0 1rem;
            margin-top: 5rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2.5rem;
            margin-bottom: 2rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 1.5rem;
        }

        .footer-grid h4 {
            margin-bottom: 1rem;
            font-size: 1rem;
            font-weight: 700;
        }

        .footer-grid a {
            display: block;
            margin-bottom: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-grid a:hover {
            color: #fff;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        /* Alert Styles */
        .alert {
            padding: 1.2rem 1.5rem;
            border-radius: 12px;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1rem;
            animation: slideIn 0.3s ease;
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-left-color: #10b981;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-left-color: #ef4444;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 1rem;
                height: 60px;
            }

            .navbar-nav {
                display: none;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            main {
                padding-top: 80px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <i class="fa-solid fa-heart-pulse"></i>
            <span>MediFlow Gaza</span>
        </a>
        
        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> الرئيسية</a></li>
            <li><a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.index') ? 'active' : '' }}"><i class="fas fa-concierge-bell"></i> الخدمات</a></li>
            <li><a href="{{ route('departments') }}" class="{{ request()->routeIs('departments') ? 'active' : '' }}"><i class="fas fa-building-medical"></i> الأقسام</a></li>
            <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.index') ? 'active' : '' }}"><i class="fas fa-user-md"></i> الأطباء</a></li>
            @auth
                @if(Auth::user()->isPatient())
                    <li><a href="{{ route('appointments.book') }}" class="{{ request()->routeIs('appointments.book') ? 'active' : '' }}"><i class="fas fa-calendar-plus"></i> حجز موعد</a></li>
                    <li><a href="{{ route('consultations.index') }}" class="{{ request()->routeIs('consultations.index') ? 'active' : '' }}"><i class="fas fa-comments"></i> استشارات</a></li>
                @endif
            @endauth
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-envelope"></i> تواصل معنا</a></li>
        </ul>
        
        <div class="navbar-actions">
            <a href="{{ route('locale.switch', 'ar') }}" class="btn btn-white btn-sm px-3 {{ app()->getLocale() === 'ar' ? 'active-lang' : '' }}">عربي</a>
            <a href="{{ route('locale.switch', 'en') }}" class="btn btn-white btn-sm px-3 {{ app()->getLocale() === 'en' ? 'active-lang' : '' }}">EN</a>
            @auth
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="ms-1">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu shadow-lg border-0 rounded-3xl p-2 mt-2" aria-labelledby="userDropdown" style="min-width: 240px;">
                        <li class="px-3 py-2 border-bottom mb-2">
                            <p class="text-xs text-gray-400 mb-0">مرحباً بك</p>
                            <p class="font-bold text-gray-800 mb-0">{{ Auth::user()->name }}</p>
                        </li>
                        @if(Auth::user()->isPatient())
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('patient.dashboard') }}"><i class="fas fa-th-large text-blue-500"></i> لوحة المريض</a></li>
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('patient.appointments') }}"><i class="fas fa-calendar-check text-emerald-500"></i> مواعيدي</a></li>
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('patient.medical_records_list') }}"><i class="fas fa-file-medical text-purple-500"></i> السجلات الطبية</a></li>
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('patient.prescriptions_list') }}"><i class="fas fa-pills text-orange-500"></i> الوصفات الطبية</a></li>
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('patient.ai.symptoms') }}"><i class="fas fa-robot text-indigo-500"></i> AI — توجيه الأعراض</a></li>
                        @elseif(Auth::user()->isDoctor())
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('doctor.dashboard') }}"><i class="fas fa-chart-line text-blue-500"></i> لوحة الطبيب</a></li>
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('doctor.appointments') }}"><i class="fas fa-calendar-alt text-emerald-500"></i> المواعيد</a></li>
                        @elseif(Auth::user()->isStaff())
                            <li><a class="dropdown-item rounded-xl py-2" href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield text-red-500"></i> {{ app()->getLocale() === 'ar' ? 'لوحة الإدارة' : 'Admin dashboard' }}</a></li>
                        @endif
                        <li><a class="dropdown-item rounded-xl py-2" href="{{ route('profile.show') }}"><i class="fas fa-user-circle text-gray-500"></i> الملف الشخصي</a></li>
                        <li><hr class="dropdown-divider mx-2"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-xl py-2 text-red-600 font-bold w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container section">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div>
                <h4>عن المستشفى</h4>
                <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem;">مستشفى صحتي - نقدم أفضل الخدمات الطبية بأحدث التقنيات</p>
            </div>
            <div>
                <h4>الخدمات</h4>
                <a href="#">الاستشارات الطبية</a>
                <a href="#">الفحوصات</a>
                <a href="#">الجراحات</a>
            </div>
            <div>
                <h4>روابط سريعة</h4>
                <a href="#">الرئيسية</a>
                <a href="#">الأطباء</a>
                <a href="#">المواعيد</a>
            </div>
            <div>
                <h4>تواصل معنا</h4>
                <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem;">البريد: info@sehhaty.com</p>
                <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem;">الهاتف: +970 590000000</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 مستشفى صحتي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
