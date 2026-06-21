@extends('layouts.app')
@section('title', 'تعديل الدواء')

@push('styles')
<style>
    .inventory-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .form-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: #374151; font-size: 0.9rem; }
    .form-control {
        width: 100%;
        padding: 0.85rem 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        outline: none;
        transition: all 0.3s;
        font-size: 0.95rem;
        background: #f9fafb;
        font-family: 'Cairo', sans-serif;
    }
    .form-control:focus { border-color: #10b981; background: #fff; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block; }

    .btn-submit {
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }

    .btn-back {
        padding: 1rem 2rem;
        background: #e5e7eb;
        color: #374151;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-back:hover { background: #d1d5db; }
</style>
@endpush

@section('content')
<div class="inventory-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-edit" style="color:#10b981;margin-left:0.5rem"></i> تعديل الدواء: {{ $medicine->name }}</h1>
        <a href="{{ route('pharmacist.inventory.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-right"></i> عودة
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('pharmacist.inventory.update', $medicine->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">اسم الدواء *</label>
                <input type="text" class="form-control" name="name" required value="{{ $medicine->name }}" autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">الوصف</label>
                <textarea class="form-control" name="description" rows="3">{{ $medicine->description }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">الكمية في المخزون *</label>
                    <input type="number" class="form-control" name="stock" required min="0" value="{{ $medicine->stock }}">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الكمية *</label>
                    <input type="number" class="form-control" name="quantity" required min="0" step="0.01" value="{{ $medicine->quantity }}">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الحد الأدنى للمخزون *</label>
                    <input type="number" class="form-control" name="low_stock_threshold" required min="0" value="{{ $medicine->low_stock_threshold }}">
                    @error('low_stock_threshold')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">السعر *</label>
                    <input type="number" class="form-control" name="price" required min="0" step="0.01" value="{{ $medicine->price }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" class="form-control" name="expiration_date" value="{{ $medicine->expiration_date ? $medicine->expiration_date->format('Y-m-d') : '' }}">
                    @error('expiration_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الشركة المصنعة</label>
                    <input type="text" class="form-control" name="manufacturer" value="{{ $medicine->manufacturer }}">
                    @error('manufacturer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">رقم الدفعة</label>
                <input type="text" class="form-control" name="batch_number" value="{{ $medicine->batch_number }}">
                @error('batch_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <input type="checkbox" name="is_active" value="1" {{ $medicine->is_active ? 'checked' : '' }}> نشط
                </label>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save" style="margin-left:0.5rem"></i> حفظ التغييرات
                </button>
                <a href="{{ route('pharmacist.inventory.index') }}" class="btn-back">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
