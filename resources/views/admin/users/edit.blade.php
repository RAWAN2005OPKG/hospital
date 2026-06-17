@extends('layouts.dashboard')

@section('title', 'تعديل مستخدم')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">تعديل المستخدم</h1>
        <p class="page-subtitle">تحديث بيانات الحساب: {{ $user->name }}</p>
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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label class="form-label">الاسم <span style="color: var(--danger);">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني <span style="color: var(--danger);">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label">كلمة المرور (اتركها فارغة إذا ما بدك تغيرها)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label">الدور <span style="color: var(--danger);">*</span></label>
                @php $roleValue = is_object($user->role) ? $user->role->value : (string)$user->role; @endphp
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->value }}" {{ old('role', $roleValue) === $role->value ? 'selected' : '' }}>
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
                @if($user->avatar)
                    <div style="margin-top: .75rem; display:flex; align-items:center; gap: .75rem;">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 56px; height: 56px; border-radius: 14px; object-fit: cover;">
                        <span style="color: var(--gray-500); font-weight: 700;">الصورة الحالية</span>
                    </div>
                @endif
            </div>
        </div>

        <div style="display:flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                حفظ التغييرات
            </button>
            <a href="{{ route('admin.users') }}" class="btn" style="background: var(--gray-100); color: var(--gray-700);">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection

