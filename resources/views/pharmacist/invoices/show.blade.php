@extends('layouts.app')
@section('title', 'تفاصيل الفاتورة')

@push('styles')
<style>
    .invoices-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .invoice-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .invoice-number { font-size: 1.5rem; font-weight: 900; color: #8b5cf6; }
    .invoice-date { font-size: 0.95rem; color: #64748b; font-weight: 600; }

    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-block;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-paid { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .detail-section { margin-bottom: 2rem; }
    .detail-section h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .detail-item { margin-bottom: 1rem; }
    .detail-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 0.25rem;
    }
    .detail-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .items-table {
        width: 100%;
        background: #f8fafc;
        border-radius: 12px;
        overflow: hidden;
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

    .totals-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
    }
    .total-row:last-child {
        border-bottom: none;
        font-size: 1.2rem;
        font-weight: 900;
        color: #8b5cf6;
        margin-top: 0.5rem;
        padding-top: 1rem;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        margin-left: 0.75rem;
    }
    .btn-edit { background: #fef3c7; color: #92400e; }
    .btn-edit:hover { background: #92400e; color: #fff; }
    .btn-pay { background: #dcfce7; color: #166534; }
    .btn-pay:hover { background: #166534; color: #fff; }
    .btn-cancel { background: #fee2e2; color: #991b1b; }
    .btn-cancel:hover { background: #991b1b; color: #fff; }
    .btn-back { background: #e5e7eb; color: #374151; }
    .btn-back:hover { background: #d1d5db; }
</style>
@endpush

@section('content')
<div class="invoices-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-eye" style="color:#8b5cf6;margin-left:0.5rem"></i> فاتورة #{{ $invoice->id }}</h1>
        <div>
            @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                <a href="{{ route('pharmacist.invoices.edit', $invoice->id) }}" class="btn-action btn-edit">
                    <i class="fa-solid fa-edit"></i> تعديل
                </a>
                <form action="{{ route('pharmacist.invoices.pay', $invoice->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-action btn-pay" onclick="return confirm('هل أنت متأكد من دفع هذه الفاتورة؟')">
                        <i class="fa-solid fa-money-bill"></i> دفع
                    </button>
                </form>
                <form action="{{ route('pharmacist.invoices.cancel', $invoice->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-action btn-cancel" onclick="return confirm('هل أنت متأكد من إلغاء هذه الفاتورة؟')">
                        <i class="fa-solid fa-times"></i> إلغاء
                    </button>
                </form>
            @endif
            <a href="{{ route('pharmacist.invoices.index') }}" class="btn-action btn-back">
                <i class="fa-solid fa-arrow-right"></i> عودة
            </a>
        </div>
    </div>

    <div class="invoice-card">
        <div class="invoice-header">
            <div>
                <div class="invoice-number">فاتورة #{{ $invoice->id }}</div>
                <div class="invoice-date">التاريخ: {{ $invoice->created_at->format('Y-m-d H:i') }}</div>
            </div>
            <div>
                @switch($invoice->status)
                    @case('pending')
                        <span class="status-badge status-pending">قيد الانتظار</span>
                        @break
                    @case('paid')
                        <span class="status-badge status-paid">مدفوعة</span>
                        @break
                    @case('cancelled')
                        <span class="status-badge status-cancelled">ملغاة</span>
                        @break
                @endswitch
            </div>
        </div>

        <div class="detail-section">
            <h3>معلومات الفاتورة</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">المريض</div>
                    <div class="detail-value">{{ $invoice->patient->name ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">الصيدلي</div>
                    <div class="detail-value">{{ $invoice->pharmacist->name ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">رقم الوصفة</div>
                    <div class="detail-value">{{ $invoice->prescription_id ? '#'.$invoice->prescription_id : '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">طريقة الدفع</div>
                    <div class="detail-value">
                        @switch($invoice->payment_method)
                            @case('cash') نقداً @break
                            @case('card') بطاقة @break
                            @case('insurance') تأمين @break
                            @default - @endswitch
                    </div>
                </div>
                @if($invoice->paid_at)
                <div class="detail-item">
                    <div class="detail-label">تاريخ الدفع</div>
                    <div class="detail-value">{{ $invoice->paid_at->format('Y-m-d H:i') }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="detail-section">
            <h3>الأدوية</h3>
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
        </div>

        <div class="totals-section">
            <div class="total-row">
                <span>المجموع الفرعي</span>
                <span>{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span>الخصم</span>
                <span>-{{ number_format($invoice->discount, 2) }}</span>
            </div>
            <div class="total-row">
                <span>الضريبة</span>
                <span>+{{ number_format($invoice->tax, 2) }}</span>
            </div>
            <div class="total-row">
                <span>الإجمالي</span>
                <span>{{ number_format($invoice->total_amount, 2) }}</span>
            </div>
        </div>

        @if($invoice->notes)
        <div class="detail-section">
            <h3>ملاحظات</h3>
            <div class="detail-value">{{ $invoice->notes }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
