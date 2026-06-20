@extends('layouts.app')
@section('title', __('messages.prescriptions_title'))

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-white dark:bg-gray-800 rounded-4xl shadow-2xl p-12 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-prescription-bottle-medical text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ __('messages.prescriptions_title') }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mt-2">{{ __('messages.prescriptions_subtitle') }}</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-base leading-relaxed">{{ __('messages.prescriptions_description') }}</p>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-400 text-lg"></i>
                <input type="text" placeholder="ابحث في الوصفات..." class="w-full pl-12 pr-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-lg">
            </div>
            <button class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-3xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-filter"></i>
                <span>تصفية</span>
            </button>
            <button class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-2 border-gray-200 dark:border-gray-700 font-bold rounded-3xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-print"></i>
                <span>طباعة</span>
            </button>
        </div>
    </div>

    <!-- Prescriptions Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @forelse($prescriptions ?? [] as $presc)
        <div class="mb-12">
            <div class="flex items-center justify-between mb-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center font-bold">
                        #{{ $presc->id }}
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800 dark:text-white">وصفة طبية</h2>
                        <p class="text-sm text-gray-500">{{ $presc->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>
                <div>
                    @if($presc->status === 'delivered')
                        <span class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-bold"><i class="fas fa-check-circle mr-1"></i> تم التسليم</span>
                    @else
                        <span class="px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-bold"><i class="fas fa-clock mr-1"></i> قيد الانتظار</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($presc->medicines as $medicine)
                <div class="bg-white dark:bg-gray-800 rounded-4xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:-translate-y-2 transition-all duration-300">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-700 dark:to-gray-600 px-6 py-5 border-b-2 border-gray-200 dark:border-gray-600 flex justify-between items-start">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-pills text-lg"></i>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="px-6 py-5 space-y-4">
                        <!-- Medicine Name -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $medicine->name }}</h3>
                        </div>

                        <!-- Dosage & Days -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-3 py-2 rounded-xl border border-emerald-200 dark:border-emerald-700">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">الجرعة</p>
                                <p class="text-sm font-bold text-emerald-700 dark:text-emerald-400">{{ $medicine->pivot->dosage ?? 'غير محدد' }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 px-3 py-2 rounded-xl border border-blue-200 dark:border-blue-700">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">المدة</p>
                                <p class="text-sm font-bold text-blue-700 dark:text-blue-400">{{ $medicine->pivot->days ?? 'غير محدد' }} أيام</p>
                            </div>
                        </div>

                        <!-- Instructions -->
                        @if(!empty($medicine->pivot->notes))
                        <div class="bg-gray-50 dark:bg-gray-900/20 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700">
                            <div class="flex gap-2">
                                <i class="fas fa-circle-info text-gray-600 dark:text-gray-400 mt-1 flex-shrink-0"></i>
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">تعليمات / ملاحظات</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $medicine->pivot->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Doctor Info -->
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr($presc->doctor->user->name ?? 'D', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500">وصف من</p>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">د. {{ $presc->doctor->user->name ?? 'غير معروف' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full text-center py-6 text-gray-500">لا توجد أدوية في هذه الوصفة.</div>
                @endforelse
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 p-16 text-center">
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-3xl flex items-center justify-center">
                    <i class="fas fa-capsules text-gray-400 text-5xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">لا توجد وصفات نشطة</h3>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-8">{{ __('messages.no_prescriptions') }}</p>
            <a href="{{ route('appointments.create') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-3xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                <i class="fas fa-calendar-plus mr-2"></i>
                {{ __('messages.book_new_appointment') }}
            </a>
        </div>
        @endforelse
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
