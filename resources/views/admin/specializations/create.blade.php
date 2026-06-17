@extends('layouts.app')

@section('title', 'إضافة تخصص جديد')

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 class="page-title">إضافة تخصص جديد</h1>
        <p class="page-subtitle">أضف تخصصاً طبياً جديداً ليتمكن الأطباء من الانتساب إليه</p>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <span>بيانات التخصص</span>
            <a href="{{ route('admin.departments') }}" class="btn btn-sm btn-outline">إلغاء والعودة</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.specializations.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">اسم التخصص <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="مثال: جراحة المخ والأعصاب">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">القسم المرتبط <span style="color: #ef4444;">*</span></label>
                    <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>اختر القسم</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">وصف التخصص (اختياري)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="وصف موجز لهذا التخصص الطبي...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2rem; width: 100%; justify-content: center;">
                        <i class="fa-solid fa-plus"></i> إضافة التخصص
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
