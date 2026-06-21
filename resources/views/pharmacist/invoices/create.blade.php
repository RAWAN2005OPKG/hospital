@extends('layouts.app')
@section('title', 'إنشاء فاتورة')

@push('styles')
<style>
    .invoices-container { padding: 2rem 0; }
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
    .form-control:focus { border-color: #8b5cf6; background: #fff; box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1); }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block; }

    .btn-submit {
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(139, 92, 246, 0.3); }

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

    .prescription-card {
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .prescription-card:hover { border-color: #8b5cf6; background: #f1f5f9; }
    .prescription-card.selected { border-color: #8b5cf6; background: #ede9fe; }
</style>
@endpush

@section('content')
<div class="invoices-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-plus-circle" style="color:#8b5cf6;margin-left:0.5rem"></i> إنشاء فاتورة</h1>
        <a href="{{ route('pharmacist.invoices.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-right"></i> عودة
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('pharmacist.invoices.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">اختر الوصفة *</label>
                @if($prescriptions->count() > 0)
                    @foreach($prescriptions as $prescription)
                        <div class="prescription-card" onclick="selectPrescription({{ $prescription->id }}, this)">
                            <div style="font-weight:700;color:#1e293b;margin-bottom:0.5rem">وصفة #{{ $prescription->id }} - {{ $prescription->patient->user->name }}</div>
                            <div style="font-size:0.9rem;color:#64748b;margin-bottom:0.5rem">الطبيب: {{ $prescription->doctor->user->name }}</div>
                            <div style="font-size:0.9rem;color:#64748b;margin-bottom:0.5rem">التاريخ: {{ $prescription->created_at->format('Y-m-d') }}</div>
                            <div style="font-size:0.9rem;color:#64748b">الأدوية: {{ $prescription->medicines->pluck('name')->join(', ') }}</div>
                            <input type="radio" name="prescription_id" value="{{ $prescription->id }}" required style="margin-top:0.5rem">
                        </div>
                    @endforeach
                @else
                    <div style="padding: 2rem; text-align: center; color: #64748b; font-weight: 600;">
                        لا توجد وصفات قيد الانتظار
                    </div>
                @endif
                @error('prescription_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">الخصم</label>
                    <input type="number" class="form-control" name="discount" min="0" step="0.01" placeholder="0.00">
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الضريبة</label>
                    <input type="number" class="form-control" name="tax" min="0" step="0.01" placeholder="0.00">
                    @error('tax')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">طريقة الدفع</label>
                    <select class="form-control" name="payment_method">
                        <option value="">اختر طريقة الدفع</option>
                        <option value="cash">نقداً</option>
                        <option value="card">بطاقة</option>
                        <option value="insurance">تأمين</option>
                    </select>
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ملاحظات</label>
                <textarea class="form-control" name="notes" rows="3" placeholder="أي ملاحظات إضافية"></textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save" style="margin-left:0.5rem"></i> إنشاء الفاتورة
                </button>
                <a href="{{ route('pharmacist.invoices.index') }}" class="btn-back">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function selectPrescription(id, element) {
    document.querySelectorAll('.prescription-card').forEach(card => {
        card.classList.remove('selected');
    });
    element.classList.add('selected');
    element.querySelector('input[type="radio"]').checked = true;
}
</script>
@endpush
@endsection
