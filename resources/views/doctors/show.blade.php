@extends('layouts.app')
@section('title', $doctor->user->name)
@section('content')

<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a> /
            <a href="{{ route('doctors.index') }}">الدكاترة</a> /
            {{ $doctor->user->name }}
        </div>
        <h1>{{ $doctor->user->name }}</h1>
        <p>{{ $doctor->specialization->name ?? '' }}</p>
    </div>
</div>

<section class="section-sm">
<div class="container">
<div style="display:grid;grid-template-columns:320px 1fr;gap:2rem;align-items:start">

    {{-- Sidebar --}}
    <div>
        <div class="card" style="text-align:center;padding:2rem;margin-bottom:1.25rem">
            <div style="width:110px;height:110px;border-radius:50%;margin:0 auto 1rem;background:linear-gradient(135deg,var(--blue-lt),var(--cyan-lt));display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--blue);overflow:hidden;border:3px solid var(--border)">
                @if($doctor->user->avatar ?? false)
                    <img src="{{ asset('storage/'.$doctor->user->avatar) }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <i class="fa-solid fa-user-doctor"></i>
                @endif
            </div>
            <h2 style="font-size:1.15rem;font-weight:900;margin-bottom:.2rem">{{ $doctor->user->name }}</h2>
            <div style="color:var(--blue);font-weight:700;font-size:.88rem;margin-bottom:.4rem">{{ $doctor->specialization->name ?? '' }}</div>
            <div style="font-size:.82rem;color:var(--muted);margin-bottom:1rem">{{ $doctor->department->name ?? '' }}</div>
            <div style="display:flex;justify-content:center;gap:.25rem;color:#f59e0b;margin-bottom:1.5rem">
                @for($i=1;$i<=5;$i++)<i class="fa-solid fa-star"></i>@endfor
            </div>
            <a href="#booking" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fa-solid fa-calendar-plus"></i> احجز موعداً
            </a>
        </div>

        {{-- Timetable --}}
        @if($schedules->count())
        <div class="card">
            <div class="card-header" style="font-size:.88rem">
                <span><i class="fa-solid fa-clock" style="color:var(--blue);margin-left:.4rem"></i>جدول الدوام</span>
            </div>
            <div class="card-body" style="padding:1rem">
                @php
                $dayNames = ['saturday'=>'السبت','sunday'=>'الأحد','monday'=>'الاثنين','tuesday'=>'الثلاثاء','wednesday'=>'الأربعاء','thursday'=>'الخميس','friday'=>'الجمعة'];
                @endphp
                @foreach($schedules as $s)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:.65rem 0;border-bottom:1px solid var(--border);font-size:.86rem">
                    <span style="font-weight:700">{{ $dayNames[$s->day_of_week] ?? $s->day_of_week }}</span>
                    <span style="color:var(--muted)">{{ $s->start_time }} — {{ $s->end_time }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Main content --}}
    <div>
        {{-- About --}}
        @if($doctor->bio ?? false)
        <div class="card" style="margin-bottom:1.25rem">
            <div class="card-header">نبذة عن الدكتور</div>
            <div class="card-body">{{ $doctor->bio }}</div>
        </div>
        @endif

        {{-- Booking Form --}}
        <div class="card" id="booking">
            <div class="card-header">
                <span><i class="fa-solid fa-calendar-plus" style="color:var(--blue);margin-left:.4rem"></i>حجز موعد</span>
            </div>
            <div class="card-body">
                @auth
                <form method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group">
                        <label class="form-label">تاريخ الموعد <span style="color:#ef4444">*</span></label>
                        <input type="date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('appointment_date') }}" required>
                        @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">وقت الموعد <span style="color:#ef4444">*</span></label>
                        <input type="time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror"
                            value="{{ old('appointment_time') }}" required>
                        @error('appointment_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">سبب الزيارة</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="اكتب سبب زيارتك للدكتور...">{{ old('reason') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.8rem">
                    <i class="fa-solid fa-calendar-check"></i> تأكيد الحجز
                </button>
                </form>
                @else
                <div class="alert alert-info">
                    <i class="fa-solid fa-circle-info" style="flex-shrink:0;margin-top:.1rem"></i>
                    <span>يجب عليك <a href="{{ route('login') }}" style="font-weight:800;color:var(--blue)">تسجيل الدخول</a> أو <a href="{{ route('register') }}" style="font-weight:800;color:var(--blue)">إنشاء حساب</a> لحجز موعد.</span>
                </div>
                @endauth
            </div>
        </div>
    </div>

</div>
</div>
</section>
@endsection