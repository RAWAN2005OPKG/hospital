@extends('layouts.app')

@section('title', 'لوحة تحكم الطبيب')

@section('content')
<div class="mb-8">
    <h1 class="section-title">مرحباً د. {{ auth()->user()->name }}</h1>
    <p class="section-subtitle">لوحة تحكم الطبيب</p>
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">إجمالي المواعيد</p>
                <p class="text-4xl font-bold text-blue-600">{{ $stats['total_appointments'] }}</p>
            </div>
            <i class="fas fa-calendar-check text-5xl text-blue-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">مواعيد اليوم</p>
                <p class="text-4xl font-bold text-teal-600">{{ $stats['today_appointments'] }}</p>
            </div>
            <i class="fas fa-clock text-5xl text-teal-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">مكتملة</p>
                <p class="text-4xl font-bold text-green-600">{{ $stats['completed'] }}</p>
            </div>
            <i class="fas fa-check-circle text-5xl text-green-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">قيد الانتظار</p>
                <p class="text-4xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            </div>
            <i class="fas fa-hourglass-half text-5xl text-yellow-100"></i>
        </div>
    </div>
</div>

<!-- Today's Appointments -->
<div class="card">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">مواعيد اليوم</h2>
    
    @if($todayAppointments->count() > 0)
    <div class="space-y-4">
        @foreach($todayAppointments as $appointment)
        <div class="border border-blue-200 rounded-lg p-4 hover:bg-blue-50 transition">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <div>
                    <p class="text-sm text-gray-600 mb-1">المريض</p>
                    <h3 class="font-bold text-gray-800">{{ $appointment->patient->name }}</h3>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600 mb-1">الوقت</p>
                    <p class="font-bold text-gray-800">{{ $appointment->appointment_time }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600 mb-1">السبب</p>
                    <p class="text-gray-800">{{ $appointment->reason ?? 'لم يتم تحديد السبب' }}</p>
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('doctor.appointment-detail', $appointment->id) }}" class="btn-primary text-sm py-2">
                        <i class="fas fa-eye ml-1"></i>التفاصيل
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8">
        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
        <p class="text-gray-600">لا توجد مواعيد اليوم</p>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <a href="{{ route('doctor.appointments') }}" class="card text-center hover:shadow-lg transition">
        <i class="fas fa-list text-4xl text-blue-600 mb-4"></i>
        <h3 class="font-bold text-gray-800 mb-2">جميع المواعيد</h3>
        <p class="text-gray-600">عرض جميع المواعيد</p>
    </a>
    
    <a href="{{ route('doctor.patient-records', auth()->user()->id) }}" class="card text-center hover:shadow-lg transition">
        <i class="fas fa-file-medical text-4xl text-teal-600 mb-4"></i>
        <h3 class="font-bold text-gray-800 mb-2">السجلات الطبية</h3>
        <p class="text-gray-600">عرض السجلات الطبية</p>
    </a>
</div>
@endsection