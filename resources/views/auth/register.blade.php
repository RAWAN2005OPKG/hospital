@extends('layouts.app')
@section('title','إنشاء حساب جديد')

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
    grid-template-columns: 1fr 1.5fr;
    width: 100%;
    max-width: 1100px;
    background: #fff;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
}
.auth-left{
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: #fff;
}
.auth-right{
    padding: 3.5rem;
    overflow-y: auto;
    max-height: 90vh;
}
.auth-box{ width: 100%; }

/* role pick cards */
.role-pick{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 2.5rem;
}
.role-card{
    border: 2px solid #f1f5f9;
    border-radius: 20px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8fafc;
    position: relative;
}
.role-card input{ display: none; }
.role-card i{ font-size: 2.5rem; color: #94a3b8; margin-bottom: 1rem; display: block; }
.role-card span{ display: block; font-weight: 800; font-size: 1.1rem; color: #475569; margin-bottom: .5rem; }
.role-card small{ display: block; font-size: .8rem; color: #94a3b8; line-height: 1.4; }

/* active role state */
.role-card.active[data-role="patient"] { border-color: #3b82f6; background: #eff6ff; }
.role-card.active[data-role="patient"] i, .role-card.active[data-role="patient"] span { color: #3b82f6; }

.role-card.active[data-role="doctor"] { border-color: #10b981; background: #f0fdf4; }
.role-card.active[data-role="doctor"] i, .role-card.active[data-role="doctor"] span { color: #10b981; }

.role-card.active[data-role="admin"] { border-color: #1e293b; background: #f1f5f9; }
.role-card.active[data-role="admin"] i, .role-card.active[data-role="admin"] span { color: #1e293b; }

.role-card#adminCard {
    display: none;
}

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
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
    transition: all 0.3s;
    outline: none;
}
.form-control:focus{ border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

.btn-register {
    width: 100%;
    padding: 1.1rem;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #fff;
    border: none;
    border-radius: 15px;
    font-weight: 800;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .75rem;
}
.btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); }

.admin-hint {
    font-size: 0.8rem;
    color: #94a3b8;
    text-align: center;
    margin-top: 1rem;
}

@media(max-width: 900px){
    .auth-container { grid-template-columns: 1fr; max-width: 550px; }
    .auth-left { display: none; }
    .form-grid { grid-template-columns: 1fr; gap: 0; }
    .role-pick { grid-template-columns: 1fr 1fr; }
}
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-container">
        {{-- LEFT SIDE --}}
        <div class="auth-left">
            <div style="width:60px;height:60px;border-radius:18px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:2rem;backdrop-filter:blur(10px)">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 style="font-size:2.25rem;font-weight:900;margin-bottom:1.5rem;line-height:1.2">{{ app()->getLocale() === 'ar' ? 'انضم إلى' : 'Join' }}<br>{{ __('messages.sehati') }}</h2>
            <p style="opacity:0.9;font-size:1.1rem;line-height:1.7;margin-bottom:3rem">{{ app()->getLocale() === 'ar' ? 'سجّل حسابك الآن واستمتع بتجربة صحية متكاملة ومطورة خصيصاً لتلبية احتياجاتك.' : 'Register your account now and enjoy a comprehensive and advanced healthcare experience tailored to meet your needs.' }}</p>
            
            <div style="display:flex;flex-direction:column;gap:1.5rem">
                <div style="display:flex;gap:1rem;background:rgba(255,255,255,0.1);padding:1.25rem;border-radius:20px;backdrop-filter:blur(5px)">
                    <i class="fa-solid fa-user-injured" style="font-size:1.5rem"></i>
                    <div>
                        <div style="font-weight:800;margin-bottom:.2rem">{{ app()->getLocale() === 'ar' ? 'للمرضى' : 'For Patients' }}</div>
                        <div style="font-size:.85rem;opacity:0.8">{{ app()->getLocale() === 'ar' ? 'حجز مواعيد فورية ومتابعة التقارير الطبية.' : 'Book instant appointments and track medical reports.' }}</div>
                    </div>
                </div>
                <div style="display:flex;gap:1rem;background:rgba(255,255,255,0.1);padding:1.25rem;border-radius:20px;backdrop-filter:blur(5px)">
                    <i class="fa-solid fa-user-md" style="font-size:1.5rem"></i>
                    <div>
                        <div style="font-weight:800;margin-bottom:.2rem">{{ app()->getLocale() === 'ar' ? 'للأطباء' : 'For Doctors' }}</div>
                        <div style="font-size:.85rem;opacity:0.8">{{ app()->getLocale() === 'ar' ? 'إدارة جدول المواعيد والمرضى بذكاء.' : 'Manage your schedule and patients intelligently.' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="auth-right">
            <div class="auth-box">
                <div style="margin-bottom:2.5rem;text-align:center">
                    <h1 style="font-size:1.8rem;font-weight:900;color:#1e293b;margin-bottom:.5rem" id="registerTitle" onclick="handleSecretClick()">{{ __('messages.register') }}</h1>
                    <p style="color:#64748b;font-size:1rem">{{ app()->getLocale() === 'ar' ? 'اختر نوع الحساب وأكمل بياناتك' : 'Choose your account type and complete your information' }}</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="role-pick">
                        <label class="role-card {{ old('role', 'patient') == 'patient' ? 'active' : '' }}" data-role="patient">
                            <input type="radio" name="role" value="patient" {{ old('role', 'patient') == 'patient' ? 'checked' : '' }} onchange="updateRoleUI(this)">
                            <i class="fa-solid fa-user"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'مريض' : 'Patient' }}</span>
                            <small>{{ app()->getLocale() === 'ar' ? 'أريد حجز مواعيد ومتابعة حالتي' : 'I want to book appointments and track my health' }}</small>
                        </label>
                        <label class="role-card {{ old('role') == 'doctor' ? 'active' : '' }}" data-role="doctor">
                            <input type="radio" name="role" value="doctor" {{ old('role') == 'doctor' ? 'checked' : '' }} onchange="updateRoleUI(this)">
                            <i class="fa-solid fa-user-md"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'دكتور' : 'Doctor' }}</span>
                            <small>{{ app()->getLocale() === 'ar' ? 'أريد إدارة مواعيدي ومرضاي' : 'I want to manage my schedule and patients' }}</small>
                        </label>
                        <label class="role-card {{ old('role') == 'admin' ? 'active' : '' }}" data-role="admin" id="adminCard">
                            <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} onchange="updateRoleUI(this)">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'أدمن' : 'Admin' }}</span>
                            <small>{{ app()->getLocale() === 'ar' ? 'أريد إدارة النظام' : 'I want to manage the system' }}</small>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-user"></i>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="مثال: محمد أحمد">
                        </div>
                        @error('name')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}</label>
                            <div class="input-wrap">
                                <i class="ico fa-solid fa-envelope"></i>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="example@email.com">
                            </div>
                            @error('email')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف' : 'Phone Number' }}</label>
                            <div class="input-wrap">
                                <i class="ico fa-solid fa-phone"></i>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="05xxxxxxxx">
                            </div>
                            @error('phone')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••" style="padding-right:1rem">
                            @error('password')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••" style="padding-right:1rem">
                        </div>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'ar' ? 'إنشاء الحساب الآن' : 'Create Account Now' }}
                    </button>
                </form>

                <div class="admin-hint" id="adminHint" style="display:none">
                    {{ app()->getLocale() === 'ar' ? '💡 تم تفعيل خيار إنشاء حساب أدمن' : '💡 Admin account creation enabled' }}
                </div>

                <div style="text-align:center;margin-top:2rem">
                    <p style="color:#64748b;font-size:.95rem">
                        {{ app()->getLocale() === 'ar' ? 'لديك حساب بالفعل؟' : 'Already have an account?' }} <a href="{{ route('login') }}" style="color:#6366f1;font-weight:800;text-decoration:none">{{ app()->getLocale() === 'ar' ? 'سجّل دخولك' : 'Sign in' }}</a>
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
        localStorage.setItem('adminRegisterRevealed', 'true');
        
        const adminCard = document.getElementById('adminCard');
        adminCard.style.display = 'block';
        
        const hint = document.getElementById('adminHint');
        hint.style.display = 'block';
        
        const msg = locale === 'ar' ? 'تم تفعيل خيار إنشاء حساب أدمن' : 'Admin account creation enabled';
        alert(msg);
    }
}

function updateRoleUI(input) {
    // Remove active class from all cards
    document.querySelectorAll('.role-card').forEach(card => card.classList.remove('active'));
    // Add active class to the parent label of the checked radio
    if (input.checked) {
        input.parentElement.classList.add('active');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const adminRevealed = localStorage.getItem('adminRegisterRevealed') === 'true';
    if (adminRevealed) {
        adminRevealed = true;
        const adminCard = document.getElementById('adminCard');
        adminCard.style.display = 'block';
        const hint = document.getElementById('adminHint');
        hint.style.display = 'block';
    }
});
</script>
@endpush
@endsection
