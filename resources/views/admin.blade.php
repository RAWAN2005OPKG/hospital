<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','لوحة التحكم') — صحتي Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --blue:#2563EB;--blue-dk:#1d4ed8;--blue-lt:#EFF6FF;
            --cyan:#06b6d4;--cyan-lt:#ecfeff;
            --sidebar:#0f172a;--sidebar-hover:#1e293b;
            --text:#0f172a;--muted:#64748b;--border:#e2e8f0;
            --bg:#f0f7ff;--white:#fff;
            --radius:12px;--shadow:0 2px 12px rgba(37,99,235,.07);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Tajawal',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
        a{text-decoration:none;color:inherit}

        /* sidebar */
        .sidebar{width:260px;flex-shrink:0;background:var(--sidebar);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
        .sb-logo{padding:1.5rem 1.25rem;border-bottom:1px solid #1e293b;display:flex;align-items:center;gap:.6rem}
        .sb-logo .ico{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--cyan));display:flex;align-items:center;justify-content:center;color:#fff;font-size:.95rem;flex-shrink:0}
        .sb-logo span{color:#fff;font-family:'Poppins',sans-serif;font-weight:700;font-size:1.05rem}
        .sb-logo small{display:block;color:#64748b;font-size:.7rem}
        .sb-nav{padding:.75rem;flex:1}
        .sb-section{color:#475569;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;padding:.75rem .5rem .35rem}
        .sb-link{display:flex;align-items:center;gap:.75rem;padding:.65rem .85rem;border-radius:8px;color:#94a3b8;font-size:.87rem;font-weight:600;transition:all .2s;margin-bottom:.1rem;cursor:pointer}
        .sb-link i{width:18px;text-align:center;font-size:.88rem}
        .sb-link:hover{background:var(--sidebar-hover);color:#fff}
        .sb-link.active{background:var(--blue);color:#fff}

        /* main */
        .admin-main{flex:1;display:flex;flex-direction:column;min-width:0}
        .admin-header{background:var(--white);border-bottom:1px solid var(--border);padding:.9rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:0 1px 6px rgba(0,0,0,.04)}
        .admin-header h2{font-size:1.05rem;font-weight:800}
        .admin-content{padding:2rem;flex:1}
        .avatar{width:36px;height:36px;border-radius:50%;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem}

        /* cards */
        .card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden}
        .card-header{padding:1rem 1.5rem;border-bottom:1px solid var(--border);font-weight:700;display:flex;align-items:center;justify-content:space-between;font-size:.92rem}
        .card-body{padding:1.5rem}
        .stat-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1.4rem;display:flex;align-items:center;gap:1rem}
        .stat-icon{width:52px;height:52px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
        .si-blue{background:var(--blue-lt);color:var(--blue)}.si-cyan{background:var(--cyan-lt);color:var(--cyan)}.si-green{background:#d1fae5;color:#059669}.si-purple{background:#f5f3ff;color:#7c3aed}.si-orange{background:#fff7ed;color:#ea580c}.si-red{background:#fee2e2;color:#dc2626}
        .stat-num{font-size:1.8rem;font-weight:900;line-height:1}.stat-lbl{font-size:.78rem;color:var(--muted);margin-top:.15rem}

        /* btns */
        .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;border-radius:50px;font-family:'Tajawal',sans-serif;font-weight:700;font-size:.87rem;cursor:pointer;border:none;transition:all .2s}
        .btn-primary{background:linear-gradient(135deg,var(--blue),var(--cyan));color:#fff}
        .btn-primary:hover{opacity:.9;transform:translateY(-1px)}
        .btn-outline{background:transparent;border:2px solid var(--border);color:var(--text)}
        .btn-outline:hover{border-color:var(--blue);color:var(--blue)}
        .btn-danger{background:#ef4444;color:#fff}
        .btn-success{background:#10b981;color:#fff}
        .btn-sm{padding:.35rem .8rem;font-size:.8rem}

        /* table */
        .table-responsive{overflow-x:auto}
        .table{width:100%;border-collapse:collapse;font-size:.87rem}
        .table th,.table td{padding:.8rem 1rem;border-bottom:1px solid var(--border);text-align:right}
        .table th{background:#f8fafc;font-weight:800;color:var(--muted);font-size:.75rem;text-transform:uppercase;letter-spacing:.04em}
        .table tbody tr:hover{background:#f8fafc}

        /* badge */
        .badge{display:inline-flex;align-items:center;gap:.25rem;padding:.2rem .65rem;border-radius:20px;font-size:.75rem;font-weight:700}
        .badge-green{background:#d1fae5;color:#059669}.badge-red{background:#fee2e2;color:#dc2626}.badge-yellow{background:#fef3c7;color:#d97706}.badge-blue{background:var(--blue-lt);color:var(--blue)}.badge-gray{background:#f1f5f9;color:#64748b}.badge-cyan{background:var(--cyan-lt);color:#0891b2}

        /* alerts */
        .alert{padding:.9rem 1.15rem;border-radius:var(--radius);border-right:4px solid;margin-bottom:1rem;display:flex;align-items:flex-start;gap:.7rem;font-size:.88rem}
        .alert-success{background:#f0fdf4;border-color:#10b981;color:#065f46}
        .alert-danger{background:#fef2f2;border-color:#ef4444;color:#7f1d1d}

        /* form */
        .form-group{margin-bottom:1.15rem}
        .form-label{display:block;font-weight:700;font-size:.85rem;margin-bottom:.35rem}
        .form-control{width:100%;padding:.65rem .9rem;border:2px solid var(--border);border-radius:9px;font-family:'Tajawal',sans-serif;font-size:.87rem;color:var(--text);background:#fff;transition:all .2s}
        .form-control:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
        .form-control.is-invalid{border-color:#ef4444}
        .invalid-feedback{color:#ef4444;font-size:.78rem;margin-top:.2rem}
        textarea.form-control{resize:vertical;min-height:100px}

        .grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}
        .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem}
        .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem}

        @media(max-width:900px){.sidebar{display:none}.grid-2,.grid-3,.grid-4{grid-template-columns:1fr}}
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sb-logo">
        <div class="ico"><i class="fa-solid fa-heart-pulse"></i></div>
        <div><span>صحتي</span><small>Admin Panel</small></div>
    </div>
    <nav class="sb-nav">
        <div class="sb-section">الرئيسية</div>
        <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active':'' }}">
            <i class="fa-solid fa-gauge"></i> لوحة التحكم
        </a>

        <div class="sb-section">الإدارة</div>
        <a href="{{ route('admin.doctors') }}" class="sb-link {{ request()->routeIs('admin.doctors*') ? 'active':'' }}">
            <i class="fa-solid fa-user-doctor"></i> الدكاترة
        </a>
        <a href="{{ route('admin.departments') }}" class="sb-link {{ request()->routeIs('admin.departments*') ? 'active':'' }}">
            <i class="fa-solid fa-hospital"></i> الأقسام
        </a>
        <a href="{{ route('admin.appointments') }}" class="sb-link {{ request()->routeIs('admin.appointments*') ? 'active':'' }}">
            <i class="fa-solid fa-calendar-check"></i> الحجوزات
        </a>
        <a href="{{ route('admin.users') }}" class="sb-link {{ request()->routeIs('admin.users*') ? 'active':'' }}">
            <i class="fa-solid fa-users"></i> المستخدمون
        </a>

        <div class="sb-section">النظام</div>
        <a href="{{ route('home') }}" class="sb-link" target="_blank">
            <i class="fa-solid fa-earth-asia"></i> عرض الموقع
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-link" style="width:100%;text-align:right;background:none;border:none;cursor:pointer">
                <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
            </button>
        </form>
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-header">
        <h2>@yield('page-title','لوحة التحكم')</h2>
        <div style="display:flex;align-items:center;gap:1rem">
            <div class="avatar">{{ mb_substr(auth()->user()->name,0,1) }}</div>
            <div>
                <div style="font-weight:700;font-size:.87rem">{{ auth()->user()->name }}</div>
                <div style="font-size:.73rem;color:var(--muted)">مدير النظام</div>
            </div>
        </div>
    </header>
    <main class="admin-content">
        @if(session('success'))<div class="alert alert-success"><i class="fa-solid fa-circle-check" style="flex-shrink:0;margin-top:.1rem"></i><span>{{ session('success') }}</span></div>@endif
        @if(session('error'))<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark" style="flex-shrink:0;margin-top:.1rem"></i><span>{{ session('error') }}</span></div>@endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>