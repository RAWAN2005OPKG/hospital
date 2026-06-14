@extends('layouts.app')
@section('title', 'مواعيد الطبيب')

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 900; color: #111827; margin: 0;">مواعيدي</h1>
                <p style="font-size: 1rem; color: #6b7280; margin: 0.5rem 0 0 0;">إدارة جميع المواعيد والحالات</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" style="padding: 0.75rem 1.5rem; background: white; color: #3b82f6; border: 2px solid #3b82f6; font-weight: bold; border-radius: 1rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-arrow-right"></i>
                <span>العودة</span>
            </a>
        </div>

        <!-- Filters -->
        <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem; border: 1px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <label style="display: block; font-weight: bold; color: #111827; margin-bottom: 0.5rem; font-size: 0.9rem;">الحالة</label>
                    <select style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 0.75rem; background: white; color: #111827; font-weight: 600; cursor: pointer;">
                        <option value="">الكل</option>
                        <option value="pending">معلق</option>
                        <option value="confirmed">مؤكد</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: bold; color: #111827; margin-bottom: 0.5rem; font-size: 0.9rem;">التاريخ</label>
                    <input type="date" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 0.75rem; background: white; color: #111827; font-weight: 600;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; color: #111827; margin-bottom: 0.5rem; font-size: 0.9rem;">البحث</label>
                    <input type="text" placeholder="ابحث عن المريض..." style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 0.75rem; background: white; color: #111827; font-weight: 600;">
                </div>
            </div>
        </div>

        <!-- Appointments List -->
        <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.3rem; font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-calendar-days" style="color: #3b82f6;"></i>
                جميع المواعيد
            </h2>

            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @forelse(auth()->user()->doctor->appointments()->orderBy('appointment_date', 'desc')->get() ?? [] as $appointment)
                    <div style="padding: 1.5rem; background: #f9fafb; border-radius: 1.25rem; border: 1px solid #f3f4f6; display: grid; grid-template-columns: 1fr auto; gap: 1.5rem; align-items: center;">
                        
                        <!-- Appointment Info -->
                        <div style="display: grid; grid-template-columns: auto 1fr; gap: 1.5rem; align-items: start;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                                {{ mb_substr($appointment->patient->user->name ?? 'م', 0, 1) }}
                            </div>
                            
                            <div>
                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                                    <div>
                                        <p style="font-size: 0.8rem; color: #6b7280; font-weight: 600; margin: 0 0 0.25rem 0;">المريض</p>
                                        <p style="font-size: 1.1rem; font-weight: 800; color: #111827; margin: 0;">{{ $appointment->patient->user->name ?? 'مريض' }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.8rem; color: #6b7280; font-weight: 600; margin: 0 0 0.25rem 0;">التاريخ والوقت</p>
                                        <p style="font-size: 1.1rem; font-weight: 800; color: #111827; margin: 0;">{{ $appointment->appointment_date->format('Y/m/d H:i') }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.8rem; color: #6b7280; font-weight: 600; margin: 0 0 0.25rem 0;">رقم الهاتف</p>
                                        <p style="font-size: 1rem; font-weight: 700; color: #111827; margin: 0;">{{ $appointment->patient->user->phone ?? 'غير محدد' }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.8rem; color: #6b7280; font-weight: 600; margin: 0 0 0.25rem 0;">السبب</p>
                                        <p style="font-size: 1rem; font-weight: 700; color: #111827; margin: 0;">{{ $appointment->reason ?? 'عام' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-end;">
                            <span style="padding: 0.5rem 1rem; background: {{ $appointment->status === 'confirmed' ? '#d1fae5' : ($appointment->status === 'pending' ? '#fef3c7' : ($appointment->status === 'completed' ? '#dbeafe' : '#fee2e2')) }}; color: {{ $appointment->status === 'confirmed' ? '#10b981' : ($appointment->status === 'pending' ? '#f59e0b' : ($appointment->status === 'completed' ? '#3b82f6' : '#ef4444')) }}; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700;">
                                {{ $appointment->status === 'confirmed' ? 'مؤكد' : ($appointment->status === 'pending' ? 'معلق' : ($appointment->status === 'completed' ? 'مكتمل' : 'ملغي')) }}
                            </span>
                            <a href="{{ route('doctor.appointment-detail', $appointment) }}" style="padding: 0.6rem 1.2rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 0.75rem; font-weight: bold; text-decoration: none; cursor: pointer; font-size: 0.9rem; display: inline-block;">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 4rem; color: #9ca3af; background: #f9fafb; border-radius: 1.5rem; border: 2px dashed #e5e7eb;">
                        <i class="fas fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                        <p style="margin: 0; font-weight: 600; font-size: 1.1rem;">لا توجد مواعيد</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
