@extends('layouts.app')
@section('title','تسجيل الدخول')

@push('styles')
<style>
.auth-wrap{
    min-height:calc(100vh - var(--nav-h));
    display:grid; grid-template-columns:1fr 1fr;
}
.auth-left{
    background:linear-gradient(135deg,var(--blue) 0%,var(--cyan) 100%);
    padding:3rem; display:flex; flex-direction:column;
    justify-content:center; position:relative; overflow:hidden;
}
.auth-left::before{
    content:''; position:absolute; top:-80px; right:-80px;
    width:300px; height:300px; border-radius:50%;
    background:rgba(255,255,255,.08);
}
.auth-left::after{
    content:''; position:absolute; bottom:-60px; left:-60px;
    width:200px; height:200px; border-radius:50%;
    background:rgba(255,255,255,.06);
}
.auth-right{
    background:var(--bg); display:flex; align-items:center;
    justify-content:center; padding:3rem 2rem;
}
.auth-box{width:100%; max-width:420px;}
.auth-card{background:#fff; border-radius:20px; padding:2.5rem; box-shadow:0 20px 60px rgba(37,99,235,.1); border:1px solid rgba(37,99,235,.07);}

/* role tabs */
.role-tabs{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;background:#f1f5f9;border-radius:12px;padding:.35rem;margin-bottom:1.75rem}
.role-tab{display:flex;align-items:center;justify-content:center;gap:.5rem;padding:.7rem;border-radius:9px;font-weight:700;font-size:.88rem;cursor:pointer;transition:all .25s;color:var(--muted);border:none;background:transparent;font-family:'Tajawal',sans-serif}
.role-tab.active{background:#fff;color:var(--blue);box-shadow:0 2px 10px rgba(37,99,235,.12)}
.role-tab i{font-size:1rem}

.input-wrap{position:relative}
.input-wrap i.ico{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.82rem;pointer-events:none}
.input-wrap .form-control{padding-right:2.5rem}
.eye-btn{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);border:none;background:none;cursor:pointer;color:var(--muted);font-size:.85rem}

@media(max-width:768px){
    .auth-wrap{grid-template-columns:1fr}
    .auth-left{display:none}
}
</style>
@endpush

@section('content')
<div class="auth-wrap">

    {{-- LEFT SIDE --}}
    <div class="auth-left">
        <div style="position:relative;z-index:1;color:#fff">
            <div style="width:64px;height:64px;border-radius:18px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:2rem;backdrop-filter:blur(8px)">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <h2 style="font-size:2rem;font-weight:900;margin-bottom:1rem;line-height:1.3">مرحباً بك في<br>ProHealth</h2>
            <p style="opacity:.9;font-size:1rem;line-height:1.8;margin-bottom:2.5rem">
                سجّل دخولك للوصول إلى لوحة التحكم الخاصة بك وإدارة المواعيد والحجوزات.
            </p>
            <div style="display:flex;flex-direction:column;gap:1rem">
                @foreach(['fa-calendar-check'=>'إدارة المواعيد بسهولة','fa-file-medical'=>'الوصول للسجلات الطبية','fa-bell'=>'إشعارات فورية للمواعيد'] as $icon=>$text)
                <div style="display:flex;align-items:center;gap:.85rem">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    <span style="font-size:.9rem;opacity:.9">{{ $text }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE --}}
    <div class="auth-right">
    <div class="auth-box">
        <div style="margin-bottom:2rem;text-align:center">
            <h1 style="font-size:1.6rem;font-weight:900;margin-bottom:.3rem">تسجيل الدخول</h1>
            <p style="color:var(--muted);font-size:.9rem">اختر نوع حسابك وسجّل دخولك</p>
        </div>

        <div class="auth-card">
            {{-- ROLE TABS --}}
            <div class="role-tabs" id="roleTabs">
                <button class="role-tab active" id="tabPatient" onclick="setRole('patient')">
                    <i class="fa-solid fa-user"></i> مريض
                </button>
                <button class="role-tab" id="tabDoctor" onclick="setRole('doctor')">
                    <i class="fa-solid fa-user-doctor"></i> دكتور
                </button>
            </div>

            {{-- Role hint --}}
            <div id="roleHint" style="display:flex;align-items:center;gap:.6rem;background:var(--blue-lt);border-radius:10px;padding:.7rem 1rem;margin-bottom:1.5rem;font-size:.83rem;color:var(--blue)">
                <i class="fa-solid fa-circle-info"></i>
                <span id="roleHintText">ادخل ببيانات حساب المريض الخاص بك</span>
            </div>

            <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="patient">

            <div class="form-group">
                <label class="form-label">البريد الإلكتروني</label>
                <div class="input-wrap">
                    <i class="ico fa-solid fa-envelope"></i>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus
                        placeholder="example@email.com">
                </div>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('identifier')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <div style="display:flex;justify-content:space-between;margin-bottom:.38rem">
                    <label class="form-label" style="margin:0">كلمة المرور</label>
                </div>
                <div class="input-wrap">
                    <i class="ico fa-solid fa-lock"></i>
                    <input type="password" name="password" id="pwdField"
                        class="form-control @error('password') is-invalid @enderror"
                        required placeholder="••••••••"
                        style="padding-left:2.5rem">
                    <button type="button" class="eye-btn" onclick="togglePwd()">
                        <i class="fa-solid fa-eye" id="eyeIco"></i>
                    </button>
                </div>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.5rem">
                <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:var(--blue)">
                <label for="remember" style="font-size:.86rem;cursor:pointer;color:var(--muted)">تذكرني</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.85rem;font-size:.95rem">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span id="loginBtnText">دخول كمريض</span>
            </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:1.5rem">
            <p style="font-size:.88rem;color:var(--muted)">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" style="color:var(--blue);font-weight:800">سجّل الآن</a>
            </p>
        </div>
    </div>
    </div>
</div>

@push('scripts')
<script>
function setRole(role) {
    const isDoc = role === 'doctor';
    document.getElementById('tabPatient').classList.toggle('active', !isDoc);
    document.getElementById('tabDoctor').classList.toggle('active', isDoc);
    document.getElementById('roleInput').value = role;
    document.getElementById('roleHintText').textContent = isDoc
        ? 'ادخل ببيانات حسابك كطبيب'
        : 'ادخل ببيانات حساب المريض الخاص بك';
    document.getElementById('loginBtnText').textContent = isDoc ? 'دخول كدكتور' : 'دخول كمريض';
    // change hint color
    const hint = document.getElementById('roleHint');
    hint.style.background = isDoc ? '#f0fdf4' : 'var(--blue-lt)';
    hint.style.color = isDoc ? '#059669' : 'var(--blue)';
    hint.querySelector('i').className = 'fa-solid fa-' + (isDoc ? 'stethoscope' : 'circle-info');
}

function togglePwd() {
    const f = document.getElementById('pwdField');
    const i = document.getElementById('eyeIco');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'text' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
}
</script>
@endpush
@endsection