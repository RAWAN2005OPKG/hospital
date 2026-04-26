@extends('layouts.app')

@section('title', 'إضافة تخصص جديد')

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">إضافة تخصص جديد</h1>
        <p style="color: var(--muted);">أضف تخصصاً طبياً جديداً ليتمكن الأطباء من الانتساب إليه</p>
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
                    <label class="form-label">وصف التخصص (اختياري)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="وصف موجز لهذا التخصص الطبي...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2rem; background: linear-gradient(135deg, #7c3aed, #a855f7);">
                        <i class="fa-solid fa-plus"></i> إضافة التخصص
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
