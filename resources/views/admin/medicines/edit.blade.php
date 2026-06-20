@extends('layouts.app')
@section('title', 'تعديل الدواء')

@push('styles')
<style>
    .admin-container { padding: 2rem 0; max-width: 800px; margin: 0 auto; }
    .page-header { margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 2.5rem;
    }
    
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; }
    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .form-control:focus { border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    
    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
</style>
@endpush

@section('content')
<div class="admin-container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-pen" style="color:#10b981;margin-left:0.5rem"></i> تعديل بيانات دواء: {{ $medicine->name }}</h1>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="form-group">
                <label class="form-label">اسم الدواء</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $medicine->name) }}" required>
                @error('name') <div style="color:#ef4444;font-size:0.85rem;margin-top:0.5rem">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">وصف الدواء / الاستخدامات</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $medicine->description) }}</textarea>
                @error('description') <div style="color:#ef4444;font-size:0.85rem;margin-top:0.5rem">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
                <div class="form-group">
                    <label class="form-label">الكمية المتوفرة (المخزون)</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $medicine->stock) }}" min="0" required>
                    @error('stock') <div style="color:#ef4444;font-size:0.85rem;margin-top:0.5rem">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">حد التنبيه للمخزون المنخفض</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', $medicine->low_stock_threshold) }}" min="0" required>
                    @error('low_stock_threshold') <div style="color:#ef4444;font-size:0.85rem;margin-top:0.5rem">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">السعر (اختياري)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $medicine->price) }}" min="0">
                @error('price') <div style="color:#ef4444;font-size:0.85rem;margin-top:0.5rem">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" style="display:flex;align-items:center;gap:0.75rem;margin-top:1rem">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $medicine->is_active) ? 'checked' : '' }} style="width:20px;height:20px;accent-color:#10b981">
                <label for="is_active" style="font-weight:700;color:#334155;cursor:pointer">الدواء متاح للاستخدام / الوصف</label>
            </div>

            <button type="submit" class="btn-submit" style="margin-top:2rem">
                <i class="fa-solid fa-save"></i> حفظ التعديلات
            </button>
            <div style="text-align:center;margin-top:1rem">
                <a href="{{ route('admin.medicines.index') }}" style="color:#64748b;text-decoration:none;font-weight:600">إلغاء والعودة</a>
            </div>
        </form>
    </div>
</div>
@endsection
