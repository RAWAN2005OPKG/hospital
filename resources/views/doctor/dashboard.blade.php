@extends('layouts.app')

@section('title', 'لوحة تحكم الطبيب')

@section('content')
<div class="mb-8">
    <h1 class="section-title">مرحباً د. {{ auth()->user()->name }}</h1>
    <p class="text-gray-600 text-lg">لوحة تحكم الطبيب</p>
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">إجمالي المواعيد</p>
                <p class="text-4xl font-bold text-blue-600">{{ $totalAppointments }}</p>
            </div>
            <i class="fas fa-calendar-check text-5xl text-blue-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">مواعيد اليوم</p>
                <p class="text-4xl font-bold text-teal-600">{{ $todayAppointments }}</p>
            </div>
            <i class="fas fa-clock text-5xl text-teal-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">مكتملة</p>
                <p class="text-4xl font-bold text-green-600">{{ $completedAppointments }}</p>
            </div>
            <i class="fas fa-check-circle text-5xl text-green-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">قيد الانتظار</p>
                <p class="text-4xl font-bold text-yellow-600">{{ $pendingAppointments }}</p>
            </div>
            <i class="fas fa-hourglass-half text-5xl text-yellow-100"></i>
        </div>
    </div>
</div>

<!-- Doctor Schedule -->
<div class="card mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">جدول العمل الأسبوعي</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-50 to-teal-50">
                <tr>
                    <th class="px-4 py-3 text-right font-bold text-gray-800">اليوم</th>
                    <th class="px-4 py-3 text-right font-bold text-gray-800">البداية</th>
                    <th class="px-4 py-3 text-right font-bold text-gray-800">النهاية</th>
                    <th class="px-4 py-3 text-right font-bold text-gray-800">الراحة</th>
                    <th class="px-4 py-3 text-right font-bold text-gray-800">المواعيد</th>
                    <th class="px-4 py-3 text-right font-bold text-gray-800">الحالة</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                @endphp
                
                @forelse($schedules as $schedule)
                <tr class="border-b border-blue-100 hover:bg-blue-50">
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $days[$schedule->day_of_week] }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $schedule->start_time }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $schedule->end_time }}</td>
                    <td class="px-4 py-3 text-gray-700">
                        @if($schedule->break_start)
                            {{ $schedule->break_start }} - {{ $schedule->break_end }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                            {{ $schedule->appointments_count ?? 0 }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                            متاح
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-600">لا توجد أوقات عمل</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Today's Appointments -->
<div class="card">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">مواعيد اليوم</h2>
    
    @if($todayAppointmentsList->count() > 0)
    <div class="space-y-4">
        @foreach($todayAppointmentsList as $appointment)
        <div class="border border-blue-200 rounded-2xl p-4 hover:bg-blue-50 transition">
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
@endsection