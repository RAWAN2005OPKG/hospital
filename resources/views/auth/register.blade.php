@extends('layouts.app')
@section('title','إنشاء حساب')

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
    content:''; position:absolute; bottom:-150px; left:-150px;
    width:400px; height:400px; border-radius:50%;
    background:radial-gradient(circle,rgba(6,182,212,.08),transparent 70%);
}
.auth-card {
    width:100%; max-width:520px; position:relative; z-index:1;
    background:#fff; border-radius:24px; padding:2.5rem;
    box-shadow:0 20px 60px rgba(37,99,235,.12);
    border:1px solid rgba(37,99,235,.08);
}
.auth-logo {
    width:64px; height:64px; border-radius:18px;
    background:linear-gradient(135deg,var(--blue),var(--cyan));
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 1rem; font-size:1.7rem; color:#fff;
    box-shadow:0 8px 24px rgba(37,99,235,.3);
}
.role-cards { display:grid; grid-template-columns:repeat(2,1fr); gap:.75rem; margin-bottom:1.5rem; }\n.role-card {
    border:2px solid var(--border); border-radius:12px; padding:1rem .75rem;
    text-align:center; cursor:pointer; transition:all .2s;
}
.role-card:has(input:checked) { border-color:var(--blue); background:var(--blue-lt); }
.role-card input { display:none; }
.role-card i { font-size:1.4rem; color:var(--muted); margin-bottom:.4rem; display:block; transition:color .2s; }
.role-card:has(input:checked) i { color:var(--blue); }
.role-card span { font-size:.83rem; font-weight:700; color:var(--muted); transition:color .2s; display:block; }
.role-card:has(input:checked) span { color:var(--blue); }
</style>
@endpush

@section('content')
<div class="auth-page">
<div class="auth-card">
    <div class="auth-logo"><i class="fa-solid fa-user-plus"></i></div>
    <div style="text-align:center;margin-bottom:2rem">
        <h1 style="font-size:1.6rem;font-weight:900">إنشاء حساب جديد</h1>
        <p style="color:var(--muted);margin-top:.3rem">انضم إلينا واحجز مواعيدك بسهولة</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Role Selection --}}
    <div class="form-group">
        <label class="form-label">نوع الحساب</label>
        <div class="role-cards">
            <label class="role-card">
                <input type="radio" name="role" value="patient" {{ old('role','patient')=='patient'?'checked':'' }}>
                <i class="fa-solid fa-user"></i>
                <span>مريض</span>
            </label>
            <label class="role-card">
                <input type="radio" name="role" value="doctor" {{ old('role')=='doctor'?'checked':'' }}>
                <i class="fa-solid fa-user-doctor"></i>
                <span>دكتور</span>
            </label>

        </div>
        @error('role')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label class="form-label">الاسم الكامل <span style="color:#ef4444">*</span></label>
        <div style="position:relative">
            <i class="fa-solid fa-user" style="position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.85rem"></i>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                style="padding-right:2.5rem" value="{{ old('name') }}" required placeholder="محمد أحمد">
        </div>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
        <div class="form-group">
            <label class="form-label">البريد الإلكتروني <span style="color:#ef4444">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required placeholder="example@email.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">رقم الهاتف <span style="color:#ef4444">*</span></label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone') }}" required placeholder="05xxxxxxxx">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
        <div class="form-group">
            <label class="form-label">كلمة المرور <span style="color:#ef4444">*</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                required placeholder="8 أحرف على الأقل">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">تأكيد كلمة المرور <span style="color:#ef4444">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" required placeholder="أعد كتابتها">
        </div>
    </div>

    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.85rem;font-size:.95rem;margin-top:.5rem">
        <i class="fa-solid fa-user-plus"></i> إنشاء الحساب
    </button>
    </form>

    <p style="text-align:center;margin-top:1.5rem;font-size:.9rem;color:var(--muted)">
        لديك حساب؟ <a href="{{ route('login') }}" style="color:var(--blue);font-weight:800">سجّل دخولك</a>
    </p>
</div>
</div>
@endsection