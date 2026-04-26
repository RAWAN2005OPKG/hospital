<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ProHealth') — مستشفى صحتي</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --blue:      #2563EB;
            --blue-dk:   #1d4ed8;
            --blue-lt:   #EFF6FF;
            --cyan:      #06b6d4;
            --cyan-lt:   #ecfeff;
            --white:     #ffffff;
            --bg:        #f0f7ff;
            --text:      #0f172a;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --card:      #ffffff;
            --radius:    14px;
            --shadow:    0 4px 24px rgba(37,99,235,.08);
            --shadow-lg: 0 12px 40px rgba(37,99,235,.15);
            --nav-h:     72px;
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body { font-family:'Tajawal',sans-serif; color:var(--text); background:var(--bg); line-height:1.7; }
        a { text-decoration:none; color:inherit; }
        img { max-width:100%; }

        /* ══ NAVBAR ══ */
        .navbar {
            position:fixed; top:0; right:0; left:0; z-index:900;
            height:var(--nav-h);
            background:rgba(255,255,255,.92);
            backdrop-filter:blur(16px);
            border-bottom:1px solid rgba(37,99,235,.08);
            transition:box-shadow .3s, background .3s;
        }
        .navbar.scrolled {
            box-shadow:0 4px 32px rgba(37,99,235,.12);
            background:#fff;
        }
        .nav-inner {
            max-width:1200px; margin:0 auto; padding:0 1.5rem;
            height:100%; display:flex; align-items:center; gap:2rem;
        }
        .nav-logo {
            display:flex; align-items:center; gap:.6rem;
            font-family:'Poppins',sans-serif; font-weight:700;
            font-size:1.3rem; color:var(--blue); flex-shrink:0;
        }
        .nav-logo .logo-icon {
            width:38px; height:38px; border-radius:10px;
            background:linear-gradient(135deg,var(--blue),var(--cyan));
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:1rem;
        }
        .nav-links { display:flex; align-items:center; gap:.2rem; flex:1; list-style:none; }
        .nav-links a {
            padding:.5rem .9rem; border-radius:8px;
            font-size:.9rem; font-weight:500; color:var(--muted);
            transition:all .2s; position:relative;
        }
        .nav-links a:hover, .nav-links a.active {
            color:var(--blue); background:var(--blue-lt);
        }
        .nav-actions { display:flex; gap:.75rem; margin-right:auto; }

        /* ══ FLOATING AUTH BUTTONS ══ */
        .float-auth {
            position:fixed;
            left:20px; bottom:30px;
            z-index:1000;
            display:flex; flex-direction:column; gap:.6rem;
            transition:transform .4s cubic-bezier(.34,1.56,.64,1);
        }
        .float-auth.hide { transform:translateX(-90px); }
        .float-btn {
            display:flex; align-items:center; gap:.6rem;
            padding:.7rem 1.2rem;
            border-radius:50px;
            font-family:'Tajawal',sans-serif; font-size:.88rem; font-weight:700;
            cursor:pointer; border:none;
            box-shadow:0 4px 20px rgba(0,0,0,.15);
            transition:all .3s cubic-bezier(.34,1.56,.64,1);
            white-space:nowrap;
        }
        .float-btn:hover { transform:scale(1.06) translateX(4px); box-shadow:0 8px 28px rgba(0,0,0,.2); }
        .float-btn-login { background:var(--blue); color:#fff; }
        .float-btn-register { background:#fff; color:var(--blue); border:2px solid var(--blue); }
        .float-toggle {
            position:fixed; left:20px; bottom:30px; z-index:1001;
            width:44px; height:44px; border-radius:50%;
            background:var(--blue); color:#fff; border:none;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; box-shadow:0 4px 20px rgba(37,99,235,.4);
            font-size:1rem; transition:all .3s;
            display:none;
        }

        /* ══ BUTTONS ══ */
        .btn {
            display:inline-flex; align-items:center; gap:.45rem;
            padding:.6rem 1.4rem; border-radius:50px;
            font-family:'Tajawal',sans-serif; font-weight:700; font-size:.9rem;
            cursor:pointer; border:none; transition:all .25s;
        }
        .btn-primary { background:linear-gradient(135deg,var(--blue),var(--cyan)); color:#fff; box-shadow:0 4px 16px rgba(37,99,235,.3); }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,99,235,.4); }
        .btn-outline { background:transparent; border:2px solid var(--blue); color:var(--blue); }
        .btn-outline:hover { background:var(--blue-lt); }
        .btn-white { background:#fff; color:var(--blue); box-shadow:0 4px 16px rgba(0,0,0,.1); }
        .btn-white:hover { transform:translateY(-2px); }
        .btn-sm { padding:.4rem 1rem; font-size:.82rem; }
        .btn-danger { background:#ef4444; color:#fff; }
        .btn-success { background:#10b981; color:#fff; }

        /* ══ CONTAINER ══ */
        .container { max-width:1200px; margin:0 auto; padding:0 1.5rem; }
        .section { padding:5rem 0; }
        .section-sm { padding:3rem 0; }

        /* ══ PAGE HEADER ══ */
        .page-header {
            background:linear-gradient(135deg,var(--blue) 0%,var(--cyan) 100%);
            padding:5rem 0 3rem; margin-top:var(--nav-h);
            color:#fff; text-align:center; position:relative; overflow:hidden;
        }
        .page-header::before {
            content:''; position:absolute; inset:0;
            background:url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='20' fill='none' stroke='white' stroke-width='.5' opacity='.1'/%3E%3C/svg%3E");
        }
        .page-header h1 { font-size:2.2rem; font-weight:900; position:relative; }
        .page-header p { opacity:.9; margin-top:.5rem; position:relative; }
        .breadcrumb { display:flex; align-items:center; justify-content:center; gap:.5rem; font-size:.85rem; opacity:.8; margin-top:.75rem; position:relative; }
        .breadcrumb a:hover { opacity:1; }

        /* ══ CARD ══ */
        .card {
            background:var(--card); border:1px solid var(--border);
            border-radius:var(--radius); box-shadow:var(--shadow); overflow:hidden;
        }
        .card-body { padding:1.5rem; }
        .card-header {
            padding:1.1rem 1.5rem; border-bottom:1px solid var(--border);
            font-weight:700; display:flex; align-items:center; justify-content:space-between;
        }

        /* ══ BADGE ══ */
        .badge { display:inline-flex; align-items:center; gap:.3rem; padding:.22rem .7rem; border-radius:20px; font-size:.76rem; font-weight:700; }
        .badge-blue     { background:#dbeafe; color:#1d4ed8; }
        .badge-green    { background:#d1fae5; color:#059669; }
        .badge-red      { background:#fee2e2; color:#dc2626; }
        .badge-yellow   { background:#fef3c7; color:#d97706; }
        .badge-gray     { background:#f1f5f9; color:#64748b; }
        .badge-cyan     { background:#cffafe; color:#0891b2; }

        /* ══ ALERT ══ */
        .alert { padding:1rem 1.25rem; border-radius:var(--radius); border-right:4px solid; margin-bottom:1rem; display:flex; align-items:flex-start; gap:.75rem; }
        .alert-success { background:#f0fdf4; border-color:#10b981; color:#065f46; }
        .alert-danger  { background:#fef2f2; border-color:#ef4444; color:#7f1d1d; }
        .alert-info    { background:var(--blue-lt); border-color:var(--blue); color:#1e3a8a; }

        /* ══ FORM ══ */
        .form-group { margin-bottom:1.25rem; }
        .form-label { display:block; font-weight:700; font-size:.88rem; margin-bottom:.4rem; }
        .form-control {
            width:100%; padding:.72rem 1rem;
            border:2px solid var(--border); border-radius:10px;
            font-family:'Tajawal',sans-serif; font-size:.9rem; color:var(--text);
            background:#fff; transition:all .2s;
        }
        .form-control:focus { outline:none; border-color:var(--blue); box-shadow:0 0 0 4px rgba(37,99,235,.1); }
        .form-control.is-invalid { border-color:#ef4444; }
        .invalid-feedback { color:#ef4444; font-size:.8rem; margin-top:.25rem; }
        textarea.form-control { resize:vertical; min-height:120px; }
        select.form-control { cursor:pointer; }

        /* ══ TABLE ══ */
        .table-responsive { overflow-x:auto; }
        .table { width:100%; border-collapse:collapse; font-size:.9rem; }
        .table th, .table td { padding:.85rem 1.1rem; border-bottom:1px solid var(--border); text-align:right; }
        .table th { background:#f8fafc; font-weight:700; color:var(--muted); font-size:.78rem; text-transform:uppercase; letter-spacing:.04em; }
        .table tbody tr:hover { background:#f8fafc; }

        /* ══ GRID ══ */
        .grid-2 { display:grid; grid-template-columns:repeat(2,1fr); gap:1.5rem; }
        .grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; }
        .grid-4 { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }

        /* ══ DOCTOR CARD ══ */
        .doc-card {
            background:#fff; border:1px solid var(--border); border-radius:var(--radius);
            overflow:hidden; transition:all .3s cubic-bezier(.34,1.56,.64,1);
            cursor:pointer;
        }
        .doc-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-lg); border-color:var(--blue); }
        .doc-card-img {
            height:200px; background:linear-gradient(135deg,var(--blue-lt),var(--cyan-lt));
            display:flex; align-items:center; justify-content:center;
            font-size:4.5rem; color:var(--blue); overflow:hidden; position:relative;
        }
        .doc-card-img img { width:100%; height:100%; object-fit:cover; }
        .doc-card-body { padding:1.25rem; }
        .doc-card-name { font-size:1rem; font-weight:800; margin-bottom:.2rem; }
        .doc-card-spec { font-size:.83rem; color:var(--blue); font-weight:700; margin-bottom:.3rem; }
        .doc-card-dept { font-size:.8rem; color:var(--muted); }
        .doc-card-footer { padding:.9rem 1.25rem; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .stars { color:#f59e0b; font-size:.83rem; }

        /* ══ DEPT CARD ══ */
        .dept-card {
            background:#fff; border:2px solid var(--border); border-radius:var(--radius);
            padding:1.75rem; text-align:center; transition:all .3s;
        }
        .dept-card:hover { border-color:var(--blue); transform:translateY(-4px); box-shadow:var(--shadow-lg); }
        .dept-icon {
            width:70px; height:70px; border-radius:18px;
            background:linear-gradient(135deg,var(--blue-lt),var(--cyan-lt));
            color:var(--blue); display:flex; align-items:center; justify-content:center;
            font-size:1.8rem; margin:0 auto 1.1rem; transition:all .3s;
        }
        .dept-card:hover .dept-icon { background:linear-gradient(135deg,var(--blue),var(--cyan)); color:#fff; }

        /* ══ STAT CARD ══ */
        .stat-card {
            background:#fff; border:1px solid var(--border); border-radius:var(--radius);
            padding:1.5rem; display:flex; align-items:center; gap:1.1rem;
        }
        .stat-icon {
            width:56px; height:56px; border-radius:14px;
            display:flex; align-items:center; justify-content:center; font-size:1.4rem; flex-shrink:0;
        }
        .si-blue   { background:var(--blue-lt); color:var(--blue); }
        .si-cyan   { background:var(--cyan-lt); color:var(--cyan); }
        .si-green  { background:#d1fae5; color:#059669; }
        .si-purple { background:#f5f3ff; color:#7c3aed; }
        .si-orange { background:#fff7ed; color:#ea580c; }
        .stat-num { font-size:1.9rem; font-weight:900; line-height:1; }
        .stat-lbl { font-size:.82rem; color:var(--muted); margin-top:.2rem; }

        /* ══ FOOTER ══ */
        .footer { background:#0f172a; color:#94a3b8; padding:4rem 0 2rem; }
        .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:3rem; margin-bottom:3rem; }
        .footer h4 { color:#fff; font-size:.95rem; margin-bottom:1rem; font-weight:700; }
        .footer a { color:#94a3b8; display:block; margin-bottom:.5rem; font-size:.87rem; transition:color .2s; }
        .footer a:hover { color:#fff; }
        .footer-bottom { border-top:1px solid #1e293b; padding-top:1.5rem; text-align:center; font-size:.82rem; }

        /* ══ PAGINATION ══ */
        .pagination { display:flex; gap:.4rem; justify-content:center; margin-top:2rem; flex-wrap:wrap; }
        .page-link { padding:.5rem .9rem; border-radius:8px; border:2px solid var(--border); background:#fff; color:var(--text); font-size:.88rem; font-weight:600; transition:all .2s; }
        .page-link:hover, .page-link.active { background:var(--blue); border-color:var(--blue); color:#fff; }

        /* push content below fixed nav */
        main { padding-top:var(--nav-h); }

        @media(max-width:768px) {
            .grid-2,.grid-3,.grid-4 { grid-template-columns:1fr; }
            .footer-grid { grid-template-columns:1fr 1fr; }
            .nav-links { display:none; }
            .float-auth { bottom:20px; left:12px; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
            صحتي
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}"                class="{{ request()->routeIs('home') ? 'active':'' }}">الرئيسية</a></li>
            <li><a href="{{ route('departments') }}"         class="{{ request()->routeIs('departments*') ? 'active':'' }}">الأقسام</a></li>
            <li><a href="{{ route('doctors.index') }}"       class="{{ request()->routeIs('doctors*') ? 'active':'' }}">الدكاترة</a></li>
            <li><a href="{{ route('contact') }}"             class="{{ request()->routeIs('contact') ? 'active':'' }}">تواصل معنا</a></li>
            <li><a href="{{ route('about') }}"               class="{{ request()->routeIs('about') ? 'active':'' }}">عن المستشفى</a></li>
        </ul>
        <div class="nav-actions">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-gauge"></i> لوحة التحكم</a>
                @elseif(auth()->user()->role === 'doctor')
                    <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-stethoscope"></i> لوحتي</a>
                @else
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-calendar-check"></i> مواعيدي</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:none;cursor:pointer">
                        <i class="fa-solid fa-right-from-bracket"></i> خروج
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">دخول</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-user-plus"></i> تسجيل
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ══ FLOATING AUTH BUTTONS (guests only) ══ --}}
@guest
<div class="float-auth" id="floatAuth">
    <a href="{{ route('register') }}" class="float-btn float-btn-register">
        <i class="fa-solid fa-user-plus"></i> مستخدم جديد
    </a>
    <a href="{{ route('login') }}" class="float-btn float-btn-login">
        <i class="fa-solid fa-right-to-bracket"></i> تسجيل الدخول
    </a>
</div>
@endguest

{{-- FLASH --}}
@if(session('success'))
<div style="position:fixed;top:calc(var(--nav-h) + 1rem);right:1.5rem;z-index:800;max-width:380px">
    <div class="alert alert-success" style="box-shadow:0 8px 32px rgba(16,185,129,.2)">
        <i class="fa-solid fa-circle-check" style="flex-shrink:0;margin-top:.1rem"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif
@if(session('error'))
<div style="position:fixed;top:calc(var(--nav-h) + 1rem);right:1.5rem;z-index:800;max-width:380px">
    <div class="alert alert-danger" style="box-shadow:0 8px 32px rgba(239,68,68,.2)">
        <i class="fa-solid fa-circle-xmark" style="flex-shrink:0;margin-top:.1rem"></i>
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif

<main>
    {{ $slot ?? '' }}
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--cyan));display:flex;align-items:center;justify-content:center;color:#fff;font-size:.95rem">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <span style="color:#fff;font-size:1.15rem;font-family:'Poppins',sans-serif;font-weight:700">صحتي</span>
                </div>
                <p style="font-size:.87rem;line-height:1.9">مستشفى متكامل يقدم أعلى معايير الرعاية الصحية بأيدي نخبة من الأطباء المتخصصين.</p>
                <div style="display:flex;gap:.6rem;margin-top:1.25rem">
                    @foreach(['facebook-f','twitter','instagram','linkedin-in'] as $s)
                    <a href="#" style="width:36px;height:36px;background:#1e293b;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.82rem">
                        <i class="fab fa-{{ $s }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h4>روابط سريعة</h4>
                <a href="{{ route('home') }}">الرئيسية</a>
                <a href="{{ route('departments') }}">الأقسام</a>
                <a href="{{ route('doctors.index') }}">الدكاترة</a>
                <a href="{{ route('about') }}">عن المستشفى</a>
            </div>
            <div>
                <h4>خدماتنا</h4>
                <a href="{{ route('services.emergency') }}">طوارئ 24 ساعة</a>
                <a href="{{ route('services.lab') }}">مختبر تحاليل</a>
                <a href="{{ route('services.radiology') }}">أشعة وتصوير</a>
                <a href="{{ route('services.pharmacy') }}">صيدلية داخلية</a>
            </div>
            <div>
                <h4>تواصل معنا</h4>
                <div style="display:flex;gap:.5rem;margin-bottom:.6rem;font-size:.86rem">
                    <i class="fa-solid fa-location-dot" style="color:var(--cyan);margin-top:.2rem;flex-shrink:0"></i>
                    <span>   غزة الشفاء</span>
                </div>
                <div style="display:flex;gap:.5rem;margin-bottom:.6rem;font-size:.86rem;align-items:center">
                    <i class="fa-solid fa-phone" style="color:var(--cyan)"></i>
                    <span>02-2345678</span>
                </div>
                <div style="display:flex;gap:.5rem;font-size:.86rem;align-items:center">
                    <i class="fa-solid fa-envelope" style="color:var(--cyan)"></i>
                    <span>info@صحتي.com</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">© {{ date('Y') }} صحتي — جميع الحقوق محفوظة</div>
    </div>
</footer>

<script>
// Navbar scroll effect
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
});

// Floating auth — hide when scrolled up, show when scrolled down
@guest
const floatAuth = document.getElementById('floatAuth');
let lastScroll = 0;
window.addEventListener('scroll', () => {
    const current = window.scrollY;
    // hide when near top (navbar has login/register there)
    if (current < 120) {
        floatAuth.classList.add('hide');
    } else {
        floatAuth.classList.remove('hide');
    }
    lastScroll = current;
}, { passive: true });
// Start hidden
floatAuth.classList.add('hide');
@endguest

// Auto-dismiss flash after 4s
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(a => {
        a.style.transition = 'opacity .5s'; a.style.opacity = '0';
        setTimeout(() => a.parentElement?.remove(), 500);
    });
}, 4000);
</script>
@stack('scripts')
</body>
</html>