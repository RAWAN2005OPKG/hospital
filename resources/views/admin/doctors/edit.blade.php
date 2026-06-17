@extends('layouts.app')

@section('title', 'تعديل بيانات الطبيب: ' . $doctor->user->name)

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 class="page-title">تعديل بيانات الطبيب</h1>
        <p class="page-subtitle">تحديث معلومات الطبيب: {{ $doctor->user->name }}</p>
    </div>

    <div class="card" style="max-width: 900px;">
        <div class="card-header">
            <span>بيانات الطبيب</span>
            <a href="{{ route('admin.doctors') }}" class="btn btn-sm btn-outline">إلغاء والعودة</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="form-label">الاسم الكامل <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $doctor->user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">البريد الإلكتروني <span style="color: #ef4444;">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->user->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">كلمة المرور (اتركها فارغة إذا لم ترد التغيير)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">القسم الطبي <span style="color: #ef4444;">*</span></label>
                        <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">التخصص <span style="color: #ef4444;">*</span></label>
                        <select name="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror" required>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec->id }}" {{ old('specialization_id', $doctor->specialization_id) == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                            @endforeach
                        </select>
                        @error('specialization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">رقم الترخيص الطبي <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" value="{{ old('license_number', $doctor->license_number) }}" required>
                        @error('license_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">سنوات الخبرة <span style="color: #ef4444;">*</span></label>
                        <input type="number" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years', $doctor->experience_years) }}" required min="0">
                        @error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">نبذة عن الطبيب</label>
                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', $doctor->bio) }}</textarea>
                    @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2rem;">
                        <i class="fa-solid fa-save"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.doctors') }}" class="btn btn-outline" style="padding: .85rem 2rem;">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
