@extends('layouts.app')
@section('title', 'الفواتير')

@push('styles')
<style>
    .invoices-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .invoices-table {
        width: 100%;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .invoices-table th {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        text-align: right;
        font-weight: 700;
        color: #475569;
        font-size: 0.95rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .invoices-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .invoices-table tr:hover td { background: #f8fafc; }

    .status-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-paid { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        margin-left: 0.5rem;
    }
    .btn-view { background: #eff6ff; color: #3b82f6; }
    .btn-view:hover { background: #3b82f6; color: #fff; }
    .btn-edit { background: #fef3c7; color: #92400e; }
    .btn-edit:hover { background: #92400e; color: #fff; }
    .btn-pay { background: #dcfce7; color: #166534; }
    .btn-pay:hover { background: #166534; color: #fff; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    .btn-delete:hover { background: #991b1b; color: #fff; }
</style>
@endpush

@section('content')
<div class="invoices-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-file-invoice-dollar" style="color:#8b5cf6;margin-left:0.5rem"></i> الفواتير</h1>
        <a href="{{ route('pharmacist.invoices.create') }}" class="btn-action" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: #fff;">
            <i class="fa-solid fa-plus"></i> إنشاء فاتورة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background:#dcfce7;color:#166534;border:none;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;font-weight:600;">
            <i class="fa-solid fa-check-circle" style="margin-left:0.5rem"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;border:none;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;font-weight:600;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-left:0.5rem"></i> {{ session('error') }}
        </div>
    @endif

    <div class="invoices-table">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>المريض</th>
                    <th>المجموع الفرعي</th>
                    <th>الخصم</th>
                    <th>الضريبة</th>
                    <th>الإجمالي</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td style="font-weight:700;color:#8b5cf6">#{{ $invoice->id }}</td>
                    <td>{{ $invoice->patient->name ?? '-' }}</td>
                    <td>{{ number_format($invoice->subtotal, 2) }}</td>
                    <td>{{ number_format($invoice->discount, 2) }}</td>
                    <td>{{ number_format($invoice->tax, 2) }}</td>
                    <td style="font-weight:700;color:#1e293b">{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>
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
                    </td>
                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('pharmacist.invoices.show', $invoice->id) }}" class="btn-action btn-view">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                            <a href="{{ route('pharmacist.invoices.edit', $invoice->id) }}" class="btn-action btn-edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('pharmacist.invoices.pay', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action btn-pay" onclick="return confirm('هل أنت متأكد من دفع هذه الفاتورة؟')">
                                    <i class="fa-solid fa-money-bill"></i>
                                </button>
                            </form>
                            <form action="{{ route('pharmacist.invoices.cancel', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('هل أنت متأكد من إلغاء هذه الفاتورة؟')">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 3rem;">
                        <div style="color:#94a3b8;font-size:1.1rem;font-weight:600">لا توجد فواتير</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
