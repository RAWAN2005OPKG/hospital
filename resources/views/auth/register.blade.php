@extends('layouts.app')
@section('title','إنشاء حساب')

@push('styles')
<style>
.auth-wrap{min-height:calc(100vh - var(--nav-h));display:grid;grid-template-columns:1fr 1.1fr}
.auth-left{background:linear-gradient(135deg,var(--blue) 0%,var(--cyan) 100%);padding:3rem;display:flex;flex-direction:column;justify-content:center;position:relative;overflow:hidden}
.auth-left::before{content:'';position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.08)}
.auth-right{background:var(--bg);display:flex;align-items:center;justify-content:center;padding:2.5rem 2rem;overflow-y:auto}
.auth-card{background:#fff;border-radius:20px;padding:2.25rem;box-shadow:0 20px 60px rgba(37,99,235,.1);border:1px solid rgba(37,99,235,.07);width:100%;max-width:480px}

/* role cards */
.role-pick{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:2rem}
.role-pick label{border:2px solid var(--border);border-radius:16px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .3s;background:#fff}
.role-pick label:has(input:checked){border-color:var(--blue);background:var(--blue-lt);box-shadow:0 8px 20px rgba(37,99,235,.15)}
.role-pick input{display:none}
.role-pick i{font-size:2.5rem;color:var(--muted);margin-bottom:.8rem;display:block;transition:color .2s}
.role-pick label:has(input:checked) i{color:var(--blue)}
.role-pick span{font-size:.95rem;font-weight:700;color:var(--muted);transition:color .2s;display:block;margin-bottom:.5rem}
.role-pick label:has(input:checked) span{color:var(--blue)}
.role-pick small{font-size:.8rem;color:var(--gray-500);display:block}

.input-wrap{position:relative}
.input-wrap .ico{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.82rem;pointer-events:none}
.input-wrap .form-control{padding-right:2.5rem}

@media(max-width:768px){.auth-wrap{grid-template-columns:1fr}.auth-left{display:none}}
</style>
@endpush

@section('content')
<div class="auth-wrap">

    {{-- LEFT --}}
    <div class="auth-left">
        <div style="position:relative;z-index:1;color:#fff">
            <div style="width:60px;height:60px;border-radius:16px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1.7rem;margin-bottom:1.75rem">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <h2 style="font-size:1.9rem;font-weight:900;margin-bottom:.75rem;line-height:1.3">انضم إلى<br>مجتمع ProHealth</h2>
            <p style="opacity:.9;font-size:.95rem;line-height:1.8;margin-bottom:2rem">سجّل حسابك الآن واستمتع بتجربة صحية متكاملة — سواء كنت مريضاً أو طبيباً.</p>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                @foreach([
                    ['fa-user','مريض','احجز مواعيدك وتابع سجلاتك'],
                    ['fa-user-doctor','دكتور','أدر مرضاك ومواعيدك بسهولة'],
                ] as [$ico,$title,$desc])
                <div style="background:rgba(255,255,255,.12);border-radius:12px;padding:1rem;backdrop-filter:blur(4px)">
                    <i class="fa-solid {{ $ico }}" style="font-size:1.3rem;margin-bottom:.5rem;display:block"></i>
                    <div style="font-weight:800;font-size:.9rem;margin-bottom:.2rem">{{ $title }}</div>
                    <div style="font-size:.78rem;opacity:.85">{{ $desc }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="auth-right">
    <div class="auth-card">
        <div style="text-align:center;margin-bottom:1.75rem">
            <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:.25rem">إنشاء حساب جديد</h1>
            <p style="color:var(--muted);font-size:.87rem">اختر نوع حسابك وأكمل بياناتك</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- ROLE SELECTION --}}
        <div class="form-group">
            <label class="form-label">نوع الحساب <span style="color:#ef4444">*</span></label>
            <div class="role-pick">
                <label style="cursor:pointer">
                    <input type="radio" name="role" value="patient" {{ old('role','patient')==='patient'?'checked':'' }} required>
                    <i class="fa-solid fa-user"></i>
                    <span>مريض</span>
                    <small>احجز مواعيدك وتابع سجلاتك</small>
                </label>
                <label style="cursor:pointer">
                    <input type="radio" name="role" value="doctor" {{ old('role')==='doctor'?'checked':'' }} required>
                    <i class="fa-solid fa-user-doctor"></i>
                    <span>دكتور</span>
                    <small>أدر مرضاك ومواعيدك</small>
                </label>
            </div>
            @error('role')<div class="invalid-feedback" style="display:block;margin-top:-.75rem;margin-bottom:.75rem">{{ $message }}</div>@enderror
        </div>

        {{-- NAME --}}
        <div class="form-group">
            <label class="form-label">الاسم الكامل <span style="color:#ef4444">*</span></label>
            <div class="input-wrap">
                <i class="ico fa-solid fa-user"></i>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required placeholder="محمد أحمد">
            </div>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- EMAIL + PHONE --}}
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني <span style="color:#ef4444">*</span></label>
                <div class="input-wrap">
                    <i class="ico fa-solid fa-envelope"></i>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required placeholder="example@email.com">
                </div>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">رقم الهاتف <span style="color:#ef4444">*</span></label>
                <div class="input-wrap">
                    <i class="ico fa-solid fa-phone"></i>
                    <input type="text" name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}" required placeholder="05xxxxxxxx">
                </div>
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- PASSWORDS --}}
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">كلمة المرور <span style="color:#ef4444">*</span></label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required placeholder="8 أحرف على الأقل">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور <span style="color:#ef4444">*</span></label>
                <input type="password" name="password_confirmation"
                    class="form-control" required placeholder="أعد الكتابة">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.85rem;font-size:.95rem;margin-top:.25rem">
            <i class="fa-solid fa-user-plus"></i> إنشاء الحساب
        </button>
        </form>

        <p style="text-align:center;margin-top:1.5rem;font-size:.87rem;color:var(--muted)">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}" style="color:var(--blue);font-weight:800">سجّل دخولك</a>
        </p>
    </div>
    </div>

</div>
@endsection
