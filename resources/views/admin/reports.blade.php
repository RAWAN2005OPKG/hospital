@extends('layouts.dashboard')

@section('title', 'التقارير والإحصائيات')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">التقارير والإحصائيات</h1>
        <p class="page-subtitle">عرض التقارير والإحصائيات الشاملة للمستشفى</p>
    </div>
</div>

<!-- Report Controls -->
<div class="card" style="margin-bottom: 2rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; padding: 1.5rem; align-items: end;">
        <div class="form-group" style="margin: 0;">
            <label class="form-label">النوع</label>
            <select class="form-control">
                <option>النوع</option>
                <option>إيرادات</option>
                <option>مواعيد</option>
                <option>أطباء</option>
                <option>مرضى</option>
                <option>أقسام</option>
            </select>
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">التاريخ</label>
            <input type="date" class="form-control">
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">المدة</label>
            <select class="form-control">
                <option>المدة</option>
                <option>اليوم</option>
                <option>الأسبوع</option>
                <option>الشهر</option>
                <option>السنة</option>
            </select>
        </div>
        <button class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
            <i class="fa-solid fa-download"></i> عرض التقرير
        </button>
        <button class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
            <i class="fa-solid fa-file-pdf"></i> تصدير PDF
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <!-- Main Revenue Chart -->
    <div class="card">
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center;">
            <i class="fa-solid fa-chart-line" style="color: var(--success); margin-left: 0.5rem;"></i>
            الإيرادات الشهرية
        </h3>
        <div style="height: 300px; background: rgba(0, 102, 204, 0.02); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
            <i class="fa-solid fa-chart-line" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>

    <!-- Department Performance -->
    <div class="card">
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center;">
            <i class="fa-solid fa-hospital" style="color: #f97316; margin-left: 0.5rem;"></i>
            أداء الأقسام
        </h3>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($departmentsPerformance ?? collect() as $dept)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.85rem 1rem; background: var(--gray-50); border-radius: 12px; border: 1px solid var(--gray-100);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #f97316, #ef4444); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 0.8rem;">
                            {{ mb_substr($dept->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--gray-900);">{{ $dept->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $dept->doctors_count }} طبيب</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 900; color: var(--success);">{{ $dept->revenue }} ر.س</div>
                        <div style="width: 60px; height: 4px; background: var(--gray-200); border-radius: 2px; overflow: hidden; margin-top: 0.25rem;">
                            <div style="height: 100%; background: linear-gradient(90deg, var(--success), #10b981); width: {{ $dept->percentage }}%;"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; color: var(--gray-400);">
                    <i class="fa-solid fa-chart-bar" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; opacity: 0.3;"></i>
                    <p>لا توجد بيانات للعرض</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem;">
    <!-- Doctor Rankings -->
    <div class="card">
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center;">
            <i class="fa-solid fa-trophy" style="color: #fbbf24; margin-left: 0.5rem;"></i>
            ترتيب الأطباء حسب الإيرادات
        </h3>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($topDoctors ?? collect() as $index => $doctor)
                <div style="display: flex; align-items: center; padding: 0.85rem 1rem; background: var(--gray-50); border-radius: 12px; border: 1px solid var(--gray-100);">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #fbbf24, #f97316); color: #fff; font-weight: bold; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-left: 0.75rem; flex-shrink: 0;">
                        #{{ $index + 1 }}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--gray-900);">{{ $doctor->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $doctor->appointments }} موعد • {{ $doctor->patients }} مريض</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 900; color: var(--success);">{{ $doctor->revenue }} ر.س</div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; color: var(--gray-400);">
                    <i class="fa-solid fa-trophy" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; opacity: 0.3;"></i>
                    <p>لا توجد بيانات للترتيب</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div class="card" style="background: linear-gradient(135deg, var(--purple), #a855f7); color: #fff; text-align: center;">
            <i class="fa-solid fa-arrow-trend-up" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
            <div style="font-size: 1.8rem; font-weight: 900;">+27%</div>
            <p style="opacity: 0.9; font-size: 0.85rem;">نمو الإيرادات</p>
        </div>
        <div class="card" style="background: linear-gradient(135deg, var(--success), #059669); color: #fff; text-align: center;">
            <i class="fa-solid fa-users" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
            <div style="font-size: 1.8rem; font-weight: 900;">{{ $newPatientsThisMonth ?? 0 }}</div>
            <p style="opacity: 0.9; font-size: 0.85rem;">مرضى جدد</p>
        </div>
        <div class="card" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; text-align: center;">
            <i class="fa-solid fa-clock" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
            <div style="font-size: 1.8rem; font-weight: 900;">{{ $avgAppointmentTime ?? '12'}} دقيقة</div>
            <p style="opacity: 0.9; font-size: 0.85rem;">متوسط موعد</p>
        </div>
    </div>
</div>
@endsection
