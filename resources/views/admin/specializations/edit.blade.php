@extends('layouts.app')

@section('title', 'تعديل التخصص: ' . $specialization->name)

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">تعديل التخصص</h1>
        <p style="color: var(--muted);">تعديل بيانات التخصص الطبي: {{ $specialization->name }}</p>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <span>بيانات التخصص</span>
            <a href="{{ route('admin.departments') }}" class="btn btn-sm btn-outline">إلغاء والعودة</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.specializations.update', $specialization->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">اسم التخصص <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $specialization->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">وصف التخصص (اختياري)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $specialization->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: .85rem 2rem; background: linear-gradient(135deg, #7c3aed, #a855f7);">
                        <i class="fa-solid fa-save"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.departments') }}" class="btn btn-outline" style="padding: .85rem 2rem;">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
