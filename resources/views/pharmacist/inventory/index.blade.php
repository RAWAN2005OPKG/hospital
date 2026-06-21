@extends('layouts.app')
@section('title', 'إدارة المخزون')

@push('styles')
<style>
    .inventory-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .inventory-table {
        width: 100%;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .inventory-table th {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        text-align: right;
        font-weight: 700;
        color: #475569;
        font-size: 0.95rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .inventory-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .inventory-table tr:hover td { background: #f8fafc; }

    .stock-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
    }
    .stock-good { background: #dcfce7; color: #166534; }
    .stock-low { background: #fef3c7; color: #92400e; }
    .stock-out { background: #fee2e2; color: #991b1b; }

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
    .btn-delete { background: #fee2e2; color: #991b1b; }
    .btn-delete:hover { background: #991b1b; color: #fff; }

    .alert-card {
        background: #fff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')
<div class="inventory-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-boxes-stacked" style="color:#10b981;margin-left:0.5rem"></i> إدارة المخزون</h1>
        <a href="{{ route('pharmacist.inventory.create') }}" class="btn-action" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff;">
            <i class="fa-solid fa-plus"></i> إضافة دواء
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

    @if($lowStockMedicines->count() > 0)
    <div class="alert-card">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;"><i class="fa-solid fa-triangle-exclamation" style="color:#ef4444;margin-left:0.5rem"></i> تنبيهات المخزون المنخفض</h3>
        @foreach($lowStockMedicines as $medicine)
            <div style="padding: 0.75rem; border-radius: 10px; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; background: #fef3c7; color: #92400e;">
                <strong>{{ $medicine->name }}</strong> - المتبقي: {{ $medicine->stock }} (الحد الأدنى: {{ $medicine->low_stock_threshold }})
            </div>
        @endforeach
    </div>
    @endif

    @if($expiringSoon->count() > 0)
    <div class="alert-card">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;"><i class="fa-solid fa-clock" style="color:#f97316;margin-left:0.5rem"></i> أدوية قريبة الانتهاء</h3>
        @foreach($expiringSoon as $medicine)
            <div style="padding: 0.75rem; border-radius: 10px; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; background: #fee2e2; color: #991b1b;">
                <strong>{{ $medicine->name }}</strong> - ينتهي: {{ $medicine->expiration_date ? $medicine->expiration_date->format('Y-m-d') : 'غير محدد' }}
            </div>
        @endforeach
    </div>
    @endif

    <div class="inventory-table">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>اسم الدواء</th>
                    <th>الشركة المصنعة</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $medicine)
                <tr>
                    <td style="font-weight:700;color:#3b82f6">{{ $medicine->name }}</td>
                    <td>{{ $medicine->manufacturer ?? '-' }}</td>
                    <td>{{ $medicine->stock }}</td>
                    <td>{{ number_format($medicine->price, 2) }}</td>
                    <td>{{ $medicine->expiration_date ? $medicine->expiration_date->format('Y-m-d') : '-' }}</td>
                    <td>
                        @if($medicine->stock <= 0)
                            <span class="stock-badge stock-out">نفد</span>
                        @elseif($medicine->stock <= $medicine->low_stock_threshold)
                            <span class="stock-badge stock-low">منخفض</span>
                        @else
                            <span class="stock-badge stock-good">متوفر</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pharmacist.inventory.show', $medicine->id) }}" class="btn-action btn-view">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('pharmacist.inventory.edit', $medicine->id) }}" class="btn-action btn-edit">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <form action="{{ route('pharmacist.inventory.destroy', $medicine->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الدواء؟')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem;">
                        <div style="color:#94a3b8;font-size:1.1rem;font-weight:600">لا توجد أدوية في المخزون</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem">
        {{ $medicines->links() }}
    </div>
</div>
@endsection
