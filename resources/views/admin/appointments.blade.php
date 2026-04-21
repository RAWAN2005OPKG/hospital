<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-calendar-alt mr-3 text-blue-500"></i>
            جميع المواعيد
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Header Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-calendar-day text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $todayAppointments ?? 0 }}</div>
                <p class="opacity-90">اليوم</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-calendar-week text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $weekAppointments ?? 0 }}</div>
                <p class="opacity-90">هذا الأسبوع</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-calendar-month text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $monthAppointments ?? 0 }}</div>
                <p class="opacity-90">هذا الشهر</p>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                <div class="text-3xl font-bold text-yellow-200">{{ $pendingAppointments ?? 0 }}</div>
                <p class="opacity-90">معلقة</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" placeholder="ابحث بالاسم أو السبب..." class="px-4 py-3 border border-gray-300 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500">
                <select class="px-4 py-3 border border-gray-300 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500">
                    <option>الحالة</option>
                    <option>معلق</option>
                    <option>مؤكد</option>
                    <option>مكتمل</option>
                </select>
                <input type="date" class="px-4 py-3 border border-gray-300 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-orange-500">
                <select class="px-4 py-3 border border-gray-300 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500">
                    <option>الطبيب</option>
                </select>
                <button class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl">
                    <i class="fas fa-search mr-2"></i>فلترة
                </button>
            </div>
        </div>

        {{-- Appointments Table --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900/20">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">المريض</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الطبيب</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">التاريخ والوقت</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">السبب</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($appointments ?? collect() as $appointment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center text-white font-bold">
                                            {{ Str::upper(substr($appointment->patient->name ?? '', 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $appointment->patient->name ?? 'غير محدد' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-semibold text-indigo-600 dark:text-indigo-400">{{ $appointment->doctor->user->name ?? '-' }}</td>
                                <td class="px-8 py-6">
                                    <div class="font-bold">{{ $appointment->appointment_date }} - {{ $appointment->appointment_time }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    @php $status = $appointment->status; @endphp
                                    <span class="px-4 py-2 font-bold rounded-xl shadow-lg {{ 
                                        $status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50' : 
                                        $status == 'confirmed' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50' : 
                                        $status == 'completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50' : 
                                        'bg-red-100 text-red-800 dark:bg-red-900/50' 
                                    }}">
                                        {{ $status == 'pending' ? 'معلق' : ($status == 'confirmed' ? 'مؤكد' : ($status == 'completed' ? 'مكتمل' : 'ملغى')) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-700 dark:text-gray-300 max-w-md">{{ Str::limit($appointment->reason, 60) }}</td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <a href="#" class="p-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl hover:scale-105 transition-all">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="p-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-xl hover:scale-105 transition-all">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl hover:scale-105 transition-all">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-24 text-center">
                                    <i class="fas fa-calendar-xmark text-8xl text-gray-300 dark:text-gray-600 mb-8"></i>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">لا توجد مواعيد</h3>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments ?? false)
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>

        {{-- Status Legend --}}
        <div class="flex flex-wrap gap-4 justify-center lg:justify-start p-6 bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-900 dark:to-emerald-900/20 rounded-3xl">
            <div class="flex items-center space-x-2 rtl:space-x-reverse p-3 bg-yellow-100 rounded-2xl">
                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                <span class="font-semibold text-yellow-800">معلق</span>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse p-3 bg-emerald-100 rounded-2xl">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="font-semibold text-emerald-800">مؤكد</span>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse p-3 bg-blue-100 rounded-2xl">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="font-semibold text-blue-800">مكتمل</span>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse p-3 bg-red-100 rounded-2xl">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <span class="font-semibold text-red-800">ملغى</span>
            </div>
        </div>
    </div>

    <script>
        // Status color classes
        const statusColors = {
            'pending': 'bg-yellow-100 text-yellow-800',
            'confirmed': 'bg-emerald-100 text-emerald-800', 
            'completed': 'bg-blue-100 text-blue-800',
            'cancelled': 'bg-red-100 text-red-800'
        };
    </script>
</x-app-layout>
