@extends('layouts.app')
@section('title', 'إضافة دواء جديد')

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
        <h1 class="page-title"><i class="fa-solid fa-plus-circle" style="color:#10b981;margin-left:0.5rem"></i> إضافة دواء جديد</h1>
        <a href="{{ route('pharmacist.inventory.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-right"></i> عودة
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('pharmacist.inventory.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">اسم الدواء *</label>
                <input type="text" class="form-control" name="name" required autofocus placeholder="أدخل اسم الدواء">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" name="name_ar" placeholder="الاسم بالعربية">
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الاسم بالإنجليزية</label>
                    <input type="text" class="form-control" name="name_en" placeholder="English Name">
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">صورة الدواء</label>
                <input type="file" class="form-control" name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">الوصف</label>
                <textarea class="form-control" name="description" rows="3" placeholder="وصف الدواء (اختياري)"></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">الكمية في المخزون *</label>
                    <input type="number" class="form-control" name="stock" required min="0" placeholder="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الكمية *</label>
                    <input type="number" class="form-control" name="quantity" required min="0" step="0.01" placeholder="0">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الكمية المحجوزة</label>
                    <input type="number" class="form-control" name="reserved_quantity" min="0" step="0.01" placeholder="0">
                    @error('reserved_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الكمية المتاحة</label>
                    <input type="number" class="form-control" name="available_quantity" min="0" step="0.01" placeholder="0">
                    @error('available_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الحد الأدنى للمخزون *</label>
                    <input type="number" class="form-control" name="low_stock_threshold" required min="0" placeholder="10">
                    @error('low_stock_threshold')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">السعر *</label>
                    <input type="number" class="form-control" name="price" required min="0" step="0.01" placeholder="0.00">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">تاريخ الإنتاج</label>
                    <input type="date" class="form-control" name="production_date">
                    @error('production_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" class="form-control" name="expiration_date">
                    @error('expiration_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الشركة المصنعة</label>
                    <input type="text" class="form-control" name="manufacturer" placeholder="اسم الشركة">
                    @error('manufacturer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">رقم الدفعة</label>
                <input type="text" class="form-control" name="batch_number" placeholder="رقم الدفعة">
                @error('batch_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">حالة التوفر</label>
                <select class="form-control" name="availability_status">
                    <option value="available">متوفر</option>
                    <option value="unavailable">غير متوفر</option>
                    <option value="discontinued">متوقف</option>
                </select>
                @error('availability_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <input type="checkbox" name="is_active" value="1" checked> نشط
                </label>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save" style="margin-left:0.5rem"></i> حفظ الدواء
                </button>
                <a href="{{ route('pharmacist.inventory.index') }}" class="btn-back">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
