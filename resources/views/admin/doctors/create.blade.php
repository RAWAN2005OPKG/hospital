@extends('layouts.app')

@section('title', 'إضافة طبيب جديد')

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">إضافة طبيب جديد</h1>
        <p style="color: var(--muted);">قم بتعبئة بيانات الطبيب لإنشاء حساب جديد له في النظام</p>
    </div>

    <form action="{{ route('admin.doctors.store') }}" method="POST">
        @csrf
        <div class="grid-2" style="grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start;">
            <!-- User Information Card -->
            <div class="card">
                <div class="card-header">بيانات الحساب الشخصية</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">الاسم الكامل <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="د. أحمد محمد">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">البريد الإلكتروني <span style="color: #ef4444;">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="doctor@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">رقم الهاتف <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="05xxxxxxxx">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم الترخيص <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" value="{{ old('license_number') }}" required placeholder="MED-12345">
                            @error('license_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">كلمة المرور <span style="color: #ef4444;">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">تأكيد كلمة المرور <span style="color: #ef4444;">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information Card -->
            <div class="card">
                <div class="card-header">البيانات المهنية والمالية</div>
                <div class="card-body">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">القسم <span style="color: #ef4444;">*</span></label>
                            <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                <option value="">اختر القسم</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">التخصص <span style="color: #ef4444;">*</span></label>
                            <select name="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror" required>
                                <option value="">اختر التخصص</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}" {{ old('specialization_id') == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                                @endforeach
                            </select>
                            @error('specialization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">سنوات الخبرة <span style="color: #ef4444;">*</span></label>
                            <input type="number" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years', 0) }}" required>
                            @error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رسوم الاستشارة <span style="color: #ef4444;">*</span></label>
                            <input type="number" step="0.01" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" value="{{ old('consultation_fee') }}" required placeholder="100.00">
                            @error('consultation_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">السيرة الذاتية / نبذة</label>
                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4" placeholder="اكتب نبذة عن الطبيب وخبراته...">{{ old('bio') }}</textarea>
                        @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.doctors') }}" class="btn btn-outline" style="padding: .85rem 2.5rem;">إلغاء</a>
            <button type="submit" class="btn btn-primary" style="padding: .85rem 3rem;">
                <i class="fa-solid fa-user-plus"></i> حفظ بيانات الطبيب
            </button>
        </div>
    </form>
</div>
@endsection
