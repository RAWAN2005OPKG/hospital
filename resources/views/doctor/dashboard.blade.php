@extends('layouts.app')
@section('title', 'لوحة تحكم الطبيب')

@section('content')
<div style="padding-top: 120px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Welcome Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 900; color: #111827; margin: 0 0 0.5rem 0;">{{ __('messages.doctor_welcome') }} {{ auth()->user()->name }}</h1>
            <p style="font-size: 1.1rem; color: #6b7280; margin: 0;">{{ __('messages.doctor_dashboard_subtitle') }}</p>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            
            <!-- Total Appointments -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb; transition: all 0.3s ease;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="font-size: 0.9rem; color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0;">إجمالي المواعيد</p>
                        <p style="font-size: 2.5rem; font-weight: 900; color: #3b82f6; margin: 0;">{{ $totalAppointments ?? 0 }}</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: #dbeafe; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 1.8rem;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <!-- Today Appointments -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb; transition: all 0.3s ease;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="font-size: 0.9rem; color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0;">مواعيد اليوم</p>
                        <p style="font-size: 2.5rem; font-weight: 900; color: #f59e0b; margin: 0;">{{ $todayAppointments ?? 0 }}</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: #fef3c7; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 1.8rem;">
                        <i class="fas fa-sun"></i>
                    </div>
                </div>
            </div>

            <!-- Completed Appointments -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb; transition: all 0.3s ease;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="font-size: 0.9rem; color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0;">المواعيد المكتملة</p>
                        <p style="font-size: 2.5rem; font-weight: 900; color: #10b981; margin: 0;">{{ $completedAppointments ?? 0 }}</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: #d1fae5; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 1.8rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Appointments -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb; transition: all 0.3s ease;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="font-size: 0.9rem; color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0;">المواعيد المعلقة</p>
                        <p style="font-size: 2.5rem; font-weight: 900; color: #8b5cf6; margin: 0;">{{ $pendingAppointments ?? 0 }}</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: #ede9fe; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 1.8rem;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 3rem;">
            <a href="{{ route('doctor.appointments') }}" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 1.5rem; border-radius: 1.25rem; text-decoration: none; text-align: center; font-weight: bold; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i class="fas fa-calendar-alt"></i>
                <span>عرض المواعيد</span>
            </a>
            <a href="{{ route('doctor.consultations') }}" style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; padding: 1.5rem; border-radius: 1.25rem; text-decoration: none; text-align: center; font-weight: bold; box-shadow: 0 10px 25px rgba(6, 182, 212, 0.2); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i class="fas fa-comments"></i>
                <span>الاستشارات</span>
            </a>
            <a href="{{ route('doctor.patient-records') }}" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1.5rem; border-radius: 1.25rem; text-decoration: none; text-align: center; font-weight: bold; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i class="fas fa-file-medical"></i>
                <span>سجلات المرضى</span>
            </a>
            <a href="{{ route('doctor.schedule') }}" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 1.5rem; border-radius: 1.25rem; text-decoration: none; text-align: center; font-weight: bold; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.2); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i class="fas fa-clock"></i>
                <span>جدول المواعيد</span>
            </a>
            <a href="{{ route('profile.show') }}" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 1.5rem; border-radius: 1.25rem; text-decoration: none; text-align: center; font-weight: bold; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.2); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i class="fas fa-user-circle"></i>
                <span>ملفي الشخصي</span>
            </a>
        </div>

        <!-- Recent Appointments -->
        <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-list" style="color: #3b82f6;"></i>
                    مواعيد اليوم
                </h2>
                <a href="{{ route('doctor.appointments') }}" style="color: #3b82f6; font-weight: bold; text-decoration: none; font-size: 0.9rem;">عرض الكل <i class="fas fa-chevron-left" style="margin-left: 0.25rem;"></i></a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($todayAppointmentsList ?? [] as $appointment)
                    <div style="padding: 1.25rem; background: #f9fafb; border-radius: 1rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 45px; height: 45px; background: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #3b82f6; border: 1px solid #e5e7eb; font-weight: bold;">
                                {{ mb_substr($appointment->patient->user->name ?? 'م', 0, 1) }}
                            </div>
                            <div>
                                <p style="font-weight: bold; color: #111827; margin: 0;">{{ $appointment->patient->user->name ?? 'مريض' }}</p>
                                <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">{{ $appointment->appointment_date->format('H:i') }}</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <span style="padding: 0.4rem 0.8rem; background: {{ $appointment->status === 'confirmed' ? '#d1fae5' : ($appointment->status === 'pending' ? '#fef3c7' : '#fee2e2') }}; color: {{ $appointment->status === 'confirmed' ? '#10b981' : ($appointment->status === 'pending' ? '#f59e0b' : '#ef4444') }}; border-radius: 0.75rem; font-size: 0.8rem; font-weight: 600;">
                                {{ $appointment->status === 'confirmed' ? 'مؤكد' : ($appointment->status === 'pending' ? 'معلق' : 'ملغي') }}
                            </span>
                            <a href="{{ route('doctor.appointment-detail', $appointment) }}" style="padding: 0.4rem 0.8rem; background: white; color: #3b82f6; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.8rem; font-weight: 600; text-decoration: none; cursor: pointer;">تفاصيل</a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 3rem; color: #9ca3af; background: #f9fafb; border-radius: 1rem; border: 2px dashed #e5e7eb;">
                        <i class="fas fa-inbox" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                        <p style="margin: 0; font-weight: 600;">لا توجد مواعيد اليوم</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
