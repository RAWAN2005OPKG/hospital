@extends('layouts.app')
@section('title','إعادة تعيين كلمة المرور')

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
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
.form-control:focus{ border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
.eye-btn{ position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #94a3b8; }

.btn-submit {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }

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
                <i class="fa-solid fa-rotate"></i>
            </div>
            <h2 style="font-size:2.25rem;font-weight:900;margin-bottom:1.5rem;line-height:1.2">{{ app()->getLocale() === 'ar' ? 'تعيين كلمة مرور جديدة' : 'Set New Password' }}</h2>
            <p style="opacity:0.9;font-size:1.1rem;line-height:1.7;margin-bottom:2.5rem">{{ app()->getLocale() === 'ar' ? 'أنشئ كلمة مرور قوية وآمنة لحسابك. تأكد من أنها لا تشبه كلمات المرور السابقة.' : 'Create a strong and secure password for your account. Make sure it\'s different from previous passwords.' }}</p>
            <div style="display:flex;flex-direction:column;gap:1.25rem">
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-lock" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'كلمة مرور قوية' : 'Strong password' }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-shield-check" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حماية متقدمة' : 'Advanced protection' }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-check-double" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تحديث فوري' : 'Instant update' }}</span>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="auth-right">
            <div class="auth-box">
                <div style="margin-bottom:2.5rem;text-align:center">
                    <h1 style="font-size:1.85rem;font-weight:900;color:#1e293b;margin-bottom:.5rem">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}</h1>
                    <p style="color:#64748b;font-size:1rem">{{ app()->getLocale() === 'ar' ? 'أدخل كلمة المرور الجديدة وتأكيدها' : 'Enter your new password and confirm it' }}</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-envelope"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autofocus placeholder="example@email.com" readonly>
                        </div>
                        @error('email')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-lock"></i>
                            <input type="password" name="password" id="pwdField" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                            <button type="button" class="eye-btn" onclick="togglePwd()">
                                <i class="fa-solid fa-eye" id="eyeIco"></i>
                            </button>
                        </div>
                        @error('password')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-lock"></i>
                            <input type="password" name="password_confirmation" id="pwdConfirmField" class="form-control" required placeholder="••••••••">
                            <button type="button" class="eye-btn" onclick="toggleConfirmPwd()">
                                <i class="fa-solid fa-eye" id="eyeConfirmIco"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-check"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'تحديث كلمة المرور' : 'Update Password' }}</span>
                    </button>
                </form>

                <div style="text-align:center;margin-top:2.5rem">
                    <p style="color:#64748b;font-size:.95rem">
                        {{ app()->getLocale() === 'ar' ? 'تذكرت كلمة المرور؟' : 'Remember your password?' }} <a href="{{ route('login') }}" style="color:#10b981;font-weight:800;text-decoration:none">{{ app()->getLocale() === 'ar' ? 'عد لتسجيل الدخول' : 'Back to login' }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePwd() {
    const f = document.getElementById('pwdField');
    const i = document.getElementById('eyeIco');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'text' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
}

function toggleConfirmPwd() {
    const f = document.getElementById('pwdConfirmField');
    const i = document.getElementById('eyeConfirmIco');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'text' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
}
</script>
@endpush
@endsection
