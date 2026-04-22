@extends('layouts.app')

@section('title', 'الأطباء - صحتي')

@section('content')
<div class="mb-12">
    <h1 class="section-title">الأطباء المتخصصون</h1>
    <p class="text-gray-600 text-lg">اختر الطبيب المناسب لك</p>
</div>

<!-- Search & Filters -->
<div class="card mb-8">
    <form action="{{ route('doctors.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">البحث</label>
            <input type="text" name="search" placeholder="ابحث عن طبيب..." class="input-field" value="{{ request('search') }}">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">القسم</label>
            <select name="department_id" class="input-field">
                <option value="">اختر قسماً</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @selected(request('department_id') == $dept->id)>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">التخصص</label>
            <select name="specialization_id" class="input-field">
                <option value="">اختر تخصصاً</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->id }}" @selected(request('specialization_id') == $spec->id)>
                        {{ $spec->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                <i class="fas fa-search ml-2"></i>بحث
            </button>
        </div>
    </form>
</div>

<!-- Doctors Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @forelse($doctors as $doctor)
    <div class="card hover:shadow-2xl transition overflow-hidden">
        <div class="h-48 bg-gradient-to-br from-blue-100 to-teal-100 flex items-center justify-center relative">
            <i class="fas fa-user-md text-6xl text-blue-600"></i>
            <div class="absolute top-4 left-4 green-dot">
                <i class="fas fa-star text-white"></i>
            </div>
        </div>
        
        <div class="pt-4">
            <h3 class="text-xl font-bold text-gray-800 mb-1">د. {{ $doctor->user->name }}</h3>
            <p class="text-teal-600 font-semibold mb-1">{{ $doctor->specialization->name }}</p>
            <p class="text-gray-600 text-sm mb-2">{{ $doctor->department->name }}</p>
            
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-blue-100">
                <div class="flex items-center">
                    @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                    @endfor
                    <span class="ml-2 text-gray-700 text-sm">4.8</span>
                </div>
                <span class="text-blue-600 font-bold">{{ $doctor->consultation_fee }} ر.س</span>
            </div>
            
            <p class="text-sm text-gray-600 mb-4">
                <i class="fas fa-briefcase ml-1"></i>{{ $doctor->experience_years }} سنة خبرة
            </p>
            
            <div class="flex gap-2">
                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn-outline flex-1 text-center text-sm py-2">
                    <i class="fas fa-info-circle ml-1"></i>التفاصيل
                </a>
                <a href="{{ route('appointments.create', $doctor->id) }}" class="btn-primary flex-1 text-center text-sm py-2">
                    <i class="fas fa-calendar-check ml-1"></i>احجز
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">لم يتم العثور على أطباء</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="flex justify-center">
    {{ $doctors->links() }}
</div>
@endsection