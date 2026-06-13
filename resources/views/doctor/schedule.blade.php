@extends('layouts.app')

@section('title', 'جدول المواعيد — MediFlow Gaza')

@section('content')
<div class="container" style="padding: 2rem 0;">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center mb-6">
            <i class="fas fa-calendar-days ms-3 text-purple-500"></i>
            جدولة المواعيد
        </h2>

    <div class="max-w-6xl mx-auto space-y-8">
        {{-- Schedule Controls --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">التاريخ</label>
                    <input type="date" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 transition-all shadow-lg">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">مدة الموعد (دقائق)</label>
                    <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500">
                        <option>30</option>
                        <option>45</option>
                        <option>60</option>
                    </select>
                </div>
                <div class="space-y-3">
                    <button class="w-full px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                        <i class="fas fa-plus mr-2"></i>إضافة فترة توافر
                    </button>
                    <button class="w-full px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                        <i class="fas fa-sync-alt mr-2"></i>تحديث الجدول
                    </button>
                </div>
            </div>
        </div>

        {{-- Weekly Schedule --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Current Week Schedule --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-calendar-week mr-3 text-purple-500"></i>
                        هذا الأسبوع
                    </h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-7 gap-2 text-center">
                        @foreach(['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'] as $day)
                            <div class="p-4 rounded-xl {{ $loop->first ? 'bg-gradient-to-br from-emerald-500 to-teal-500 text-white font-bold shadow-lg' : 'bg-gray-50 dark:bg-gray-800 border hover:bg-gray-100 dark:hover:bg-gray-700 transition-all cursor-pointer' }}">
                                {{ $day }}
                                @if($loop->first)
                                    <div class="text-sm mt-1">09:00 - 17:00</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Available Slots --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-clock mr-3 text-orange-500"></i>
                    الفترات المتاحة اليوم
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @for($i = 9; $i < 18; $i += 1)
                        <div class="group p-4 bg-gradient-to-br from-emerald-50 to-blue-50 dark:from-emerald-900/30 dark:to-blue-900/30 rounded-2xl border-2 border-emerald-200 dark:border-emerald-800 hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer hover:border-emerald-400">
                            <div class="font-bold text-xl text-gray-900 dark:text-white mb-1 leading-tight">{{ sprintf('%02d:00', $i) }}</div>
                            <div class="flex items-center space-x-2 rtl:space-x-reverse text-xs text-emerald-700 dark:text-emerald-300">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                <span>متاح</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Monthly Calendar --}}
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-900 dark:to-blue-900/20 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="flex items-center justify-between mb-8">
                <button class="p-3 bg-white dark:bg-gray-800 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all shadow-md">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">يناير 2024</h3>
                <button class="p-3 bg-white dark:bg-gray-800 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all shadow-md">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <div class="grid grid-cols-7 gap-2 text-center text-sm">
                @foreach(range(1, 31) as $day)
                    <div class="p-4 h-24 rounded-2xl bg-white dark:bg-gray-800 border hover:shadow-md transition-all cursor-pointer {{ $day % 7 == 0 ? 'border-emerald-300 bg-emerald-50 dark:bg-emerald-900/30' : 'border-gray-200 dark:border-gray-700' }}">
                        <div class="font-bold text-lg mb-2">{{ $day }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">5 مواعيد</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Calendar interactions
        document.querySelectorAll('[class*="hover:-translate-y"]').forEach(el => {
            el.addEventListener('mouseenter', () => el.style.transform = 'translateY(-4px)');
            el.addEventListener('mouseleave', () => el.style.transform = 'translateY(0)');
        });

        // Date picker enhancements
        const dateInput = document.querySelector('input[type="date"]');
        dateInput?.addEventListener('change', (e) => {
            console.log('Selected date:', e.target.value);
            // Load schedule for selected date
        });
    </script>
</div>
@endsection
