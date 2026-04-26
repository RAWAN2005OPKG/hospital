{{-- ════ patient/dashboard.blade.php ════ --}}
@extends('layouts.app')
@section('title','لوحة المريض')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>مرحباً، {{ auth()->user()->name }} 👋</h1>
        <p>لوحة تحكم المريض</p>
    </div>
</div>
<section class="section-sm"><div class="container">
<div class="grid-4" style="margin-bottom:2rem">
    @foreach([['si-blue','fa-calendar-check','مواعيد قادمة',$upcomingAppointments],['si-green','fa-check-circle','إجمالي المواعيد',$totalAppointments],['si-cyan','fa-file-medical','السجلات الطبية',$medicalRecords],['si-purple','fa-star','تقييمي','5.0']] as [$cls,$icon,$lbl,$val])
    <div class="stat-card">
        <div class="stat-icon {{ $cls }}"><i class="fa-solid {{ $icon }}"></i></div>
        <div><div class="stat-num">{{ $val }}</div><div class="stat-lbl">{{ $lbl }}</div></div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">
    <div class="card">
        <div class="card-header">
            <span><i class="fa-solid fa-calendar" style="color:var(--blue);margin-left:.4rem"></i>المواعيد القادمة</span>
            <a href="{{ route('patient.appointments') }}" class="btn btn-outline btn-sm">عرض الكل</a>
        </div>
        <div class="card-body">
        @forelse($appointments as $apt)
        <div style="display:flex;align-items:center;gap:1rem;padding:.9rem 0;border-bottom:1px solid var(--border)">
            <div style="width:46px;height:46px;border-radius:12px;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div style="flex:1">
                <div style="font-weight:700;font-size:.9rem">{{ $apt->doctor->user->name ?? 'دكتور' }}</div>
                <div style="font-size:.8rem;color:var(--muted)">{{ $apt->appointment_date->format('d/m/Y') }} — {{ $apt->appointment_time }}</div>
            </div>
            <span class="badge {{ $apt->status==='confirmed'?'badge-green':($apt->status==='pending'?'badge-yellow':'badge-red') }}">
                {{ ['pending'=>'قيد الانتظار','confirmed'=>'مؤكد','cancelled'=>'ملغي','completed'=>'مكتمل'][$apt->status] ?? $apt->status }}
            </span>
        </div>
        @empty
        <div style="text-align:center;padding:2rem;color:var(--muted)">لا توجد مواعيد قادمة</div>
        @endforelse
        </div>
    </div>
    <div>
        <div class="card" style="margin-bottom:1rem">
            <div class="card-body" style="text-align:center;padding:1.5rem">
                <i class="fa-solid fa-calendar-plus" style="font-size:2rem;color:var(--blue);margin-bottom:.75rem;display:block"></i>
                <div style="font-weight:700;margin-bottom:.4rem">حجز موعد جديد</div>
                <div style="font-size:.83rem;color:var(--muted);margin-bottom:1rem">تصفح الدكاترة واحجز موعدك</div>
                <a href="{{ route('doctors.index') }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center">احجز الآن</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align:center;padding:1.5rem">
                <i class="fa-solid fa-file-medical" style="font-size:2rem;color:var(--cyan);margin-bottom:.75rem;display:block"></i>
                <div style="font-weight:700;margin-bottom:.4rem">سجلاتي الطبية</div>
                <div style="font-size:.83rem;color:var(--muted);margin-bottom:1rem">{{ $medicalRecords }} سجل طبي</div>
                <a href="{{ route('patient.medical-records') }}" class="btn btn-outline btn-sm" style="width:100%;justify-content:center">عرض السجلات</a>
            </div>
        </div>
    </div>
</div>
</div></section>
@endsection