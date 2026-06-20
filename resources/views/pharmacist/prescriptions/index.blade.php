@extends('layouts.app')
@section('title', 'إدارة الوصفات الطبية')

@push('styles')
<style>
    .pharmacist-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .prescriptions-table {
        width: 100%;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .prescriptions-table th {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        text-align: right;
        font-weight: 700;
        color: #475569;
        font-size: 0.95rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .prescriptions-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .prescriptions-table tr:hover td { background: #f8fafc; }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-delivered { background: #dcfce7; color: #166534; }

    .btn-view {
        background: #eff6ff;
        color: #3b82f6;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    .btn-view:hover { background: #3b82f6; color: #fff; }
</style>
@endpush

@section('content')
<div class="pharmacist-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-list-check" style="color:#3b82f6;margin-left:0.5rem"></i> قائمة الوصفات الطبية</h1>
        <a href="{{ route('pharmacist.dashboard') }}" class="btn-view" style="background:#f1f5f9;color:#64748b">
            <i class="fa-solid fa-arrow-right"></i> عودة للوحة التحكم
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

    <div class="prescriptions-table">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>رقم الوصفة</th>
                    <th>اسم المريض</th>
                    <th>الطبيب المعالج</th>
                    <th>تاريخ الوصفة</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $prescription)
                <tr>
                    <td style="font-weight:700;color:#3b82f6">#{{ $prescription->id }}</td>
                    <td style="font-weight:600">{{ $prescription->patient->user->name ?? 'غير معروف' }}</td>
                    <td style="color:#64748b">د. {{ $prescription->doctor->user->name ?? 'غير معروف' }}</td>
                    <td dir="ltr" style="text-align:right">{{ $prescription->created_at->format('Y-m-d h:i A') }}</td>
                    <td>
                        @if($prescription->status === 'delivered')
                            <span class="status-badge status-delivered"><i class="fa-solid fa-check"></i> تم التسليم</span>
                        @else
                            <span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> قيد الانتظار</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pharmacist.prescriptions.show', $prescription->id) }}" class="btn-view">
                            <i class="fa-solid fa-eye"></i> التفاصيل
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem;">
                        <div style="color:#94a3b8;font-size:1.1rem;font-weight:600">لا توجد وصفات طبية حالياً</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem">
        {{ $prescriptions->links() }}
    </div>
</div>
@endsection
