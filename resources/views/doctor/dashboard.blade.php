<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-stethoscope mr-3 text-blue-500"></i>
            لوحة تحكم الطبيب
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-users text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $patientsToday ?? 0 }}</div>
                <div class="text-emerald-100 text-sm">المرضى اليوم</div>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-calendar-check text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $appointmentsToday ?? 0 }}</div>
                <div class="text-blue-100 text-sm">المواعيد اليوم</div>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-chart-line text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $revenueThisMonth ?? 0 }} ر.س</div>
                <div class="text-orange-100 text-sm">الإيرادات هذا الشهر</div>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-clock text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $nextAppointmentTime ?? 'غير محدد' }}</div>
                <div class="text-purple-100 text-sm">الموعد القادم</div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Appointments Chart --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-blue-500"></i>
                    إحصائيات المواعيد الأسبوعية
                </h3>
                <canvas id="appointmentsChart" height="100"></canvas>
            </div>

            {{-- Patients Status --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-user-check mr-3 text-emerald-500"></i>
                    حالة المرضى
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/30 dark:to-blue-900/30 rounded-2xl">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center font-bold shadow-lg">85%</div>
                            <div>
                                <div class="font-bold text-xl text-gray-900 dark:text-white">مكتمل</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">من المواعيد</div>
                            </div>
                        </div>
                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/30 dark:to-orange-900/30 rounded-2xl">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <div class="w-12 h-12 bg-yellow-500 text-white rounded-2xl flex items-center justify-center font-bold shadow-lg">12%</div>
                            <div>
                                <div class="font-bold text-xl text-gray-900 dark:text-white">معلق</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">يتطلب متابعة</div>
                            </div>
                        </div>
                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Appointments --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-calendar-alt mr-3 text-orange-500"></i>
                    المواعيد القادمة
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">المريض</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الوقت</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($recentAppointments ?? collect() as $appointment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ Str::upper(substr($appointment->patient->name ?? '', 0, 1)) }}
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-lg text-gray-900 dark:text-white">{{ $appointment->patient->name ?? 'غير محدد' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($appointment->reason, 40) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-semibold text-xl text-gray-900 dark:text-white">
                                    <div>{{ $appointment->appointment_time }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-2 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-200 rounded-2xl font-bold text-sm shadow-lg inline-flex items-center">
                                        <i class="fas fa-clock mr-2"></i>قادم
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <a href="#" class="p-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-2xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-eye text-xl"></i>
                                        </a>
                                        <a href="#" class="p-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-2xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-edit text-xl"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <i class="fas fa-calendar-times text-7xl text-gray-300 dark:text-gray-600 mb-8"></i>
                                    <p class="text-xl text-gray-600 dark:text-gray-400">لا توجد مواعيد قادمة</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('doctor.appointments') }}" class="group bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-10 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center">
                <i class="fas fa-calendar-check text-5xl mb-6 opacity-90 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-bold mb-2">عرض المواعيد</h3>
                <p class="opacity-90">إدارة مواعيدك اليومية</p>
            </a>
            <a href="{{ route('doctor.patients') }}" class="group bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-10 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center">
                <i class="fas fa-users text-5xl mb-6 opacity-90 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-bold mb-2">المرضى</h3>
                <p class="opacity-90">سجل المرضى والمتابعة</p>
            </a>
            <a href="{{ route('doctor.schedule') }}" class="group bg-gradient-to-br from-purple-500 to-pink-600 text-white p-10 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center">
                <i class="fas fa-clock text-5xl mb-6 opacity-90 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-bold mb-2">جدولة المواعيد</h3>
                <p class="opacity-90">تحديث توافرك</p>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Appointments Chart
        const ctx = document.getElementById('appointmentsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
                datasets: [{
                    label: 'عدد المواعيد',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderRadius: 12,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
                }
            }
        });

        // Table hover effects
        document.querySelectorAll('tr.group').forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.querySelectorAll('i').forEach(icon => icon.style.transform = 'scale(1.2)');
            });
            row.addEventListener('mouseleave', () => {
                row.querySelectorAll('i').forEach(icon => icon.style.transform = 'scale(1)');
            });
        });
    </script>
</x-app-layout>
