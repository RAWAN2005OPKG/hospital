{{-- ════════════ auth/login.blade.php ════════════ --}}
@extends('layouts.app')
@section('title','تسجيل الدخول')

@push('styles')
<style>
.auth-page {
    min-height:calc(100vh - var(--nav-h));
    display:flex; align-items:center; justify-content:center;
    padding:3rem 1.5rem;
    background:linear-gradient(135deg,#eff6ff 0%,#ecfeff 100%);
    position:relative; overflow:hidden;
}
.auth-page::before {
    content:''; position:absolute; top:-200px; right:-200px;
    width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(37,99,235,.08),transparent 70%);
}
.auth-box {
    width:100%; max-width:460px; position:relative; z-index:1;
}
.auth-card {
    background:#fff; border-radius:24px; padding:2.5rem;
    box-shadow:0 20px 60px rgba(37,99,235,.12);
    border:1px solid rgba(37,99,235,.08);
}
.auth-logo {
    width:64px; height:64px; border-radius:18px;
    background:linear-gradient(135deg,var(--blue),var(--cyan));
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 1.5rem; font-size:1.7rem; color:#fff;
    box-shadow:0 8px 24px rgba(37,99,235,.3);
}
.auth-title { text-align:center; margin-bottom:2rem; }
.auth-title h1 { font-size:1.6rem; font-weight:900; }
.auth-title p { color:var(--muted); margin-top:.3rem; }
.social-row { display:flex; gap:.75rem; margin-bottom:1.5rem; }
.social-btn {
    flex:1; padding:.7rem; border:2px solid var(--border); border-radius:10px;
    background:#fff; font-family:'Tajawal',sans-serif; font-size:.87rem; font-weight:700;
    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem;
    transition:all .2s; color:var(--text);
}
.social-btn:hover { border-color:var(--blue); background:var(--blue-lt); }
.divider { display:flex; align-items:center; gap:.75rem; margin-bottom:1.5rem; }
.divider::before,.divider::after { content:''; flex:1; height:1px; background:var(--border); }
.divider span { font-size:.8rem; color:var(--muted); font-weight:600; }
</style>
@endpush

@section('content')
<div class="auth-page">
<div class="auth-box">
    <div style="text-align:center;margin-bottom:1.5rem">
        <div class="auth-logo"><i class="fa-solid fa-right-to-bracket"></i></div>
        <div class="auth-title">
            <h1>أهلاً بعودتك!</h1>
            <p>سجّل دخولك للوصول إلى حسابك</p>
        </div>
    </div>
    <div class="auth-card">
        <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">البريد الإلكتروني</label>
            <div style="position:relative">
                <i class="fa-solid fa-envelope" style="position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.85rem"></i>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    style="padding-right:2.5rem"
                    value="{{ old('email') }}" required autofocus
                    placeholder="example@email.com">
            </div>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.4rem">
                <label class="form-label" style="margin:0">كلمة المرور</label>
            </div>
            <div style="position:relative">
                <i class="fa-solid fa-lock" style="position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.85rem"></i>
                <input type="password" name="password" id="passInput"
                    class="form-control @error('password') is-invalid @enderror"
                    style="padding-right:2.5rem;padding-left:2.5rem"
                    required placeholder="••••••••">
                <button type="button" onclick="togglePass()" style="position:absolute;left:.9rem;top:50%;transform:translateY(-50%);border:none;background:none;cursor:pointer;color:var(--muted)">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.5rem">
            <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:var(--blue)">
            <label for="remember" style="font-size:.87rem;cursor:pointer">تذكرني</label>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.85rem;font-size:.95rem">
            <i class="fa-solid fa-right-to-bracket"></i> تسجيل الدخول
        </button>
        </form>
    </div>
    <p style="text-align:center;margin-top:1.5rem;font-size:.9rem;color:var(--muted)">
        ليس لديك حساب؟
        <a href="{{ route('register') }}" style="color:var(--blue);font-weight:800">سجّل الآن</a>
    </p>
</div>
</div>
@push('scripts')
<script>
function togglePass() {
    const inp = document.getElementById('passInput');
    const ico = document.getElementById('eyeIcon');
    if (inp.type === 'password') { inp.type = 'text'; ico.className = 'fa-solid fa-eye-slash'; }
    else { inp.type = 'password'; ico.className = 'fa-solid fa-eye'; }
}
</script>
@endpush
@endsection