<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-chart-bar mr-3 text-green-500"></i>
            التقارير والإحصائيات
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Report Controls --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4 items-end">
                <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500">
                    <option>النوع</option>
                    <option>إيرادات</option>
                    <option>مواعيد</option>
                    <option>أطباء</option>
                    <option>مرضى</option>
                    <option>أقسام</option>
                </select>
                <input type="date" class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500">
                <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500">
                    <option>المدة</option>
                    <option>اليوم</option>
                    <option>الأسبوع</option>
                    <option>الشهر</option>
                    <option>السنة</option>
                </select>
                <button class="px-10 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl md:col-span-2 lg:col-span-1">
                    <i class="fas fa-download mr-2"></i>عرض التقرير
                </button>
                <button class="px-10 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl">
                    <i class="fas fa-file-pdf mr-2"></i>تصدير PDF
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            {{-- Main Revenue Chart --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 order-2 xl:order-1">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                    <i class="fas fa-chart-line mr-3 text-green-500"></i>
                    الإيرادات الشهرية
                </h3>
                <div class="h-96">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Department Performance --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 order-1 xl:order-2">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-hospital mr-3 text-orange-500"></i>
                    أداء الأقسام
                </h3>
                <div class="space-y-4">
                    @forelse($departmentsPerformance ?? collect() as $dept)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-2xl group hover:shadow-lg transition-all">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ Str::upper(substr($dept->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">{{ $dept->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $dept->doctors_count }} طبيب</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $dept->revenue }} ر.س</div>
                                <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden mx-auto mb-2">
                                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full shadow-inner" style="width: {{ $dept->percentage }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">{{ $dept->percentage }}%</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <i class="fas fa-chart-bar text-8xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <p class="text-gray-600 dark:text-gray-400">لا توجد بيانات للعرض</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Doctor Rankings --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-trophy mr-3 text-yellow-500"></i>
                        ترتيب الأطباء حسب الإيرادات
                    </h3>
                    <div class="space-y-3">
                        @forelse($topDoctors ?? collect() as $index => $doctor)
                            <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl group hover:shadow-md transition-all">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 text-white font-bold text-xl rounded-2xl flex items-center justify-center shadow-2xl mr-4 flex-shrink-0">
                                    #{{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-lg text-gray-900 dark:text-white flex items-center">
                                        {{ $doctor->name }}
                                        <span class="ml-2 px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg">{{ $doctor->specialization }}</span>
                                    </div>
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        <span>{{ $doctor->appointments }} موعد</span>
                                        <span>{{ $doctor->patients }} مريض</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $doctor->revenue }} ر.س</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <i class="fas fa-trophy text-8xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <p>لا توجد بيانات للترتيب</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white p-8 rounded-3xl shadow-2xl text-center">
                    <i class="fas fa-arrow-trend-up text-4xl mb-4"></i>
                    <div class="text-3xl font-bold">+27%</div>
                    <p class="opacity-90">نمو الإيرادات</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl text-center">
                    <i class="fas fa-users text-4xl mb-4"></i>
                    <div class="text-3xl font-bold">{{ $newPatientsThisMonth ?? 0 }}</div>
                    <p class="opacity-90">مرضى جدد</p>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-blue-600 text-white p-8 rounded-3xl shadow-2xl text-center">
                    <i class="fas fa-clock text-4xl mb-4"></i>
                    <div class="text-3xl font-bold">{{ $avgAppointmentTime ?? '12'} دقيقة</div>
                    <p class="opacity-90">متوسط موعد</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1', '8', '15', '22', '28'],
                    datasets: [{
                        label: 'الإيرادات (ألف ر.س)',
                        data: [12, 19, 30, 25, 38],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 4,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 8,
                        pointHoverRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: { color: 'gray' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: 'gray' }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
