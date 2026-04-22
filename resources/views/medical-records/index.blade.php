@extends('layouts.app')

@section('title', 'السجلات الطبية')

@section('content')
<div class="mb-8">
    <h1 class="section-title">سجلاتي الطبية</h1>
    <p class="section-subtitle">عرض ومتابعة جميع سجلاتك الطبية</p>
</div>

<!-- Records List -->
<div class="space-y-4">
    @forelse($records as $record)
    <div class="card hover:shadow-lg transition">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div>
                <p class="text-sm text-gray-600 mb-1">الطبيب</p>
                <h3 class="font-bold text-gray-800">د. {{ $record->doctor->user->name }}</h3>
                <p class="text-sm text-gray-600">{{ $record->doctor->specialization->name }}</p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600 mb-1">التاريخ</p>
                <p class="font-bold text-gray-800">{{ $record->created_at->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-600">{{ $record->created_at->format('H:i') }}</p>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('patient.medical-record-detail', $record->id) }}" class="btn-primary text-sm py-2">
                    <i class="fas fa-eye ml-1"></i>عرض
                </a>
                <a href="#" class="btn-secondary text-sm py-2">
                    <i class="fas fa-download ml-1"></i>تحميل
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="card text-center py-12">
        <i class="fas fa-file-medical text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">لا توجد سجلات طبية</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="flex justify-center mt-8">
    {{ $records->links() }}
</div>
@endsection