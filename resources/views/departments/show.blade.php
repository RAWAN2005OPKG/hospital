@extends('layouts.app')

@section('title', '{{ $department->name }} - الأطباء')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-16">
            @if($department->image)
                <div class="w-full h-64 md:h-96 bg-cover bg-center rounded-3xl shadow-2xl mb-8 overflow-hidden" style="background-image: url('{{ Storage::url($department->image) }}');"></div>
            @endif
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                {{ $department->name }}
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                {{ $department->description }}
            </p>
        </div>

        {{-- Doctors Grid --}}
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12 text-center">
                {{ $doctors->total() }} طبيب متخصص في {{ $department->name }}
            </h2>
            
            @if($doctors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($doctors as $doctor)
                        <div class="group bg-white dark:bg-gray-900 rounded-3xl shadow-2xl hover:shadow-3xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:-translate-y-2 transition-all duration-500">
                            <div class="h-56 bg-gradient-to-br from-emerald-50 to-blue-50 dark:from-emerald-900/30 dark:to-blue-900/30 flex items-center justify-center relative overflow-hidden">
                                @if($doctor->image)
                                    <img src="{{ asset('uploads/doctors/' . $doctor->image) }}" alt="{{ $doctor->user->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                @else
                                    <i class="fas fa-user-md text-6xl text-emerald-500 group-hover:text-emerald-600 transition-colors"></i>
                                @endif
                            </div>
                            <div class="p-8">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ $doctor->user->name }}</h3>
                                <p class="text-emerald-600 font-bold text-xl mb-4">{{ $doctor->specialization->name }}</p>
                                <div class="flex items-center mb-6">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span class="font-bold text-gray-700 dark:text-gray-300">4.9</span>
                                </div>
                                <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('doctors.show', $doctor) }}" class="flex-1 text-center py-3 px-6 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                                        التفاصيل
                                    </a>
                                    <a href="{{ route('appointments.create', $doctor) }}" class="flex-1 text-center py-3 px-6 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                                        حجز موعد
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center mt-16">
                    {{ $doctors->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-24">
                    <i class="fas fa-user-md text-8xl text-gray-300 dark:text-gray-600 mb-8"></i>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا يوجد أطباء في هذا القسم حالياً</h3>
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-12">سيتم إضافة الأطباء قريباً</p>
                    <a href="{{ route('doctors.index') }}" class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-emerald-600 to-blue-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl transition-all">
                        تصفح جميع الأطباء
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

