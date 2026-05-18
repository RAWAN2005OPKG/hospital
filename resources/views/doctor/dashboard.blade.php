@extends('layouts.app')

@section('title', 'لوحة الطبيب - صحتي')

@section('content')
<div style="background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05)); padding: 2rem 0;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">مرحباً، د. {{ Auth::user()->name }}</h1>
                <p style="color: var(--muted);">إدارة مواعيدك والسجلات الطبية للمرضى</p>
            </div>
            <a href="{{ route('doctor.schedule') }}" class="btn btn-primary">
                <i class="fa-solid fa-calendar-days"></i> إدارة الجدول
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">مواعيد اليوم</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--blue);">{{ $todayAppointments }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(0, 102, 204, 0.1), rgba(0, 188, 212, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--blue); font-size: 1.5rem;">
                        <i class="fa-solid fa-calendar"></i>
                    </div>
                </div>
                <a href="{{ route('doctor.appointments') }}" style="color: var(--blue); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض جميع المواعيد →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">عدد المرضى</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--green);">{{ $totalPatients }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--green); font-size: 1.5rem;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <a href="{{ route('doctor.patient-records') }}" style="color: var(--green); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض السجلات →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">الوصفات الطبية</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--purple);">0</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(139, 92, 246, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--purple); font-size: 1.5rem;">
                        <i class="fa-solid fa-prescription-bottle"></i>
                    </div>
                </div>
                <a href="{{ route('doctor.prescriptions') }}" style="color: var(--purple); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض الوصفات →</a>
            </div>
        </div>
        
        <!-- Upcoming Appointments -->
        <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">المواعيد القادمة</h2>
            
            @if($upcomingAppointments->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($upcomingAppointments as $appointment)
                        <div style="display: flex; gap: 1rem; padding: 1rem; border: 1px solid var(--gray-200); border-radius: 10px; transition: all 0.3s ease;">
                            <div style="width: 60px; height: 60px; border-radius: 10px; background: linear-gradient(135deg, var(--green), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; flex-shrink: 0;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="font-weight: 700; margin-bottom: 0.25rem;">{{ $appointment->patient->user->name }}</h4>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">{{ $appointment->patient->user->phone }}</p>
                                <div style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--muted);">
                                    <span><i class="fa-solid fa-calendar"></i> {{ $appointment->appointment_date->format('d/m/Y') }}</span>
                                    <span><i class="fa-solid fa-clock"></i> {{ $appointment->appointment_time }}</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem; flex-direction: column; justify-content: center;">
                                <a href="{{ route('doctor.appointment-detail', $appointment) }}" class="btn btn-sm btn-primary" style="font-size: 0.8rem;">التفاصيل</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem;">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                    <p style="color: var(--muted);">لا توجد مواعيد قادمة</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection