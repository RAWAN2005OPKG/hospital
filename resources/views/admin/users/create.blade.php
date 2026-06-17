@extends('layouts.app')

@section('title', 'إضافة مستخدم')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إضافة مستخدم جديد</h1>
        <p class="page-subtitle">إنشاء حساب جديد مع تحديد الدور وإضافة صورة شخصية (اختياري)</p>
    </div>
    <a href="{{ route('admin.users') }}" class="btn btn-light">
        <i class="fa-solid fa-arrow-right"></i>
        رجوع للقائمة
    </a>
</div>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-user-plus" style="color: var(--primary); margin-left: 0.5rem;"></i> بيانات الحساب الجديد</h3>
    </div>

    <div class="card-body" style="padding: 1rem 0;">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">الاسم الكامل <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="أدخل الاسم الثلاثي..." required>
                @error('name')<div class="badge badge-danger" style="margin-top: 0.5rem; font-size: 0.75rem;">{{ $message }}</div>@enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني <span style="color: var(--danger);">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="example@hospital.com" required>
                    @error('email')<div class="badge badge-danger" style="margin-top: 0.5rem; font-size: 0.75rem;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="0590000000">
                    @error('phone')<div class="badge badge-danger" style="margin-top: 0.5rem; font-size: 0.75rem;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">كلمة المرور <span style="color: var(--danger);">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                    @error('password')<div class="badge badge-danger" style="margin-top: 0.5rem; font-size: 0.75rem;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">تأكيد كلمة المرور <span style="color: var(--danger);">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">الدور (الصلاحية) <span style="color: var(--danger);">*</span></label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>اختر الدور المناسب...</option>
                        @foreach($roles as $role)
                            <option value="{{ is_object($role) ? $role->value : $role }}" {{ old('role') == (is_object($role) ? $role->value : $role) ? 'selected' : '' }}>
                                {{ is_object($role) ? $role->name : $role }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<div class="badge badge-danger" style="margin-top: 0.5rem; font-size: 0.75rem;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">الصورة الشخصية (اختياري)</label>
                    <div style="background: var(--bg-body); padding: 0.5rem 1rem; border-radius: 10px; border: 1px dashed var(--border-color);">
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*" style="border: none; background: transparent;">
                    </div>
                    @error('avatar')<div class="badge badge-danger" style="margin-top: 0.5rem; font-size: 0.75rem;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="margin-top: 3rem; display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                <a href="{{ route('admin.users') }}" class="btn btn-light" style="color: var(--text-muted);">إلغاء العملية</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 3rem;">
                    <i class="fa-solid fa-save"></i> حفظ المستخدم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
