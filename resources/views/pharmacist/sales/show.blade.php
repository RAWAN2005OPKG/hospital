@extends('layouts.app')
@section('title', 'تفاصيل البيع')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-receipt"></i> تفاصيل الفاتورة #{{ $invoice->id }}</h1>
        <a href="{{ route('pharmacist.sales.index') }}" class="btn btn-secondary">عودة</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>تفاصيل الفاتورة</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>رقم الفاتورة:</th>
                            <td>#{{ $invoice->id }}</td>
                        </tr>
                        <tr>
                            <th>المريض:</th>
                            <td>{{ $invoice->patient->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>التاريخ:</th>
                            <td>{{ $invoice->paid_at ? $invoice->paid_at->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>الصيدلي:</th>
                            <td>{{ $invoice->pharmacist->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>طريقة الدفع:</th>
                            <td>{{ $invoice->payment_method ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>الحالة:</th>
                            <td>
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>الأدوية</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الدواء</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->medicine->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">المجموع الفرعي:</th>
                                <td>{{ number_format($invoice->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3">الخصم:</th>
                                <td>{{ number_format($invoice->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3">الضريبة:</th>
                                <td>{{ number_format($invoice->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3">الإجمالي:</th>
                                <td><strong>{{ number_format($invoice->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($invoice->prescription)
            <div class="card">
                <div class="card-header">
                    <h5>الوصفة المرتبطة</h5>
                </div>
                <div class="card-body">
                    <p><strong>رقم الوصفة:</strong> #{{ $invoice->prescription->id }}</p>
                    <p><strong>الطبيب:</strong> {{ $invoice->prescription->doctor->user->name ?? '-' }}</p>
                    <p><strong>الحالة:</strong> {{ $invoice->prescription->status }}</p>
                    <a href="{{ route('pharmacist.prescriptions.show', $invoice->prescription) }}" class="btn btn-sm btn-info">
                        عرض الوصفة
                    </a>
                </div>
            </div>
            @endif

            @if($invoice->notes)
            <div class="card mt-3">
                <div class="card-header">
                    <h5>ملاحظات</h5>
                </div>
                <div class="card-body">
                    <p>{{ $invoice->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
