@extends('layouts.app')
@section('title','لوحة الدكتور')
@section('content')

<div class="page-header">
    <div class="container">
        <h1>مرحباً، {{ auth()->user()->name }} 👨‍⚕️</h1>
        <p>لوحة تحكم الدكتور — {{ $doctor->specialization->name ?? '' }}</p>
    </div>
</div>

<section class="section-sm"><div class="container">

{{-- STATS --}}
<div class="grid-4" style="margin-bottom:2rem">
    <div class="stat-card"><div class="stat-icon si-blue"><i class="fa-solid fa-calendar-check"></i></div><div><div class="stat-num">{{ $totalAppointments }}</div><div class="stat-lbl">إجمالي المواعيد</div></div></div>
    <div class="stat-card"><div class="stat-icon si-orange"><i class="fa-solid fa-clock"></i></div><div><div class="stat-num">{{ $todayAppointments }}</div><div class="stat-lbl">مواعيد اليوم</div></div></div>
    <div class="stat-card"><div class="stat-icon si-green"><i class="fa-solid fa-circle-check"></i></div><div><div class="stat-num">{{ $completedAppointments }}</div><div class="stat-lbl">مواعيد مكتملة</div></div></div>
    <div class="stat-card"><div class="stat-icon si-purple"><i class="fa-solid fa-hourglass-half"></i></div><div><div class="stat-num">{{ $pendingAppointments }}</div><div class="stat-lbl">قيد الانتظار</div></div></div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

    {{-- TODAY APPOINTMENTS --}}
    <div class="card">
        <div class="card-header">
            <span><i class="fa-solid fa-calendar-day" style="color:var(--blue);margin-left:.4rem"></i>مواعيد اليوم</span>
            <a href="{{ route('doctor.appointments') }}" class="btn btn-outline btn-sm">عرض الكل</a>
        </div>
        <div class="card-body" style="padding:0">
        @forelse($todayAppointmentsList as $apt)
        <div style="display:flex;align-items:center;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border)">
            <div style="width:44px;height:44px;border-radius:50%;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem;flex-shrink:0">
                {{ mb_substr($apt->patient->name ?? 'م',0,1) }}
            </div>
            <div style="flex:1">
                <div style="font-weight:700;font-size:.9rem">{{ $apt->patient->name ?? '-' }}</div>
                <div style="font-size:.78rem;color:var(--muted)">{{ $apt->appointment_time }}</div>
                @if($apt->reason)<div style="font-size:.78rem;color:var(--muted);margin-top:.15rem">{{ Str::limit($apt->reason,40) }}</div>@endif
            </div>
            <div style="display:flex;flex-direction:column;gap:.35rem">
                <span class="badge {{ ['pending'=>'badge-yellow','confirmed'=>'badge-blue','completed'=>'badge-green','cancelled'=>'badge-red'][$apt->status] ?? 'badge-gray' }}">
                    {{ ['pending'=>'انتظار','confirmed'=>'مؤكد','completed'=>'مكتمل','cancelled'=>'ملغي'][$apt->status] ?? $apt->status }}
                </span>
                <a href="{{ route('doctor.appointment-detail',$apt) }}" class="btn btn-outline btn-sm" style="font-size:.75rem;padding:.28rem .6rem">تفاصيل</a>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--muted)">
            <i class="fa-solid fa-calendar-xmark" style="font-size:2.5rem;margin-bottom:.75rem;display:block;opacity:.2"></i>
            لا توجد مواعيد اليوم
        </div>
        @endforelse
        </div>
    </div>

    {{-- SCHEDULE SIDEBAR --}}
    <div>
        <div class="card" style="margin-bottom:1.25rem">
            <div class="card-header" style="font-size:.88rem">
                <span><i class="fa-solid fa-clock" style="color:var(--blue);margin-left:.4rem"></i>جدول الدوام</span>
                <a href="{{ route('doctor.schedule') }}" class="btn btn-outline btn-sm">تعديل</a>
            </div>
            <div class="card-body" style="padding:.75rem 1rem">
                @php $dayAr=['saturday'=>'السبت','sunday'=>'الأحد','monday'=>'الاثنين','tuesday'=>'الثلاثاء','wednesday'=>'الأربعاء','thursday'=>'الخميس','friday'=>'الجمعة']; @endphp
                @forelse($schedules as $s)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid var(--border);font-size:.84rem">
                    <span style="font-weight:700">{{ $dayAr[$s->day_of_week] ?? $s->day_of_week }}</span>
                    <span style="color:var(--muted)">{{ $s->start_time }}—{{ $s->end_time }}</span>
                </div>
                @empty
                <div style="text-align:center;color:var(--muted);padding:1rem;font-size:.85rem">لا يوجد جدول</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align:center;padding:1.5rem">
                <i class="fa-solid fa-file-medical" style="font-size:2rem;color:var(--cyan);margin-bottom:.75rem;display:block"></i>
                <div style="font-weight:800;margin-bottom:.3rem;font-size:.95rem">سجلات المرضى</div>
                <div style="font-size:.82rem;color:var(--muted);margin-bottom:1rem">عرض وإضافة السجلات الطبية</div>
                <a href="{{ route('doctor.patient-records', $doctor) }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center">عرض السجلات</a>
            </div>
        </div>
    </div>

</div>
</div></section>
@endsection