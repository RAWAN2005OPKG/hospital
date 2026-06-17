@extends('layouts.dashboard')

@section('title', 'إضافة مستخدم')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إضافة مستخدم جديد</h1>
        <p class="page-subtitle">إنشاء حساب جديد مع تحديد الدور وإضافة صورة شخصية (اختياري)</p>
    </div>
    <a href="{{ route('admin.users') }}" class="btn" style="background: var(--gray-100); color: var(--gray-700);">
        <i class="fa-solid fa-arrow-right"></i>
        رجوع
    </a>
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-header">
        <h3 class="card-title">بيانات المستخدم</h3>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">الاسم <span style="color: var(--danger);">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني <span style="color: var(--danger);">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label">كلمة المرور <span style="color: var(--danger);">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور <span style="color: var(--danger);">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label">الدور <span style="color: var(--danger);">*</span></label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>اختر الدور</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->value }}" {{ old('role') === $role->value ? 'selected' : '' }}>
                            {{ $role->value }}
                        </option>
                    @endforeach
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">الصورة الشخصية (اختياري)</label>
                <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                حفظ
            </button>
            <a href="{{ route('admin.users') }}" class="btn" style="background: var(--gray-100); color: var(--gray-700);">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection

