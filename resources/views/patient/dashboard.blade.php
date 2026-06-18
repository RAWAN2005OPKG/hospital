@extends('layouts.app')

@section('title', __('messages.patient_dashboard_title'))

@section('content')
<div style="background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05)); padding: 2rem 0;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">{{ __('messages.patient_welcome') }} {{ Auth::user()->name }}</h1>
                <p style="color: var(--muted);">{{ __('messages.patient_dashboard_subtitle') }}</p>
            </div>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_new_appointment_btn') }}
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">المواعيد القادمة</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--blue);">{{ $upcomingAppointments }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(0, 102, 204, 0.1), rgba(0, 188, 212, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--blue); font-size: 1.5rem;">
                        <i class="fa-solid fa-calendar"></i>
                    </div>
                </div>
                <a href="{{ route('patient.appointments') }}" style="color: var(--blue); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض جميع المواعيد →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">{{ __('messages.nav_medical_records') }}</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--green);">{{ $medicalRecordsCount }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--green); font-size: 1.5rem;">
                        <i class="fa-solid fa-file-medical"></i>
                    </div>
                </div>
                <a href="{{ route('patient.medical-records') }}" style="color: var(--green); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض السجلات →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي المواعيد</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--purple);">{{ $totalAppointments }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(139, 92, 246, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--purple); font-size: 1.5rem;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>
                <a href="{{ route('patient.appointments') }}" style="color: var(--purple); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض التفاصيل →</a>
            </div>
        </div>
        
        <!-- Upcoming Appointments -->
        <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">المواعيد القادمة</h2>
            
            @if($appointments->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($appointments as $appointment)
                        <div style="display: flex; gap: 1rem; padding: 1rem; border: 1px solid var(--gray-200); border-radius: 10px; transition: all 0.3s ease;">
                            <div style="width: 60px; height: 60px; border-radius: 10px; background: linear-gradient(135deg, var(--blue), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; flex-shrink: 0;">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="font-weight: 700; margin-bottom: 0.25rem;">د. {{ $appointment->doctor->user->name }}</h4>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">{{ $appointment->doctor->specialization->name ?? 'تخصص' }}</p>
                                <div style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--muted);">
                                    <span><i class="fa-solid fa-calendar"></i> {{ $appointment->appointment_date->format('d/m/Y') }}</span>
                                    <span><i class="fa-solid fa-clock"></i> {{ $appointment->appointment_time }}</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem; flex-direction: column; justify-content: center;">
                                <span style="background: rgba(16, 185, 129, 0.1); color: var(--green); padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">{{ $appointment->status }}</span>
                                <a href="#" class="btn btn-sm btn-outline" style="font-size: 0.8rem;">التفاصيل</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem;">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                    <p style="color: var(--muted); margin-bottom: 1rem;">{{ __('messages.no_upcoming_appointments') }}</p>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">{{ __('messages.book_appointment_now') }}</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection