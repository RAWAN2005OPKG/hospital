<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-tachometer-alt mr-3 text-indigo-500"></i>
            لوحة تحكم الإدارة
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Main Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-indigo-500 to-blue-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-hospital text-5xl mb-4 opacity-90 group-hover:rotate-12 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $totalDoctors ?? 0 }}</div>
                <div class="text-indigo-100">الأطباء</div>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-users text-5xl mb-4 opacity-90 group-hover:rotate-12 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $totalPatients ?? 0 }}</div>
                <div class="text-emerald-100">المرضى</div>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-calendar-check text-5xl mb-4 opacity-90 group-hover:rotate-12 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $todayAppointments ?? 0 }}</div>
                <div class="text-orange-100">المواعيد اليوم</div>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center group">
                <i class="fas fa-chart-pie text-5xl mb-4 opacity-90 group-hover:rotate-12 transition-transform"></i>
                <div class="text-4xl font-bold mb-1">{{ $revenueToday ?? 0 }} ر.س</div>
                <div class="text-purple-100">الإيرادات اليوم</div>
            </div>
        </div>

        {{-- Charts Dashboard --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Revenue Chart --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-chart-line mr-3 text-green-500"></i>
                    الإيرادات الشهرية
                </h3>
                <canvas id="revenueChart" height="120"></canvas>
            </div>

            {{-- Appointments Trend --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-calendar mr-3 text-blue-500"></i>
                    اتجاه المواعيد
                </h3>
                <canvas id="appointmentsTrendChart" height="120"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Doctors Performance --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-stethoscope mr-3 text-indigo-500"></i>
                    أداء الأطباء هذا الأسبوع
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl">
                            <tr>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الطبيب</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">المواعيد</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">المكتملة</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإيرادات</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">التقييم</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse($topDoctors ?? collect() as $doctor)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                                {{ Str::upper(substr($doctor->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $doctor->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-emerald-600 font-semibold">{{ $doctor->appointments }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            <div class="flex space-x-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-yellow-400 text-sm {{ $i <= $doctor->rating ? '' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $doctor->completed }}/{{ $doctor->total }})</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono font-semibold text-green-600">{{ $doctor->revenue }} ر.س</td>
                                    <td class="px-6 py-4">
                                        <span class="px-4 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-xl font-bold text-sm shadow">ممتاز</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-12 text-center text-gray-500 dark:text-gray-400">لا توجد بيانات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 space-y-4">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-bell mr-3 text-orange-500"></i>
                    آخر النشاطات
                </h3>
                @forelse($recentActivities ?? collect() as $activity)
                    <div class="flex items-start space-x-4 rtl:space-x-reverse p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-emerald-500 rounded-2xl flex items-center justify-center text-white font-bold text-sm shadow-lg flex-shrink-0 mt-0.5">
                            {{ Str::upper(substr($activity->user_name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white text-sm leading-tight">{{ $activity->action }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $activity->timestamp }}</p>
                        </div>
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse flex-shrink-0 mt-2"></div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-6xl mb-4 opacity-50"></i>
                        <p>لا توجد نشاطات حديثة</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#" class="group bg-gradient-to-br from-indigo-500 to-blue-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm scale-110 group-hover:scale-100 transition-transform"></div>
                <i class="fas fa-user-plus text-4xl mb-4 relative z-10 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-xl font-bold mb-2 relative z-10">إضافة طبيب</h3>
                <p class="opacity-90 relative z-10">إدارة الأطباء</p>
            </a>
            <a href="#" class="group bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm scale-110 group-hover:scale-100 transition-transform"></div>
                <i class="fas fa-users text-4xl mb-4 relative z-10 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-xl font-bold mb-2 relative z-10">إدارة المرضى</h3>
                <p class="opacity-90 relative z-10">عرض جميع المرضى</p>
            </a>
            <a href="#" class="group bg-gradient-to-br from-orange-500 to-red-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm scale-110 group-hover:scale-100 transition-transform"></div>
                <i class="fas fa-calendar text-4xl mb-4 relative z-10 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-xl font-bold mb-2 relative z-10">المواعيد</h3>
                <p class="opacity-90 relative z-10">عرض المواعيد</p>
            </a>
            <a href="#" class="group bg-gradient-to-br from-purple-500 to-pink-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-3 transition-all text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm scale-110 group-hover:scale-100 transition-transform"></div>
                <i class="fas fa-chart-bar text-4xl mb-4 relative z-10 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-xl font-bold mb-2 relative z-10">التقارير</h3>
                <p class="opacity-90 relative z-10">إحصائيات وتحليلات</p>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['1', '5', '10', '15', '20', '25', '30'],
                    datasets: [{
                        label: 'الإيرادات',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 4,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: { color: 'gray' }
                        },
                        x: { grid: { display: false }, ticks: { color: 'gray' } }
                    }
                }
            });
        }

        // Appointments Trend Chart
        const trendCtx = document.getElementById('appointmentsTrendChart')?.getContext('2d');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'doughnut',
                data: {
                    labels: ['مؤكد', 'معلق', 'مكتمل', 'ملغى'],
                    datasets: [{
                        data: [65, 20, 10, 5],
                        backgroundColor: [
                            'rgb(34, 197, 94)',
                            'rgb(251, 191, 36)',
                            'rgb(59, 130, 246)',
                            'rgb(239, 68, 68)'
                        ],
                        borderWidth: 0,
                        cutout: '65%'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { 
                        position: 'bottom',
                        labels: { 
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    } }
                }
            });
        }
    </script>
</x-app-layout>
