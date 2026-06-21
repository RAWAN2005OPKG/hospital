@extends('layouts.app')
@section('title', 'المبيعات')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-chart-line"></i> المبيعات</h1>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>مبيعات اليوم</h5>
                    <h3>{{ number_format($stats['today_sales'], 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>مبيعات الشهر</h5>
                    <h3>{{ number_format($stats['month_sales'], 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>أرباح اليوم</h5>
                    <h3>{{ number_format($stats['today_profit'], 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>أرباح الشهر</h5>
                    <h3>{{ number_format($stats['month_profit'], 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pharmacist.sales.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>من تاريخ</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label>إلى تاريخ</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label>طريقة الدفع</label>
                        <select name="payment_method" class="form-control">
                            <option value="">الكل</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>نقداً</option>
                            <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>بطاقة</option>
                            <option value="insurance" {{ request('payment_method') == 'insurance' ? 'selected' : '' }}>تأمين</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">تصفية</button>
                <a href="{{ route('pharmacist.sales.index') }}" class="btn btn-secondary mt-3">إعادة تعيين</a>
            </form>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>المريض</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>#{{ $sale->id }}</td>
                            <td>{{ $sale->patient->name ?? '-' }}</td>
                            <td>{{ $sale->paid_at ? $sale->paid_at->format('Y-m-d H:i') : '-' }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ $sale->payment_method ?? '-' }}</td>
                            <td>
                                <a href="{{ route('pharmacist.sales.show', $sale) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $sales->links() }}
        </div>
    </div>

    <!-- Top Selling Medicines -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>أكثر الأدوية مبيعاً</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>الدواء</th>
                        <th>عدد المرات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topMedicines as $medicine)
                    <tr>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->sales_count ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
