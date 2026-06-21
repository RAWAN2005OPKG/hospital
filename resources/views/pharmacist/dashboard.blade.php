@extends('layouts.app')
@section('title', 'لوحة تحكم الصيدلي')

@push('styles')
<style>
    .pharmacist-container { padding: 2rem 0; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }
    .icon-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .icon-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .icon-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .icon-red { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .icon-orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }
    .icon-cyan { background: rgba(6, 182, 212, 0.1); color: #06b6d4; }
    
    .stat-info h3 { font-size: 2rem; font-weight: 900; margin: 0; color: #1e293b; }
    .stat-info p { margin: 0; color: #64748b; font-weight: 600; font-size: 0.95rem; }

    .quick-actions {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="pharmacist-container container">
    <div class="page-header">
        <h1 class="page-title"><i class="fa-solid fa-staff-snake" style="color:#3b82f6;margin-left:0.5rem"></i> لوحة تحكم الصيدلية</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-file-prescription"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['new_prescriptions'] }}</h3>
                <p>وصفات جديدة</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-cyan">
                <i class="fa-solid fa-flask"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['preparing_prescriptions'] }}</h3>
                <p>قيد التحضير</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['ready_prescriptions'] }}</h3>
                <p>جاهزة للتسليم</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="fa-solid fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['delivered_prescriptions'] }}</h3>
                <p>تم تسليمها</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <i class="fa-solid fa-pills"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_medicines'] }}</h3>
                <p>إجمالي الأدوية</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['available_medicines'] }}</h3>
                <p>متوفرة</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-red">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['low_stock_medicines'] }}</h3>
                <p>منخفضة المخزون</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['expiring_soon'] }}</h3>
                <p>قريبة الانتهاء</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($stats['today_sales'], 2) }}</h3>
                <p>مبيعات اليوم</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($stats['month_sales'], 2) }}</h3>
                <p>مبيعات الشهر</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-cyan">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['patients_served'] }}</h3>
                <p>مرضى تم خدمتهم</p>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.5rem; color: #1e293b;">الإجراءات السريعة</h2>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
            <a href="{{ route('pharmacist.prescriptions.index') }}" class="action-btn">
                <i class="fa-solid fa-list-check"></i> إدارة الوصفات
            </a>
            <a href="{{ route('pharmacist.inventory.index') }}" class="action-btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fa-solid fa-boxes-stacked"></i> إدارة المخزون
            </a>
            <a href="{{ route('pharmacist.invoices.index') }}" class="action-btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="fa-solid fa-file-invoice-dollar"></i> الفواتير
            </a>
        </div>
    </div>

    @if(isset($lowStockMedicines) && isset($expiringSoonMedicines) && ($lowStockMedicines->count() > 0 || $expiringSoonMedicines->count() > 0))
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        @if($lowStockMedicines->count() > 0)
        <div style="background: #fff; border-radius: 20px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;"><i class="fa-solid fa-triangle-exclamation" style="color:#ef4444;margin-left:0.5rem"></i> تنبيهات المخزون المنخفض</h3>
            @foreach($lowStockMedicines->take(5) as $medicine)
                <div style="padding: 0.75rem; border-radius: 10px; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; background: #fef3c7; color: #92400e;">
                    <strong>{{ $medicine->name }}</strong> - المتبقي: {{ $medicine->stock }}
                </div>
            @endforeach
        </div>
        @endif

        @if($expiringSoonMedicines->count() > 0)
        <div style="background: #fff; border-radius: 20px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;"><i class="fa-solid fa-clock" style="color:#f97316;margin-left:0.5rem"></i> أدوية قريبة الانتهاء</h3>
            @foreach($expiringSoonMedicines->take(5) as $medicine)
                <div style="padding: 0.75rem; border-radius: 10px; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; background: #fee2e2; color: #991b1b;">
                    <strong>{{ $medicine->name }}</strong> - ينتهي: {{ $medicine->expiration_date ? $medicine->expiration_date->format('Y-m-d') : 'غير محدد' }}
                </div>
            @endforeach
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
