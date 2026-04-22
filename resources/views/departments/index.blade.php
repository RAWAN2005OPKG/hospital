@extends('layouts.app')

@section('title', 'الأقسام - صحتي')

@section('content')
<div class="mb-8">
    <h1 class="section-title">الأقسام الطبية</h1>
    <p class="section-subtitle">استكشف جميع أقسامنا الطبية المتخصصة</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($departments as $department)
    <div class="card hover:shadow-2xl transition">
        <div class="h-48 bg-gradient-to-br from-blue-100 to-teal-100 rounded-2xl flex items-center justify-center mb-4">
            <i class="fas fa-hospital text-6xl text-blue-600"></i>
        </div>
        
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $department->name }}</h3>
        <p class="text-gray-600 mb-4">{{ $department->description }}</p>
        
        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
            <span><i class="fas fa-user-md ml-1"></i>{{ $department->doctors_count }} طبيب</span>
        </div>
        
        <a href="{{ route('departments.show', $department->id) }}" class="btn-primary w-full text-center">
            <i class="fas fa-arrow-left ml-2"></i>اعرف المزيد
        </a>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">لا توجد أقسام</p>
    </div>
    @endforelse
</div>
@endsection