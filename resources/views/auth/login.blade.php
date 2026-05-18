@extends('layouts.app')

@section('title', 'تسجيل الدخول - صحتي')

@section('content')
<div style="min-height: calc(100vh - var(--nav-h)); display: flex; align-items: center; background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05));">
    <div class="container">
        <div style="max-width: 450px; margin: 0 auto; background: #fff; border-radius: 16px; padding: 2.5rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);">
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, var(--blue), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; margin: 0 auto 1rem;">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">تسجيل الدخول</h1>
                <p style="color: var(--muted);">ادخل بيانات حسابك للمتابعة</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('email') border-red-500 @enderror" placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">كلمة المرور</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('password') border-red-500 @enderror" placeholder="أدخل كلمة مرورك">
                    @error('password')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span style="font-size: 0.95rem; color: var(--gray-600);">تذكرني</span>
                    </label>
                    <a href="#" style="color: var(--blue); text-decoration: none; font-size: 0.95rem;">هل نسيت كلمة المرور؟</a>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1rem; margin-top: 0.5rem;">
                    <i class="fa-solid fa-arrow-left"></i> دخول
                </button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--muted);">
                ليس لديك حساب؟ <a href="{{ route('register') }}" style="color: var(--blue); text-decoration: none; font-weight: 600;">إنشاء حساب جديد</a>
            </p>
        </div>
    </div>
</div>
@endsection