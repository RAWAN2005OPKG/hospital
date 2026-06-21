@extends('layouts.app')
@section('title', 'تعديل الفاتورة')

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

    .items-table {
        width: 100%;
        background: #f8fafc;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .items-table th {
        background: #e2e8f0;
        padding: 1rem;
        text-align: right;
        font-weight: 700;
        color: #475569;
        font-size: 0.9rem;
    }
    .items-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }
</style>
@endpush

@section('content')
<div class="invoices-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-edit" style="color:#8b5cf6;margin-left:0.5rem"></i> تعديل الفاتورة #{{ $invoice->id }}</h1>
        <a href="{{ route('pharmacist.invoices.show', $invoice->id) }}" class="btn-back">
            <i class="fa-solid fa-arrow-right"></i> عودة
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('pharmacist.invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="items-table">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>الدواء</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الخصم</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $item->medicine->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->discount, 2) }}</td>
                            <td>{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">الخصم</label>
                    <input type="number" class="form-control" name="discount" min="0" step="0.01" value="{{ $invoice->discount }}">
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الضريبة</label>
                    <input type="number" class="form-control" name="tax" min="0" step="0.01" value="{{ $invoice->tax }}">
                    @error('tax')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">طريقة الدفع</label>
                    <select class="form-control" name="payment_method">
                        <option value="">اختر طريقة الدفع</option>
                        <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>نقداً</option>
                        <option value="card" {{ $invoice->payment_method === 'card' ? 'selected' : '' }}>بطاقة</option>
                        <option value="insurance" {{ $invoice->payment_method === 'insurance' ? 'selected' : '' }}>تأمين</option>
                    </select>
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ملاحظات</label>
                <textarea class="form-control" name="notes" rows="3">{{ $invoice->notes }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save" style="margin-left:0.5rem"></i> حفظ التغييرات
                </button>
                <a href="{{ route('pharmacist.invoices.show', $invoice->id) }}" class="btn-back">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
