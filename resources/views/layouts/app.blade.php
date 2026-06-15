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
        .navbar { position: fixed; top: 0; left: 0; right: 0; height: 80px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0, 0, 0, 0.05); display: flex; align-items: center; justify-content: space-between; padding: 0 5%; z-index: 1000; transition: all 0.3s ease; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05); }
        .navbar-brand { display: flex; align-items: center; gap: 0.75rem; font-size: 1.35rem; font-weight: 800; background: linear-gradient(135deg, #0077B6, #00B4D8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-decoration: none; }
        .navbar-nav { display: flex !important; flex-direction: row !important; gap: 1.5rem !important; list-style: none !important; align-items: center !important; margin: 0 !important; padding: 0 !important; }
        .navbar-nav a { color: #4b5563; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem; }
        .navbar-nav a.active { color: #0077B6; }
        .navbar-actions { display: flex; gap: 1rem; align-items: center; }
        .btn-white { background: #fff; color: #0077B6; border: 1px solid #e5e7eb; }
        .active-lang { background: #e0f4ff !important; color: #0077B6 !important; border-color: #0077B6 !important; }
        .footer { background: linear-gradient(135deg, #111827, #1f2937); color: #fff; padding: 4rem 0 1rem; margin-top: 5rem; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2.5rem; max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; }
        .footer-grid a { display: block; margin-bottom: 0.75rem; color: rgba(255, 255, 255, 0.7); text-decoration: none; }
        .footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.1); margin-top: 2rem; color: rgba(255, 255, 255, 0.6); }
        main { padding-top: 80px; }
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
            <div>
                <h4>{{ __('messages.sehati') }}</h4>
                <p>{{ __('messages.integrated_medical_platform') }}</p>
            </div>
            <div>
                <h4>{{ __('messages.quick_links') }}</h4>
                <a href="{{ route('home') }}">{{ __('messages.home') }}</a>
                <a href="{{ route('services.index') }}">{{ __('messages.services') }}</a>
            </div>
            <div>
                <h4>{{ __('messages.contact_info') }}</h4>
                <p>{{ __('messages.location') }}</p>
                <p>{{ __('messages.phone') }}</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} {{ __('messages.sehati_full') }} — {{ __('messages.all_rights_reserved') }}
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

