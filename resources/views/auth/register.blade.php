@extends('layouts.app')

@section('title', 'تسجيل جديد - صحتي')

@section('content')
<div style="min-height: calc(100vh - var(--nav-h)); display: flex; align-items: center; background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05));">
    <div class="container">
        <div style="max-width: 450px; margin: 0 auto; background: #fff; border-radius: 16px; padding: 2.5rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);">
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, var(--blue), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; margin: 0 auto 1rem;">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">إنشاء حساب جديد</h1>
                <p style="color: var(--muted);">انضم إلى منصة صحتي الآن</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('name') border-red-500 @enderror" placeholder="أدخل اسمك الكامل">
                    @error('name')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('email') border-red-500 @enderror" placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">رقم الجوال</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('phone') border-red-500 @enderror" placeholder="أدخل رقم جوالك">
                    @error('phone')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">نوع الحساب</label>
                    <select name="role" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('role') border-red-500 @enderror">
                        <option value="">اختر نوع الحساب</option>
                        <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>مريض</option>
                        <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>طبيب</option>
                    </select>
                    @error('role')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">كلمة المرور</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="@error('password') border-red-500 @enderror" placeholder="أدخل كلمة مرور قوية">
                    @error('password')
                        <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--gray-700);">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" placeholder="أعد إدخال كلمة المرور">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1rem; margin-top: 0.5rem;">
                    <i class="fa-solid fa-arrow-left"></i> إنشاء الحساب
                </button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--muted);">
                هل لديك حساب بالفعل؟ <a href="{{ route('login') }}" style="color: var(--blue); text-decoration: none; font-weight: 600;">تسجيل الدخول</a>
            </p>
        </div>
    </div>
</div>
@endsection