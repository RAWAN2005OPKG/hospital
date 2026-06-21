@extends('layouts.app')
@section('title', 'تفاصيل الدواء')

@push('styles')
<style>
    .inventory-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .detail-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }

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

    .stock-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-block;
    }
    .stock-good { background: #dcfce7; color: #166534; }
    .stock-low { background: #fef3c7; color: #92400e; }
    .stock-out { background: #fee2e2; color: #991b1b; }

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
    .btn-back { background: #e5e7eb; color: #374151; }
    .btn-back:hover { background: #d1d5db; }

    .prescription-table {
        width: 100%;
        background: #f8fafc;
        border-radius: 12px;
        overflow: hidden;
    }
    .prescription-table th {
        background: #e2e8f0;
        padding: 1rem;
        text-align: right;
        font-weight: 700;
        color: #475569;
        font-size: 0.9rem;
    }
    .prescription-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }
</style>
@endpush

@section('content')
<div class="inventory-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-eye" style="color:#10b981;margin-left:0.5rem"></i> تفاصيل الدواء: {{ $medicine->name }}</h1>
        <div>
            <a href="{{ route('pharmacist.inventory.edit', $medicine->id) }}" class="btn-action btn-edit">
                <i class="fa-solid fa-edit"></i> تعديل
            </a>
            <a href="{{ route('pharmacist.inventory.index') }}" class="btn-action btn-back">
                <i class="fa-solid fa-arrow-right"></i> عودة
            </a>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-section">
            <h3>المعلومات الأساسية</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">اسم الدواء</div>
                    <div class="detail-value">{{ $medicine->name }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">الشركة المصنعة</div>
                    <div class="detail-value">{{ $medicine->manufacturer ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">رقم الدفعة</div>
                    <div class="detail-value">{{ $medicine->batch_number ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">الحالة</div>
                    <div class="detail-value">
                        @if($medicine->is_active)
                            <span class="stock-badge stock-good">نشط</span>
                        @else
                            <span class="stock-badge stock-out">غير نشط</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h3>معلومات المخزون</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">الكمية في المخزون</div>
                    <div class="detail-value">{{ $medicine->stock }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">الكمية</div>
                    <div class="detail-value">{{ $medicine->quantity }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">الحد الأدنى للمخزون</div>
                    <div class="detail-value">{{ $medicine->low_stock_threshold }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">حالة المخزون</div>
                    <div class="detail-value">
                        @if($medicine->stock <= 0)
                            <span class="stock-badge stock-out">نفد</span>
                        @elseif($medicine->stock <= $medicine->low_stock_threshold)
                            <span class="stock-badge stock-low">منخفض</span>
                        @else
                            <span class="stock-badge stock-good">متوفر</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h3>معلومات السعر</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">السعر</div>
                    <div class="detail-value">{{ number_format($medicine->price, 2) }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">تاريخ الانتهاء</div>
                    <div class="detail-value">{{ $medicine->expiration_date ? $medicine->expiration_date->format('Y-m-d') : '-' }}</div>
                </div>
            </div>
        </div>

        @if($medicine->description)
        <div class="detail-section">
            <h3>الوصف</h3>
            <div class="detail-value">{{ $medicine->description }}</div>
        </div>
        @endif
    </div>

    @if($medicine->prescriptions && $medicine->prescriptions->count() > 0)
    <div class="detail-card">
        <div class="detail-section">
            <h3>الوصفات التي تحتوي على هذا الدواء</h3>
            <div class="prescription-table">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>رقم الوصفة</th>
                            <th>المريض</th>
                            <th>الطبيب</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicine->prescriptions->take(10) as $prescription)
                        <tr>
                            <td>#{{ $prescription->id }}</td>
                            <td>{{ $prescription->patient->user->name ?? '-' }}</td>
                            <td>{{ $prescription->doctor->user->name ?? '-' }}</td>
                            <td>{{ $prescription->created_at->format('Y-m-d') }}</td>
                            <td>
                                @switch($prescription->status)
                                    @case('pending')
                                        <span class="stock-badge" style="background:#3b82f6;color:#fff">قيد الانتظار</span>
                                        @break
                                    @case('preparing')
                                        <span class="stock-badge" style="background:#06b6d4;color:#fff">قيد التحضير</span>
                                        @break
                                    @case('ready')
                                        <span class="stock-badge" style="background:#8b5cf6;color:#fff">جاهز</span>
                                        @break
                                    @case('delivered')
                                        <span class="stock-badge stock-good">تم التسليم</span>
                                        @break
                                    @case('cancelled')
                                        <span class="stock-badge stock-out">ملغي</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
