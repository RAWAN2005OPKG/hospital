@extends('layouts.app')
@section('title', 'إدارة الأدوية')

@push('styles')
<style>
    .admin-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .btn-add {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }
    .btn-add:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3); color: #fff; }

    .medicines-table {
        width: 100%;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .medicines-table th {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        text-align: right;
        font-weight: 700;
        color: #475569;
        font-size: 0.95rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .medicines-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .medicines-table tr:last-child td { border-bottom: none; }
    .medicines-table tr:hover td { background: #f8fafc; }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        margin-left: 0.25rem;
    }
    .action-edit { background: #eff6ff; color: #3b82f6; }
    .action-edit:hover { background: #3b82f6; color: #fff; }
    .action-delete { background: #fef2f2; color: #ef4444; }
    .action-delete:hover { background: #ef4444; color: #fff; }

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
</style>
@endpush

@section('content')
<div class="admin-container container">
    <div class="page-header">
        <h1 class="page-title">إدارة الأدوية والمخزون</h1>
        <a href="{{ route('admin.medicines.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> إضافة دواء جديد
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background:#dcfce7;color:#166534;border:none;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;font-weight:600;">
            <i class="fa-solid fa-check-circle" style="margin-left:0.5rem"></i> {{ session('success') }}
        </div>
    @endif

    <div class="medicines-table">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>اسم الدواء</th>
                    <th>السعر</th>
                    <th>المخزون المتوفر</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $medicine)
                <tr>
                    <td>
                        <div style="font-weight:700;color:#1e293b">{{ $medicine->name }}</div>
                        <div style="font-size:0.85rem;color:#64748b;margin-top:0.25rem">{{ Str::limit($medicine->description, 50) }}</div>
                    </td>
                    <td style="font-weight:600;color:#059669">{{ $medicine->price ? $medicine->price . ' $' : 'مجاني' }}</td>
                    <td>
                        @if($medicine->stock <= 0)
                            <span class="stock-badge stock-out">نفد المخزون</span>
                        @elseif($medicine->stock <= $medicine->low_stock_threshold)
                            <span class="stock-badge stock-low">{{ $medicine->stock }} (منخفض)</span>
                        @else
                            <span class="stock-badge stock-good">{{ $medicine->stock }} متوفر</span>
                        @endif
                    </td>
                    <td>
                        @if($medicine->is_active)
                            <span style="color:#10b981;font-weight:700"><i class="fa-solid fa-circle" style="font-size:0.6rem;margin-left:0.25rem"></i> نشط</span>
                        @else
                            <span style="color:#ef4444;font-weight:700"><i class="fa-solid fa-circle" style="font-size:0.6rem;margin-left:0.25rem"></i> غير نشط</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;">
                            <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="action-btn action-edit" title="تعديل">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.medicines.destroy', $medicine->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدواء؟');" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="حذف">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem;">
                        <div style="color:#94a3b8;font-size:1.1rem;font-weight:600">لا توجد أدوية مضافة حالياً</div>
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
