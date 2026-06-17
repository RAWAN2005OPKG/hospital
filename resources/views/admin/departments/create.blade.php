@extends('layouts.app')

@section('title', 'إضافة قسم جديد')

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 class="page-title">إضافة قسم جديد</h1>
        <p class="page-subtitle">قم بتعبئة البيانات أدناه لإنشاء قسم طبي جديد في المستشفى</p>
    </div>

    <div class="card" style="max-width: 800px;">
        <div class="card-header">
            <span>بيانات القسم</span>
            <a href="{{ route('admin.departments') }}" class="btn btn-sm btn-outline">إلغاء والعودة</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.departments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">اسم القسم <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="مثال: قسم الباطنية">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">اسم المسؤول <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="manager_name" class="form-control @error('manager_name') is-invalid @enderror" value="{{ old('manager_name') }}" required placeholder="اسم الطبيب المسؤول">
                        @error('manager_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">رقم جوال القسم <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="05xxxxxxxx">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">صورة القسم (اختياري)</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">وصف القسم</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="اكتب وصفاً مختصراً لمهام القسم...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2rem;">
                        <i class="fa-solid fa-plus"></i> إنشاء القسم
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
