@extends('layouts.app')
@section('title','تسجيل الدخول')

@push('styles')
<style>
.auth-wrap{
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    padding: 2rem;
}
.auth-container {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    width: 100%;
    max-width: 1000px;
    background: #fff;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
}
.auth-left{
    background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
    padding: 3.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: #fff;
    position: relative;
}
.auth-right{
    padding: 3.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.auth-box{ width: 100%; }

/* role tabs */
.role-tabs{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .5rem;
    background: #f1f5f9;
    border-radius: 15px;
    padding: .4rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}
.role-tab{
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .6rem;
    padding: .8rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: .95rem;
    cursor: pointer;
    transition: all .3s ease;
    color: #64748b;
    border: none;
    background: transparent;
}
.role-tab.active{
    background: #fff;
    color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; font-weight: 700; color: #334155; margin-bottom: .5rem; font-size: .9rem; }
.input-wrap{ position: relative; }
.input-wrap i.ico{ position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
.form-control{ 
    width: 100%;
    padding: .85rem 2.8rem .85rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: .95rem;
    transition: all .3s;
    outline: none;
}
.form-control:focus{ border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
.eye-btn{ position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #94a3b8; }

.btn-login {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 800;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .75rem;
}
.btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3); }

.admin-hint {
    font-size: 0.8rem;
    color: #94a3b8;
    text-align: center;
    margin-top: 1rem;
}

@media(max-width: 900px){
    .auth-container { grid-template-columns: 1fr; max-width: 500px; }
    .auth-left { display: none; }
}
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-container">
        {{-- LEFT SIDE --}}
        <div class="auth-left">
            <div style="width:64px;height:64px;border-radius:20px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:2rem;backdrop-filter:blur(10px)">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <h2 style="font-size:2.25rem;font-weight:900;margin-bottom:1.5rem;line-height:1.2">{{ __('messages.login_welcome') }}<br>{{ __('messages.sehati') }}</h2>
            <p style="opacity:0.9;font-size:1.1rem;line-height:1.7;margin-bottom:2.5rem">{{ __('messages.login_subtitle') }}</p>
            <div style="display:flex;flex-direction:column;gap:1.25rem">
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-check-circle" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'إدارة المواعيد بذكاء' : 'Smart Appointment Management' }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-check-circle" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'سجلات طبية آمنة' : 'Secure Medical Records' }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-check-circle" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تواصل مباشر مع الأطباء' : 'Direct Communication with Doctors' }}</span>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="auth-right">
            <div class="auth-box">
                <div style="margin-bottom:2.5rem;text-align:center">
                    <h1 style="font-size:1.85rem;font-weight:900;color:#1e293b;margin-bottom:.5rem;cursor:default" id="loginTitle" onclick="handleSecretClick()">{{ __('messages.login') }}</h1>
                    <p style="color:#64748b;font-size:1rem">{{ app()->getLocale() === 'ar' ? 'اختر نوع الحساب وادخل بياناتك' : 'Choose your account type and enter your credentials' }}</p>
                </div>

                {{-- ROLE TABS --}}
                <div class="role-tabs" id="roleTabs">
                    <button type="button" class="role-tab active" id="tabPatient" onclick="setRole('patient')">
                        <i class="fa-solid fa-user"></i> {{ app()->getLocale() === 'ar' ? 'مريض' : 'Patient' }}
                    </button>
                    <button type="button" class="role-tab" id="tabDoctor" onclick="setRole('doctor')">
                        <i class="fa-solid fa-user-md"></i> {{ app()->getLocale() === 'ar' ? 'دكتور' : 'Doctor' }}
                    </button>
                    <button type="button" class="role-tab" id="tabAdmin" onclick="setRole('admin')" style="display:none">
                        <i class="fa-solid fa-user-shield"></i> {{ app()->getLocale() === 'ar' ? 'أدمن' : 'Admin' }}
                    </button>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="patient">

                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-envelope"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', session('registered_email')) }}" required autofocus placeholder="example@email.com">
                        </div>
                        @error('email')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-lock"></i>
                            <input type="password" name="password" id="pwdField" class="form-control" required placeholder="••••••••">
                            <button type="button" class="eye-btn" onclick="togglePwd()">
                                <i class="fa-solid fa-eye" id="eyeIco"></i>
                            </button>
                        </div>
                    </div>

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem">
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.9rem;color:#64748b">
                            <input type="checkbox" name="remember" style="width:18px;height:18px;accent-color:#3b82f6"> {{ app()->getLocale() === 'ar' ? 'تذكرني' : 'Remember me' }}
                        </label>
                        <a href="#" style="font-size:.9rem;color:#3b82f6;font-weight:700;text-decoration:none">{{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot password?' }}</a>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span id="loginBtnText">{{ app()->getLocale() === 'ar' ? 'دخول كمريض' : 'Login as Patient' }}</span>
                    </button>
                </form>

                <div class="admin-hint" id="adminHint" style="display:none">
                    {{ app()->getLocale() === 'ar' ? '💡 تم تفعيل خيار دخول الأدمن' : '💡 Admin login option enabled' }}
                </div>

                <div style="text-align:center;margin-top:2.5rem">
                    <p style="color:#64748b;font-size:.95rem">
                        {{ app()->getLocale() === 'ar' ? 'ليس لديك حساب؟' : 'Don\'t have an account?' }} <a href="{{ route('register') }}" style="color:#3b82f6;font-weight:800;text-decoration:none">{{ app()->getLocale() === 'ar' ? 'سجّل الآن' : 'Register now' }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let secretClickCount = 0;
let adminRevealed = false;
const locale = '{{ app()->getLocale() }}';

function handleSecretClick() {
    secretClickCount++;
    if (secretClickCount === 5 && !adminRevealed) {
        adminRevealed = true;
        localStorage.setItem('adminRevealed', 'true');
        
        const adminTab = document.getElementById('tabAdmin');
        adminTab.style.display = 'flex';
        
        const tabsContainer = document.getElementById('roleTabs');
        tabsContainer.style.gridTemplateColumns = '1fr 1fr 1fr';
        
        const hint = document.getElementById('adminHint');
        hint.style.display = 'block';
        
        const msg = locale === 'ar' ? 'تم تفعيل خيار دخول الأدمن' : 'Admin login option enabled';
        alert(msg);
    }
}

function setRole(role) {
    const isDoc = role === 'doctor';
    const isAdmin = role === 'admin';
    
    document.getElementById('tabPatient').classList.toggle('active', role === 'patient');
    document.getElementById('tabDoctor').classList.toggle('active', isDoc);
    document.getElementById('tabAdmin').classList.toggle('active', isAdmin);
    
    document.getElementById('roleInput').value = role;
    
    let btnText = locale === 'ar' ? 'دخول كمريض' : 'Login as Patient';
    let btnBg = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
    
    if (isDoc) {
        btnText = locale === 'ar' ? 'دخول كدكتور' : 'Login as Doctor';
        btnBg = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
    } else if (isAdmin) {
        btnText = locale === 'ar' ? 'دخول كأدمن' : 'Login as Admin';
        btnBg = 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)';
    }
    
    const btn = document.querySelector('.btn-login');
    document.getElementById('loginBtnText').textContent = btnText;
    btn.style.background = btnBg;
}

function togglePwd() {
    const f = document.getElementById('pwdField');
    const i = document.getElementById('eyeIco');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'text' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const adminRevealed = localStorage.getItem('adminRevealed') === 'true';
    if (adminRevealed) {
        adminRevealed = true;
        const adminTab = document.getElementById('tabAdmin');
        adminTab.style.display = 'flex';
        const tabsContainer = document.getElementById('roleTabs');
        tabsContainer.style.gridTemplateColumns = '1fr 1fr 1fr';
        const hint = document.getElementById('adminHint');
        hint.style.display = 'block';
    }
});
</script>
@endpush
@endsection
