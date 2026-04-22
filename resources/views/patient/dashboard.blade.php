@extends('layouts.app')

@section('title', 'لوحة تحكم المريض')

@section('content')
<div class="mb-8">
    <h1 class="section-title">مرحباً {{ auth()->user()->name }}</h1>
    <p class="text-gray-600 text-lg">لوحة تحكم المريض</p>
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">المواعيد القادمة</p>
                <p class="text-4xl font-bold text-blue-600">{{ $upcomingAppointments }}</p>
            </div>
            <i class="fas fa-calendar-check text-5xl text-blue-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">السجلات الطبية</p>
                <p class="text-4xl font-bold text-teal-600">{{ $medicalRecords }}</p>
            </div>
            <i class="fas fa-file-medical text-5xl text-teal-100"></i>
        </div>
    </div>
    
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">إجمالي المواعيد</p>
                <p class="text-4xl font-bold text-green-600">{{ $totalAppointments }}</p>
            </div>
            <i class="fas fa-history text-5xl text-green-100"></i>
        </div>
    </div>
</div>

<!-- Upcoming Appointments -->
<div class="card mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">المواعيد القادمة</h2>
    
    @if($appointments->count() > 0)
    <div class="space-y-4">
        @foreach($appointments as $appointment)
        <div class="border border-blue-200 rounded-2xl p-4 hover:bg-blue-50 transition">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <div>
                    <p class="text-sm text-gray-600 mb-1">الطبيب</p>
                    <h3 class="font-bold text-gray-800">د. {{ $appointment->doctor->user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $appointment->doctor->specialization->name }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600 mb-1">التاريخ والوقت</p>
                    <p class="font-bold text-gray-800">{{ $appointment->appointment_date->format('d/m/Y') }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->appointment_time }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600 mb-1">الحالة</p>
                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                        @else bg-red-100 text-red-800
                        @endif
                    ">
                        @if($appointment->status === 'pending') قيد الانتظار
                        @elseif($appointment->status === 'confirmed') مؤكد
                        @else ملغى
                        @endif
                    </span>
                </div>
                
                <div class="flex gap-2">
                    @if($appointment->status === 'pending')
                    <form action="{{ route('patient.cancel-appointment', $appointment->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-outline text-sm py-2" onclick="return confirm('هل تريد إلغاء؟')">
                            <i class="fas fa-times-circle ml-1"></i>إلغاء
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8">
        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 mb-4">لا توجد مواعيد قادمة</p>
        <a href="{{ route('doctors.index') }}" class="btn-primary inline-block">
            <i class="fas fa-calendar-check ml-2"></i>احجز موعد
        </a>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('doctors.index') }}" class="card text-center hover:shadow-lg transition">
        <i class="fas fa-search text-4xl text-blue-600 mb-4"></i>
        <h3 class="font-bold text-gray-800 mb-2">البحث عن طبيب</h3>
        <p class="text-gray-600 text-sm">ابحث عن الطبيب المناسب</p>
    </a>
    
    <a href="{{ route('patient.appointments') }}" class="card text-center hover:shadow-lg transition">
        <i class="fas fa-list text-4xl text-teal-600 mb-4"></i>
        <h3 class="font-bold text-gray-800 mb-2">جميع المواعيد</h3>
        <p class="text-gray-600 text-sm">عرض جميع المواعيد</p>
    </a>
    
    <a href="{{ route('patient.medical-records') }}" class="card text-center hover:shadow-lg transition">
        <i class="fas fa-file-medical text-4xl text-green-600 mb-4"></i>
        <h3 class="font-bold text-gray-800 mb-2">السجلات الطبية</h3>
        <p class="text-gray-600 text-sm">عرض السجلات الطبية</p>
    </a>
</div>
@endsection