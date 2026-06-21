@extends('layouts.app')
@section('title', 'الأدوية منخفضة المخزون')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-box-open"></i> الأدوية منخفضة المخزون</h1>
        <a href="{{ route('pharmacist.reports.index') }}" class="btn btn-secondary">عودة</a>
    </div>

    <div class="alert alert-warning">
        <i class="fa-solid fa-triangle-exclamation"></i>
        هذه الأدوية وصلت إلى الحد الأدنى للمخزون أو أقل
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الدواء</th>
                            <th>الشركة المصنعة</th>
                            <th>المخزون الحالي</th>
                            <th>الحد الأدنى</th>
                            <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $index => $medicine)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->manufacturer ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $medicine->stock }}</span>
                            </td>
                            <td>{{ $medicine->low_stock_threshold }}</td>
                            <td>
                                @if($medicine->stock == 0)
                                    <span class="badge bg-danger">نفذت الكمية</span>
                                @else
                                    <span class="badge bg-warning">منخفض</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pharmacist.inventory.edit', $medicine) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-edit"></i> تعديل
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
