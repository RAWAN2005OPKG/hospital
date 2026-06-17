@extends('layouts.app')

@section('title', 'تعديل الملف الشخصي')

@section('content')
<div class="container section">
    <div class="mb-8" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">تعديل الملف الشخصي</h1>
            <p class="page-subtitle">تحديث بياناتك الشخصية وكلمة المرور</p>
        </div>
        <a href="{{ route('profile.show') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-right"></i> رجوع
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header">
            <span>بيانات الحساب</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Avatar Section -->
                <div style="text-align: center; margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--gray-100);">
                    <div style="width: 120px; height: 120px; margin: 0 auto 1.5rem; position: relative;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" id="avatar-preview" style="width: 100%; height: 100%; border-radius: 25px; object-fit: cover; border: 4px solid var(--gray-50); box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                        @else
                            <div id="avatar-placeholder" style="width: 100%; height: 100%; border-radius: 25px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="form-group" style="max-width: 300px; margin: 0 auto;">
                        <label class="form-label">تغيير الصورة الشخصية</label>
                        <input type="file" name="avatar" id="avatar-input" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">الاسم الكامل <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني <span style="color: #ef4444;">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($user->isPatient())
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">الجنس</label>
                        <select name="gender" class="form-control">
                            <option value="">اختر</option>
                            <option value="male" {{ old('gender', $user->patient->gender ?? '') == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender', $user->patient->gender ?? '') == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', ($user->patient && $user->patient->birth_date) ? (\Illuminate\Support\Carbon::parse($user->patient->birth_date)->format('Y-m-d')) : '') }}">
                    </div>
                </div>
                @endif

                @if($user->isDoctor())
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">سنوات الخبرة</label>
                        <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $user->doctor->experience_years ?? 0) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">رقم الترخيص</label>
                        <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $user->doctor->license_number ?? '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">نبذة مهنية</label>
                    <textarea name="bio" rows="4" class="form-control">{{ old('bio', $user->doctor->bio ?? '') }}</textarea>
                </div>
                @endif

                <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--gray-100);">
                    <h4 style="font-weight: 800; color: var(--gray-900); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-lock" style="color: var(--primary);"></i> تغيير كلمة المرور (اختياري)
                    </h4>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">كلمة المرور الحالية</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2.5rem;">
                        <i class="fa-solid fa-save"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline" style="padding: .85rem 2.5rem;">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview image before upload
    document.getElementById('avatar-input').onchange = evt => {
        const [file] = evt.target.files
        if (file) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            if (preview) {
                preview.src = URL.createObjectURL(file)
            } else if (placeholder) {
                placeholder.innerHTML = `<img src="${URL.createObjectURL(file)}" style="width: 100%; height: 100%; border-radius: 25px; object-fit: cover;">`;
            }
        }
    }
</script>
@endsection
