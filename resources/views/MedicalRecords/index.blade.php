@extends('layouts.app')
@section('title', 'السجلات الطبية')

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-white dark:bg-gray-800 rounded-4xl shadow-2xl p-12 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-file-medical text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">السجلات الطبية</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mt-2">تاريخك الطبي الكامل والتقارير والفحوصات</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-base leading-relaxed">تابع كافة تقاريرك الطبية ونتائج الفحوصات في مكان واحد آمن وسهل الوصول إليه</p>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-400 text-lg"></i>
                <input type="text" placeholder="ابحث في السجلات..." class="w-full pl-12 pr-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-lg">
            </div>
            <button class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-3xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-filter"></i>
                <span>تصفية</span>
            </button>
            <button class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-2 border-gray-200 dark:border-gray-700 font-bold rounded-3xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-download"></i>
                <span>تحميل</span>
            </button>
        </div>
    </div>

    <!-- Records Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-4xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 px-8 py-6 border-b-2 border-gray-200 dark:border-gray-600">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                        <i class="fas fa-calendar text-blue-500"></i>
                        التاريخ
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                        <i class="fas fa-stethoscope text-emerald-500"></i>
                        التشخيص
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                        <i class="fas fa-user-md text-purple-500"></i>
                        الطبيب
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                        <i class="fas fa-hospital text-orange-500"></i>
                        القسم
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                        <i class="fas fa-cogs text-gray-500"></i>
                        الإجراءات
                    </div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($records ?? [] as $record)
                <div class="px-8 py-6 hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-200">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                        <!-- Date -->
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $record->created_at->format('d/m/Y') }}</span>
                        </div>

                        <!-- Diagnosis -->
                        <div>
                            <span class="inline-block px-4 py-2 bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 font-bold rounded-2xl text-sm">
                                {{ $record->diagnosis }}
                            </span>
                        </div>

                        <!-- Doctor -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($record->doctor->user->name, 0, 1) }}
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $record->doctor->user->name }}</span>
                        </div>

                        <!-- Department -->
                        <div>
                            <span class="inline-block px-4 py-2 bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300 font-bold rounded-2xl text-sm">
                                {{ $record->doctor->department->name }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 justify-end">
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition-all hover:shadow-lg flex items-center gap-2">
                                <i class="fas fa-eye"></i>
                                <span class="hidden sm:inline">عرض</span>
                            </button>
                            <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-bold rounded-2xl transition-all hover:shadow-lg flex items-center gap-2">
                                <i class="fas fa-download"></i>
                                <span class="hidden sm:inline">تحميل</span>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-8 py-16 text-center">
                    <div class="flex justify-center mb-6">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-3xl flex items-center justify-center">
                            <i class="fas fa-folder-open text-gray-400 text-5xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">لا توجد سجلات</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">لا توجد سجلات طبية متاحة حالياً</p>
                    <button class="mt-6 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-3xl transition-all hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        حجز موعد جديد
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
