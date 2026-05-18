<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صحتي | Sehati - منصة صحية متكاملة')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0066cc;
            --primary-light: #e0f2f7;
            --primary-dark: #004a99;
            --secondary: #00bcd4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
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
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05 );
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Cairo', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f7ff 0%, #f5f7fa 100%);
            color: var(--gray-700);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Glassmorphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        .glass-dark {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 1000;
            transition: all 0.3s ease;
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
            background: linear-gradient(135deg, var(--primary), var(--secondary));
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
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        .navbar-nav {
            display: flex;
            gap: 2.5rem;
            list-style: none;
            align-items: center;
        }

        .navbar-nav a {
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav a:hover,
        .navbar-nav a.active {
            color: var(--primary);
        }

        .navbar-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .navbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Buttons */
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
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 102, 204, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        .btn-sm {
            padding: 0.45rem 1rem;
            font-size: 0.85rem;
        }

        .btn-white {
            background: #fff;
            color: var(--primary);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .btn-white:hover {
            background: var(--gray-50);
            box-shadow: var(--shadow-md);
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Section */
        .section {
            padding: 5rem 0;
        }

        .section-head {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-head .sec-tag {
            display: inline-block;
            background: linear-gradient(135deg, rgba(0, 102, 204, 0.1), rgba(0, 188, 212, 0.1));
            color: var(--primary);
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
            border: 1px solid rgba(0, 102, 204, 0.2);
        }

        .section-head h2 {
            font-size: 2.8rem;
            font-weight: 900;
            margin-bottom: 1rem;
            color: var(--gray-900);
            line-height: 1.2;
        }

        .section-head p {
            font-size: 1.15rem;
            color: var(--gray-500);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Card */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .card.glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        /* Alert */
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
            border-left-color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-left-color: var(--danger);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border-left-color: var(--warning);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            color: #1e40af;
            border-left-color: var(--info);
        }

        .alert i {
            font-size: 1.2rem;
            flex-shrink: 0;
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

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--gray-900), var(--gray-800));
            color: #fff;
            padding: 4rem 0 1rem;
            margin-top: 5rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2.5rem;
            margin-bottom: 2rem;
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

            .section-head h2 {
                font-size: 2rem;
            }

            .section {
                padding: 3rem 0;
            }

            .card {
                padding: 1.5rem;
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
            <span>صحتي</span>
        </a>
        
        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a></li>
            <li><a href="{{ route('departments') }}" class="{{ request()->routeIs('departments') ? 'active' : '' }}">الأقسام</a></li>
            <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.index') ? 'active' : '' }}">الأطباء</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">تواصل معنا</a></li>
        </ul>
        
        <div class="navbar-actions">
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline btn-sm" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user"></i>
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if(Auth::user()->isPatient())
                            <li><a class="dropdown-item" href="{{ route('patient.dashboard') }}">لوحة المريض</a></li>
                            <li><a class="dropdown-item" href="{{ route('patient.appointments') }}">مواعيدي</a></li>
                        @elseif(Auth::user()->isDoctor())
                            <li><a class="dropdown-item" href="{{ route('doctor.dashboard') }}">لوحة الطبيب</a></li>
                            <li><a class="dropdown-item" href="{{ route('doctor.appointments') }}">المواعيد</a></li>
                        @elseif(Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">لوحة الإدارة</a></li>
                        @endif
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
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">دخول</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">تسجيل</a>
            @endauth
        </div>
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div style="position:fixed;top:80px;right:1.5rem;z-index:800;max-width:400px;animation:slideIn 0.3s ease">
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div style="position:fixed;top:80px;right:1.5rem;z-index:800;max-width:400px;animation:slideIn 0.3s ease">
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-xmark"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    <!-- Main Content -->
    <main style="padding-top: 70px;">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem">
                        <div style="width:45px;height:45px;border-radius:12px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;box-shadow:0 8px 20px rgba(0, 102, 204, 0.3)">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <span style="color:#fff;font-size:1.2rem;font-family:'Poppins',sans-serif;font-weight:800;background:linear-gradient(135deg,#fff,rgba(255,255,255,0.8));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">صحتي</span>
                    </div>
                    <p style="font-size:.9rem;line-height:1.9;color:rgba(255,255,255,0.7)">منصة طبية متكاملة توفر أعلى معايير الرعاية الصحية بأيدي نخبة من الأطباء المتخصصين.</p>
                </div>
                <div>
                    <h4>روابط سريعة</h4>
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('departments') }}">الأقسام</a>
                    <a href="{{ route('doctors.index') }}">الأطباء</a>
                    <a href="{{ route('about') }}">عن المنصة</a>
                </div>
                <div>
                    <h4>الخدمات</h4>
                    <a href="#">حجز المواعيد</a>
                    <a href="#">استشارات طبية</a>
                    <a href="#">السجلات الطبية</a>
                    <a href="#">الوصفات الطبية</a>
                </div>
                <div>
                    <h4>تواصل معنا</h4>
                    <div style="display:flex;gap:.5rem;margin-bottom:.75rem;font-size:.9rem;align-items:flex-start">
                        <i class="fa-solid fa-location-dot" style="color:var(--secondary);margin-top:.25rem;flex-shrink:0"></i>
                        <span>غزة - فلسطين</span>
                    </div>
                    <div style="display:flex;gap:.5rem;margin-bottom:.75rem;font-size:.9rem;align-items:center">
                        <i class="fa-solid fa-phone" style="color:var(--secondary)"></i>
                        <span>+970-8-2345678</span>
                    </div>
                    <div style="display:flex;gap:.5rem;font-size:.9rem;align-items:center">
                        <i class="fa-solid fa-envelope" style="color:var(--secondary)"></i>
                        <span>info@sehati.ps</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">© {{ date('Y') }} صحتي | Sehati — جميع الحقوق محفوظة</div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.0/apexcharts.min.js"></script>
    
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar' );
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });
        
        // Auto-dismiss alerts after 5s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(a => {
                a.style.transition = 'opacity .5s';
                a.style.opacity = '0';
                setTimeout(() => a.parentElement?.remove(), 500);
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>