@extends('layouts.app')

@section('title', 'تعديل القسم: ' . $department->name)
@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">تعديل القسم</h1>
        <p style="color: var(--muted);">تعديل بيانات القسم الطبي: {{ $department->name }}</p>
    </div>

    <div class="card" style="max-width: 800px;">
        <div class="card-header">
            <span>بيانات القسم</span>
            <a href="{{ route('admin.departments') }}" class="btn btn-sm btn-outline">إلغاء والعودة</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">اسم القسم <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">اسم المسؤول <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="manager_name" class="form-control @error('manager_name') is-invalid @enderror" value="{{ old('manager_name', $department->manager_name) }}" required>
                        @error('manager_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">رقم جوال القسم <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $department->phone) }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">صورة القسم (اختياري)</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @if($department->image)
                            <div style="margin-top: .5rem;">
                                <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <p style="font-size: .75rem; color: var(--muted);">الصورة الحالية</p>
                            </div>
                        @endif
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">وصف القسم</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $department->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2rem;">
                        <i class="fa-solid fa-save"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.departments') }}" class="btn btn-outline" style="padding: .85rem 2rem;">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
