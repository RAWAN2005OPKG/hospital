<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-calendar-alt mr-3 text-orange-500"></i>
            مواعيدي
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Filters --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <label class="font-semibold text-gray-900 dark:text-white">عرض حسب الحالة:</label>
                    <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option>الكل</option>
                        <option>معلق</option>
                        <option>مؤكد</option>
                        <option>مكتمل</option>
                        <option>ملغى</option>
                    </select>
                    
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <input type="date" class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <button class="px-8 py-3 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all whitespace-nowrap">
                            <i class="fas fa-filter mr-2"></i>فلترة
                        </button>
                    </div>
                </div>
                
                <a href="{{ route('appointments.search') }}" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    حجز موعد جديد
                </a>
            </div>
        </div>

        {{-- Appointments Table --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الموعد</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الطبيب</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">السبب</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($appointments ?? collect() as $appointment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
                                <td class="px-8 py-6 whitespace-nowrap font-semibold text-xl text-gray-900 dark:text-white">
                                    <div>{{ $appointment->appointment_time }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, j F Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ Str::upper(substr($appointment->doctor->user->name ?? '', 0, 1)) }}
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-lg text-gray-900 dark:text-white">{{ $appointment->doctor->user->name ?? 'غير محدد' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $appointment->doctor->specialization->name ?? 'غير محدد' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php $statusColor = match($appointment->status) {
                                        'pending' => 'yellow',
                                        'confirmed' => 'emerald', 
                                        'completed' => 'blue',
                                        'cancelled' => 'red',
                                        default => 'gray'
                                    }; @endphp
                                    <span class="px-6 py-2 bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 dark:bg-{{ $statusColor }}-900/50 dark:text-{{ $statusColor }}-200 rounded-2xl font-bold text-sm shadow-lg inline-flex items-center">
                                        <i class="fas fa-circle mr-2 text-xs"></i>
                                        {{ match($appointment->status) {
                                            'pending' => 'معلق',
                                            'confirmed' => 'مؤكد',
                                            'completed' => 'مكتمل',
                                            'cancelled' => 'ملغى',
                                            default => 'غير معروف'
                                        } }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-700 dark:text-gray-300 max-w-xs">
                                    {{ Str::limit($appointment->reason ?? 'فحص روتيني', 80) }}
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <a href="{{ route('patient.medical-record-detail', $appointment->id) }}" 
                                           class="p-3 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-2xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-eye text-xl"></i>
                                        </a>
                                        
                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{ route('patient.cancel-appointment', $appointment->id) }}" 
                                                  class="inline" onsubmit="return confirm('هل تريد إلغاء هذا الموعد؟ لا يمكن التراجع عن هذا الإجراء.')">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-2xl hover:scale-105 transition-all shadow-md">
                                                    <i class="fas fa-times text-xl"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('appointments.doctor-detail', $appointment->doctor_id) }}" 
                                           class="p-3 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-2xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-calendar-plus text-xl"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <i class="fas fa-calendar-times text-7xl text-gray-300 dark:text-gray-600 mb-8 mx-auto block"></i>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا توجد مواعيد</h3>
                                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">لم تسجل أي مواعيد بعد</p>
                                    <a href="{{ route('appointments.search') }}" 
                                       class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all">
                                        <i class="fas fa-plus mr-2"></i>
                                        حجز أول موعد
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="w-4 h-4 bg-yellow-500 rounded-full"></span>
                <span class="text-sm text-gray-700 dark:text-gray-300">معلق</span>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="w-4 h-4 bg-emerald-500 rounded-full"></span>
                <span class="text-sm text-gray-700 dark:text-gray-300">مؤكد</span>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="w-4 h-4 bg-blue-500 rounded-full"></span>
                <span class="text-sm text-gray-700 dark:text-gray-300">مكتمل</span>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="w-4 h-4 bg-red-500 rounded-full"></span>
                <span class="text-sm text-gray-700 dark:text-gray-300">ملغى</span>
            </div>
        </div>
    </div>

    <script>
        // Table row hover enhancement
        document.querySelectorAll('tr.group').forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.querySelectorAll('i').forEach(icon => {
                    icon.style.transform = 'scale(1.2)';
                });
            });
            row.addEventListener('mouseleave', () => {
                row.querySelectorAll('i').forEach(icon => {
                    icon.style.transform = 'scale(1)';
                });
            });
        });

        // Auto refresh every 30 seconds for pending appointments
        setInterval(() => {
            if (window.location.pathname.includes('appointments')) {
                window.location.reload();
            }
        }, 30000);
    </script>
</x-app-layout>

