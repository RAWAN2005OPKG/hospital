@extends('layouts.app')
@section('title','نسيت كلمة المرور')

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
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
.form-control:focus{ border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1); }

.btn-submit {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3); }

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
                <i class="fa-solid fa-key"></i>
            </div>
            <h2 style="font-size:2.25rem;font-weight:900;margin-bottom:1.5rem;line-height:1.2">{{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}</h2>
            <p style="opacity:0.9;font-size:1.1rem;line-height:1.7;margin-bottom:2.5rem">{{ app()->getLocale() === 'ar' ? 'لا تقلق، سنساعدك في استعادة حسابك. أدخل بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور.' : 'Don\'t worry, we\'ll help you recover your account. Enter your email and we\'ll send you a password reset link.' }}</p>
            <div style="display:flex;flex-direction:column;gap:1.25rem">
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-shield-halved" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'إرسال رابط آمن ومشفر' : 'Secure encrypted link' }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-clock" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'الرابط صالح لمدة ساعة' : 'Link valid for 1 hour' }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem">
                    <i class="fa-solid fa-envelope-circle-check" style="color:#fff"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'إرسال فوري إلى بريدك' : 'Instant delivery to your email' }}</span>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="auth-right">
            <div class="auth-box">
                <div style="margin-bottom:2.5rem;text-align:center">
                    <h1 style="font-size:1.85rem;font-weight:900;color:#1e293b;margin-bottom:.5rem">{{ app()->getLocale() === 'ar' ? 'استعادة كلمة المرور' : 'Reset Password' }}</h1>
                    <p style="color:#64748b;font-size:1rem">{{ app()->getLocale() === 'ar' ? 'أدخل بريدك الإلكتروني المسجل' : 'Enter your registered email address' }}</p>
                </div>

                @if (session('status'))
                    <div style="background:#dcfce7;color:#166534;padding:1rem;border-radius:12px;margin-bottom:1.5rem;text-align:center;font-weight:600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                        <div class="input-wrap">
                            <i class="ico fa-solid fa-envelope"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="example@email.com">
                        </div>
                        @error('email')<div style="color:#ef4444;font-size:.85rem;margin-top:.5rem">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'إرسال رابط إعادة التعيين' : 'Send Reset Link' }}</span>
                    </button>
                </form>

                <div style="text-align:center;margin-top:2.5rem">
                    <p style="color:#64748b;font-size:.95rem">
                        {{ app()->getLocale() === 'ar' ? 'تذكرت كلمة المرور؟' : 'Remember your password?' }} <a href="{{ route('login') }}" style="color:#f59e0b;font-weight:800;text-decoration:none">{{ app()->getLocale() === 'ar' ? 'عد لتسجيل الدخول' : 'Back to login' }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
