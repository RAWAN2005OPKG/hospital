@extends('layouts.app')

@section('title', 'البحث عن الأطباء')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 flex items-center justify-center">
            <i class="fas fa-search-medical text-4xl text-emerald-600 mr-4"></i>
            البحث عن الأطباء
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            ابحث عن أفضل الأطباء المتخصصين في جميع التخصصات الطبية
        </p>
    </div>

    {{-- Search Filters --}}
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 mb-12">
        <form action="{{ route('appointments.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">البحث بالاسم</label>
                <input type="text" name="search" placeholder="ابحث عن طبيب..." 
                       class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg" 
                       value="{{ request('search') }}">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">القسم</label>
                <select name="department_id" class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg">
                    <option value="">جميع الأقسام</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">التخصص</label>
                <select name="specialization_id" class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg">
                    <option value="">جميع التخصصات</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec->id }}" {{ request('specialization_id') == $spec->id ? 'selected' : '' }}>
                            {{ $spec->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end space-x-3 rtl:space-x-reverse">
                <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl transition-all transform hover:-translate-y-1 text-lg">
                    <i class="fas fa-search mr-2 -ml-1"></i>
                    بحث
                </button>
                <button type="button" onclick="this.closest('form').reset();this.closest('form').submit();" class="px-8 py-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all text-lg">
                    مسح
                </button>
            </div>
        </form>
    </div>

    {{-- Doctors Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
        @forelse($doctors as $doctor)
            <div class="group bg-white dark:bg-gray-900 rounded-3xl shadow-2xl hover:shadow-3xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:-translate-y-3 transition-all duration-500 hover:border-emerald-200 dark:hover:border-emerald-800">
                {{-- Doctor Image --}}
                <div class="h-56 bg-gradient-to-br from-emerald-50 to-blue-50 dark:from-emerald-900/30 dark:to-blue-900/30 flex items-center justify-center relative overflow-hidden">
                    @if($doctor->image)
                        <img src="{{ asset('uploads/doctors/' . $doctor->image) }}" alt="{{ $doctor->user->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <i class="fas fa-user-md text-7xl text-emerald-500 group-hover:text-emerald-600 transition-colors"></i>
                    @endif
                </div>
                
                <div class="p-8">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">د. {{ $doctor->user->name }}</h3>
                            <p class="text-emerald-600 font-bold text-lg mb-1">{{ $doctor->specialization->name ?? '' }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-base">{{ $doctor->department->name ?? '' }}</p>
                        </div>
                        <div class="flex items-center bg-blue-100 dark:bg-blue-900/50 px-4 py-2 rounded-2xl">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span class="font-bold text-blue-700 dark:text-blue-300">4.9</span>
                        </div>
                    </div>
                    
                    <div class="mb-6 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-emerald-600"> {{ $doctor->consultation_fee ?? 200 }} ر.س </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">للاستشارة</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('doctors.show', $doctor->id) }}" class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-3xl shadow-xl hover:shadow-2xl transition-all text-center transform hover:-translate-y-1">
                            <i class="fas fa-eye mr-2"></i>التفاصيل
                        </a>
                        <a href="{{ route('appointments.create', $doctor->id) }}" class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 px-6 rounded-3xl shadow-xl hover:shadow-2xl transition-all text-center transform hover:-translate-y-1">
                            <i class="fas fa-calendar-plus mr-2"></i>احجز الآن
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-24">
                <i class="fas fa-user-md-slash text-8xl text-gray-300 dark:text-gray-600 mb-8"></i>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا توجد أطباء مطابقة</h3>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">جرب تعديل خيارات البحث أو ابحث بدون فلاتر</p>
                <button type="button" onclick="window.location.href='{{ route('appointments.search') }}'" class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:shadow-3xl text-white font-bold rounded-3xl shadow-2xl hover:-translate-y-1 transition-all">
                    <i class="fas fa-redo mr-2"></i>
                    إعادة البحث
                </button>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($doctors->hasPages())
    <div class="flex justify-center">
        {{ $doctors->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reset form
    const resetBtn = document.querySelector('[onclick*=\"reset\"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            this.closest('form').querySelectorAll('input, select').forEach(el => {
                if (el.tagName === 'INPUT') el.value = '';
                else el.selectedIndex = 0;
            });
            this.closest('form').submit();
        });
    }
});
</script>
@endsection

