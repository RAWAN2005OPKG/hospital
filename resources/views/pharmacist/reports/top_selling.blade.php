@extends('layouts.app')
@section('title', 'أكثر الأدوية مبيعاً')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-trophy"></i> أكثر الأدوية مبيعاً</h1>
        <a href="{{ route('pharmacist.reports.index') }}" class="btn btn-secondary">عودة</a>
    </div>

    <!-- Date Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pharmacist.reports.top-selling') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>من تاريخ</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>إلى تاريخ</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">عرض</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Medicines Table -->
    <div class="card">
        <div class="card-header">
            <h5>الأدوية الأكثر مبيعاً من {{ $startDate }} إلى {{ $endDate }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الدواء</th>
                            <th>الشركة المصنعة</th>
                            <th>السعر</th>
                            <th>المخزون الحالي</th>
                            <th>عدد المرات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $index => $medicine)
                        <tr>
                            <td>{{ ($medicines->currentpage() - 1) * $medicines->perpage() + $index + 1 }}</td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->manufacturer ?? '-' }}</td>
                            <td>{{ number_format($medicine->price, 2) }}</td>
                            <td>{{ $medicine->stock }}</td>
                            <td><strong>{{ $medicine->sales_count }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $medicines->links() }}
        </div>
    </div>
</div>
@endsection
