@extends('layouts.app')
@section('title', 'الأدوية المنتهية الصلاحية')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-clock"></i> الأدوية القريبة من الانتهاء</h1>
        <a href="{{ route('pharmacist.reports.index') }}" class="btn btn-secondary">عودة</a>
    </div>

    <div class="alert alert-info">
        <i class="fa-solid fa-info-circle"></i>
        هذه الأدوية ستنتهي صلاحيتها خلال 90 يوم القادمة
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
                            <th>تاريخ الإنتاج</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الأيام المتبقية</th>
                            <th>المخزون</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $index => $medicine)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->manufacturer ?? '-' }}</td>
                            <td>{{ $medicine->production_date ? $medicine->production_date->format('Y-m-d') : '-' }}</td>
                            <td>{{ $medicine->expiration_date ? $medicine->expiration_date->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($medicine->expiration_date)
                                    <?php
                                    $daysLeft = now()->diffInDays($medicine->expiration_date, false);
                                    ?>
                                    @if($daysLeft <= 0)
                                        <span class="badge bg-danger">منتهي</span>
                                    @elseif($daysLeft <= 30)
                                        <span class="badge bg-danger">{{ $daysLeft }} يوم</span>
                                    @elseif($daysLeft <= 60)
                                        <span class="badge bg-warning">{{ $daysLeft }} يوم</span>
                                    @else
                                        <span class="badge bg-info">{{ $daysLeft }} يوم</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $medicine->stock }}</td>
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
