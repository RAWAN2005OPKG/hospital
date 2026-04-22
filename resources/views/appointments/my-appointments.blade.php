@extends('layouts.app')

@section('title', 'مواعيدي')

@section('content')
<div class="mb-8">
    <h1 class="section-title">مواعيدي</h1>
    <p class="section-subtitle">إدارة وتتبع جميع مواعيدك الطبية</p>
</div>

<!-- Tabs -->
<div class="flex gap-4 mb-8 border-b border-blue-200">
    <button class="px-6 py-3 font-bold text-blue-600 border-b-2 border-blue-600">جميع المواعيد</button>
    <button class="px-6 py-3 font-bold text-gray-600 hover:text-blue-600">قادمة</button>
    <button class="px-6 py-3 font-bold text-gray-600 hover:text-blue-600">مكتملة</button>
</div>

<!-- Appointments List -->
<div class="space-y-4">
    @forelse($appointments as $appointment)
    <div class="card">
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
                    @if($appointment->isPending()) bg-yellow-100 text-yellow-800
                    @elseif($appointment->isConfirmed()) bg-blue-100 text-blue-800
                    @elseif($appointment->isCompleted()) bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif
                ">
                    @if($appointment->isPending()) قيد الانتظار
                    @elseif($appointment->isConfirmed()) مؤكد
                    @elseif($appointment->isCompleted()) مكتمل
                    @else ملغى
                    @endif
                </span>
            </div>
            
            <div class="flex gap-2">
                @if($appointment->medicalRecord)
                <a href="{{ route('patient.medical-record-detail', $appointment->medicalRecord->id) }}" class="btn-secondary text-sm py-2">
                    <i class="fas fa-file-medical ml-1"></i>التقرير
                </a>
                @endif
                
                @if($appointment->isPending())
                <form action="{{ route('patient.cancel-appointment', $appointment->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-outline text-sm py-2" onclick="return confirm('هل تريد إلغاء الموعد؟')">
                        <i class="fas fa-times-circle ml-1"></i>إلغاء
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="card text-center py-12">
        <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">لا توجد مواعيد</p>
        <a href="{{ route('appointments.search') }}" class="btn-primary mt-4 inline-block">
            <i class="fas fa-calendar-check ml-2"></i>احجز موعد
        </a>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="flex justify-center mt-8">
    {{ $appointments->links() }}
</div>
@endsection