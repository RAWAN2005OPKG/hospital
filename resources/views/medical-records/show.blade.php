@extends('layouts.app')

@section('title', 'السجل الطبي')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card mb-8">
        <!-- Header -->
        <div class="border-b border-blue-100 pb-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold text-gray-800">السجل الطبي</h1>
                <a href="{{ route('patient.medical-records') }}" class="btn-outline text-sm">
                    <i class="fas fa-arrow-right ml-2"></i>العودة
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">الطبيب</p>
                    <p class="font-bold text-gray-800">د. {{ $record->doctor->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">التاريخ</p>
                    <p class="font-bold text-gray-800">{{ $record->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">التخصص</p>
                    <p class="font-bold text-gray-800">{{ $record->doctor->specialization->name }}</p>
                </div>
            </div>
        </div>
        
        <!-- Diagnosis -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-stethoscope ml-2 text-blue-600"></i>التشخيص
            </h2>
            <div class="bg-blue-50 p-6 rounded-lg text-gray-800 leading-relaxed">
                {{ $record->diagnosis }}
            </div>
        </div>
        
        <!-- Treatment -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-pills ml-2 text-teal-600"></i>العلاج الموصى به
            </h2>
            <div class="bg-teal-50 p-6 rounded-lg text-gray-800 leading-relaxed">
                {{ $record->treatment }}
            </div>
        </div>
        
        <!-- Prescription -->
        @if($record->prescription)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-prescription-bottle ml-2 text-green-600"></i>الأدوية
            </h2>
            <div class="bg-green-50 p-6 rounded-lg text-gray-800 leading-relaxed">
                {{ $record->prescription }}
            </div>
        </div>
        @endif
        
        <!-- Notes -->
        @if($record->notes)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-sticky-note ml-2 text-yellow-600"></i>ملاحظات إضافية
            </h2>
            <div class="bg-yellow-50 p-6 rounded-lg text-gray-800 leading-relaxed">
                {{ $record->notes }}
            </div>
        </div>
        @endif
        
        <!-- Actions -->
        <div class="border-t border-blue-100 pt-6 flex gap-4">
            <button class="btn-primary" onclick="window.print()">
                <i class="fas fa-print ml-2"></i>طباعة
            </button>
            <a href="#" class="btn-secondary">
                <i class="fas fa-download ml-2"></i>تحميل PDF
            </a>
        </div>
    </div>
</div>
@endsection