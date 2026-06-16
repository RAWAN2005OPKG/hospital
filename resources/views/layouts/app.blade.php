<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name').' | MediFlow Gaza')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { font-family: 'Cairo', 'Poppins', sans-serif; background: linear-gradient(165deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100% ); color: #374151; line-height: 1.6; min-height: 100vh; }
        
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
        }
        
        .navbar-nav { 
            display: flex !important; 
            flex-direction: row !important; 
            gap: 1.5rem !important; 
            list-style: none !important; 
            align-items: center !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }
        
        .navbar-nav a { 
            color: #4b5563; 
            text-decoration: none; 
            font-weight: 500; 
            font-size: 0.95rem; 
            transition: all 0.3s ease; 
            display: flex; 
            align-items: center; 
            gap: 0.5rem; 
            position: relative;
        }
        
        .navbar-nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0077B6, #00B4D8);
            transition: width 0.3s ease;
        }
        
        .navbar-nav a:hover::after,
        .navbar-nav a.active::after {
            width: 100%;
        }
        
        .navbar-nav a.active { color: #0077B6; }
        .navbar-actions { display: flex; gap: 1rem; align-items: center; }
        .btn-white { background: #fff; color: #0077B6; border: 1px solid #e5e7eb; }
        .active-lang { background: #e0f4ff !important; color: #0077B6 !important; border-color: #0077B6 !important; }
        
        /* Footer Styles */
        .footer { 
            background: linear-gradient(135deg, #111827, #1f2937); 
            color: #fff; 
            padding: 5rem 0 2rem; 
            margin-top: 5rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        .footer-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 3rem; 
            max-width: 1400px; 
            margin: 0 auto; 
            padding: 0 1.5rem;
        }

        .footer-section h4 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #00B4D8, #0077B6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-section p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .footer-grid a { 
            display: block; 
            margin-bottom: 0.75rem; 
            color: rgba(255, 255, 255, 0.7); 
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .footer-grid a:hover {
            color: #00B4D8;
            padding-left: 0.5rem;
        }

        .footer-contact {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-contact i {
            color: #00B4D8;
            width: 20px;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(0, 180, 216, 0.1);
            border-radius: 50%;
            color: #00B4D8;
            transition: all 0.3s ease;
            margin-bottom: 0;
        }

        .footer-social a:hover {
            background: #00B4D8;
            color: #111827;
            transform: translateY(-3px);
            padding-left: 0;
        }

        .footer-bottom { 
            text-align: center; 
            padding-top: 2.5rem; 
            border-top: 1px solid rgba(255, 255, 255, 0.1); 
            margin-top: 3rem; 
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .footer-bottom a {
            color: #00B4D8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-bottom a:hover {
            color: #0077B6;
        }

        main { padding-top: 80px; }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 3%;
            }
            
            .navbar-nav {
                gap: 1rem !important;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar" id="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <i class="fa-solid fa-heart-pulse"></i>
            <span>{{ __('messages.sehati') }}</span>
        </a>
        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> {{ __('messages.home') }}</a></li>
            <li><a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.index') ? 'active' : '' }}"><i class="fas fa-concierge-bell"></i> {{ __('messages.services') }}</a></li>
            <li><a href="{{ route('departments') }}" class="{{ request()->routeIs('departments') ? 'active' : '' }}"><i class="fas fa-building-medical"></i> {{ __('messages.departments') }}</a></li>
            <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.index') ? 'active' : '' }}"><i class="fas fa-user-md"></i> {{ __('messages.doctors') }}</a></li>
            @auth
                @if(Auth::user()->isPatient())
                    <li><a href="{{ route('appointments.book') }}" class="{{ request()->routeIs('appointments.book') ? 'active' : '' }}"><i class="fas fa-calendar-plus"></i> {{ __('messages.book_appointment') }}</a></li>
                @endif
            @endauth
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-envelope"></i> {{ __('messages.contact_us') }}</a></li>
        </ul>
        <div class="navbar-actions">
            <a href="{{ route('locale.switch', 'ar') }}" class="btn btn-white btn-sm px-3 {{ app()->getLocale() === 'ar' ? 'active-lang' : '' }}">العربية</a>
            <a href="{{ route('locale.switch', 'en') }}" class="btn btn-white btn-sm px-3 {{ app()->getLocale() === 'en' ? 'active-lang' : '' }}">English</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">{{ __('messages.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">{{ __('messages.login') }}</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-section">
                <h4>{{ __('messages.sehati') }}</h4>
                <p>{{ __('messages.integrated_medical_platform') }}</p>
                <div class="footer-social">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h4>{{ __('messages.quick_links') }}</h4>
                <a href="{{ route('home') }}"><i class="fas fa-chevron-left"></i> {{ __('messages.home') }}</a>
                <a href="{{ route('services.index') }}"><i class="fas fa-chevron-left"></i> {{ __('messages.services') }}</a>
                <a href="{{ route('departments') }}"><i class="fas fa-chevron-left"></i> {{ __('messages.departments') }}</a>
                <a href="{{ route('doctors.index') }}"><i class="fas fa-chevron-left"></i> {{ __('messages.doctors') }}</a>
            </div>
            <div class="footer-section">
                <h4>{{ __('messages.contact_info') }}</h4>
                <div class="footer-contact">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ __('messages.location') }}</span>
                </div>
                <div class="footer-contact">
                    <i class="fas fa-phone"></i>
                    <span>{{ __('messages.phone') }}</span>
                </div>
                <div class="footer-contact">
                    <i class="fas fa-envelope"></i>
                    <span>{{ __('messages.email') }}</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ __('messages.sehati_full') }} — {{ __('messages.all_rights_reserved') }} | <a href="#">{{ __('messages.privacy_policy') }}</a> | <a href="#">{{ __('messages.terms_of_service') }}</a></p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
