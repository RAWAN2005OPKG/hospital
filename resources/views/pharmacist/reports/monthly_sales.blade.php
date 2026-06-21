@extends('layouts.app')
@section('title', 'تقرير المبيعات الشهرية')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-calendar-month"></i> تقرير المبيعات الشهرية</h1>
        <div>
            <a href="{{ route('pharmacist.reports.monthly-sales', ['month' => $month, 'year' => $year]) }}?export=pdf" class="btn btn-danger">
                <i class="fa-solid fa-file-pdf"></i> تصدير PDF
            </a>
            <a href="{{ route('pharmacist.reports.index') }}" class="btn btn-secondary">عودة</a>
        </div>
    </div>

    <!-- Month Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pharmacist.reports.monthly-sales') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label>الشهر</label>
                        <select name="month" class="form-control" required>
                            @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>السنة</label>
                        <select name="year" class="form-control" required>
                            @for($i = now()->year - 5; $i <= now()->year + 1; $i++)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
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

    <!-- Daily Breakdown -->
    <div class="card">
        <div class="card-header">
            <h5>المبيعات اليومية - {{ $month }}/{{ $year }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>عدد الفواتير</th>
                            <th>إجمالي المبيعات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyData as $date => $daySales)
                        <tr>
                            <td>{{ $date }}</td>
                            <td>{{ $daySales->count() }}</td>
                            <td>{{ number_format($daySales->sum('total_amount'), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
