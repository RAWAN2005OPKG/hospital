@extends('layouts.app')
@section('title', 'التقارير')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-chart-bar"></i> التقارير</h1>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-calendar-day fa-3x text-primary mb-3"></i>
                    <h4>تقرير المبيعات اليومية</h4>
                    <p class="text-muted">عرض مبيعات يوم محدد</p>
                    <a href="{{ route('pharmacist.reports.daily-sales') }}" class="btn btn-primary">عرض التقرير</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-calendar-month fa-3x text-success mb-3"></i>
                    <h4>تقرير المبيعات الشهرية</h4>
                    <p class="text-muted">عرض مبيعات شهر محدد</p>
                    <a href="{{ route('pharmacist.reports.monthly-sales') }}" class="btn btn-success">عرض التقرير</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-trophy fa-3x text-warning mb-3"></i>
                    <h4>أكثر الأدوية مبيعاً</h4>
                    <p class="text-muted">عرض الأدوية الأكثر طلباً</p>
                    <a href="{{ route('pharmacist.reports.top-selling') }}" class="btn btn-warning">عرض التقرير</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-box-open fa-3x text-danger mb-3"></i>
                    <h4>الأدوية منخفضة المخزون</h4>
                    <p class="text-muted">عرض الأدوية التي تحتاج إعادة تعبئة</p>
                    <a href="{{ route('pharmacist.reports.low-stock') }}" class="btn btn-danger">عرض التقرير</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-clock fa-3x text-info mb-3"></i>
                    <h4>الأدوية المنتهية الصلاحية</h4>
                    <p class="text-muted">عرض الأدوية القريبة من الانتهاء</p>
                    <a href="{{ route('pharmacist.reports.expiring') }}" class="btn btn-info">عرض التقرير</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
