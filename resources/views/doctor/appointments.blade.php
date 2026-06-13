@extends('layouts.app')

@section('title', 'مواعيدي — MediFlow Gaza')

@section('content')
<div class="container" style="padding: 2rem 0;">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center mb-6">
            <i class="fas fa-calendar-alt ms-3 text-orange-500"></i>
            مواعيدي
        </h2>
        {{-- Filters --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <label class="font-semibold text-gray-900 dark:text-white">فلترة حسب:</label>
                    <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option>الكل</option>
                        <option>اليوم</option>
                        <option>هذا الأسبوع</option>
                        <option>هذا الشهر</option>
                    </select>
                    <input type="date" class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <button class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                    <i class="fas fa-sync-alt mr-2"></i>تحديث
                </button>
            </div>
        </div>

        {{-- Appointments Table --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">المريض</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الموعد</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">السبب</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($appointments ?? collect() as $appointment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-emerald-500 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ Str::upper(substr(optional($appointment->patient->user)->name ?? $appointment->patient->name ?? '', 0, 1)) }}
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-lg text-gray-900 dark:text-white">{{ optional($appointment->patient->user)->name ?? $appointment->patient->name ?? 'غير محدد' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ optional($appointment->patient->user)->phone ?? $appointment->patient->phone ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-semibold text-xl text-gray-900 dark:text-white">
                                    <div>{{ $appointment->appointment_time }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, j F') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    @php 
                                        $statusConfig = [
                                            'pending' => ['color' => 'yellow', 'icon' => 'clock', 'label' => 'معلق'],
                                            'confirmed' => ['color' => 'emerald', 'icon' => 'check-circle', 'label' => 'مؤكد'],
                                            'completed' => ['color' => 'blue', 'icon' => 'clipboard-check', 'label' => 'مكتمل'],
                                            'cancelled' => ['color' => 'red', 'icon' => 'times-circle', 'label' => 'ملغى']
                                        ];
                                        $status = $statusConfig[$appointment->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="px-6 py-3 bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 dark:bg-{{ $status['color'] }}-900/50 dark:text-{{ $status['color'] }}-200 rounded-2xl font-bold shadow-lg inline-flex items-center">
                                        <i class="fas fa-{{ $status['icon'] }} mr-2"></i>
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-700 dark:text-gray-300 max-w-md">
                                    {{ Str::limit($appointment->reason, 80) }}
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <a href="{{ route('doctor.appointment-detail', $appointment) }}" class="p-4 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-2xl hover:scale-110 transition-all shadow-md group-hover:bg-blue-200">
                                            <i class="fas fa-eye text-xl"></i>
                                        </a>
                                        <form method="POST" action="{{ route('doctor.update-appointment-status', $appointment->id) }}" class="inline">
                                            @csrf
                                            <select class="px-3 py-2 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>معلق</option>
                                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                            </select>
                                        </form>
                                        <a href="{{ route('doctor.medical-record.create', $appointment->id) }}" class="p-4 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-2xl hover:scale-110 transition-all shadow-md">
                                            <i class="fas fa-file-medical text-xl"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <i class="fas fa-calendar-xmark text-7xl text-gray-300 dark:text-gray-600 mb-8"></i>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا توجد مواعيد</h3>
                                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">ستظهر مواعيدك هنا بعد الحجوزات</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments ?? false)
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $appointments->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Smooth hover animations
        document.querySelectorAll('.hover:scale-110').forEach(el => {
            el.addEventListener('mouseenter', () => el.style.transform = 'scale(1.1)');
            el.addEventListener('mouseleave', () => el.style.transform = 'scale(1)');
        });
    </script>
</div>
@endsection
