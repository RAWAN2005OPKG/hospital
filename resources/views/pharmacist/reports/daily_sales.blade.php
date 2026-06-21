@extends('layouts.app')
@section('title', 'تقرير المبيعات اليومية')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-calendar-day"></i> تقرير المبيعات اليومية</h1>
        <div>
            <a href="{{ route('pharmacist.reports.daily-sales', ['date' => $date]) }}?export=pdf" class="btn btn-danger">
                <i class="fa-solid fa-file-pdf"></i> تصدير PDF
            </a>
            <a href="{{ route('pharmacist.reports.index') }}" class="btn btn-secondary">عودة</a>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pharmacist.reports.daily-sales') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>التاريخ</label>
                        <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">عرض</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>إجمالي المبيعات</h5>
                    <h3>{{ number_format($total, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>عدد الفواتير</h5>
                    <h3>{{ $count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>متوسط الفاتورة</h5>
                    <h3>{{ $count > 0 ? number_format($total / $count, 2) : '0.00' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-header">
            <h5>فواتير اليوم - {{ $date }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>المريض</th>
                            <th>الوقت</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>#{{ $sale->id }}</td>
                            <td>{{ $sale->patient->name ?? '-' }}</td>
                            <td>{{ $sale->paid_at ? $sale->paid_at->format('H:i') : '-' }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ $sale->payment_method ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
