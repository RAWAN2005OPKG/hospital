{{-- patient/appointments.blade.php --}}
@extends('layouts.app')
@section('title', __('messages.my_appointments_title'))
@section('content')
<div class="page-header">
    <div class="container"><h1>{{ __('messages.my_appointments_title') }}</h1><p>{{ __('messages.my_appointments_subtitle') }}</p></div>
</div>
<section class="section-sm"><div class="container">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h2 style="font-size:1.05rem;font-weight:800">سجل الحجوزات</h2>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> حجز جديد</a>
</div>
@if($appointments->count())
<div style="display:flex;flex-direction:column;gap:1rem">
    @foreach($appointments as $apt)
    <div class="card">
        <div style="padding:1.25rem;display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap">
            <div style="width:52px;height:52px;border-radius:14px;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div style="flex:1;min-width:140px">
                <div style="font-weight:800;margin-bottom:.15rem">{{ $apt->doctor->user->name ?? '-' }}</div>
                <div style="font-size:.82rem;color:var(--muted)">{{ $apt->doctor->department->name ?? '' }}</div>
            </div>
            <div style="text-align:center">
                <div style="font-weight:700;font-size:.9rem">{{ $apt->appointment_date->format('d/m/Y') }}</div>
                <div style="font-size:.8rem;color:var(--muted)">{{ $apt->appointment_time }}</div>
            </div>
            <span class="badge {{ ['pending'=>'badge-yellow','confirmed'=>'badge-green','cancelled'=>'badge-red','completed'=>'badge-cyan'][$apt->status] ?? 'badge-gray' }}">
                {{ ['pending'=>'قيد الانتظار','confirmed'=>'مؤكد','cancelled'=>'ملغي','completed'=>'مكتمل'][$apt->status] ?? $apt->status }}
            </span>
            @if(in_array($apt->status,['pending','confirmed']))
            <form method="POST" action="{{ route('patient.cancel-appointment',$apt) }}" onsubmit="return confirm('إلغاء هذا الموعد؟')">
                @csrf @method('PATCH')
                <button class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:none;cursor:pointer">
                    <i class="fa-solid fa-xmark"></i> إلغاء
                </button>
            </form>
            @endif
        </div>
        @if($apt->reason)
        <div style="padding:.6rem 1.25rem;background:#f8fafc;border-top:1px solid var(--border);font-size:.82rem;color:var(--muted)">
            <i class="fa-solid fa-note-sticky" style="margin-left:.3rem"></i>{{ $apt->reason }}
        </div>
        @endif
    </div>
    @endforeach
</div>
<div>{{ $appointments->links() }}</div>
@else
<div style="text-align:center;padding:5rem;color:var(--muted)">
    <i class="fa-solid fa-calendar-xmark" style="font-size:3rem;margin-bottom:1rem;display:block;opacity:.2"></i>
    {{ __('messages.no_appointments_yet') }}
    <div style="margin-top:1.25rem">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary"><i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_first_appointment') }}</a>
    </div>
</div>
@endif
</div></section>
@endsection