<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-users mr-3 text-emerald-500"></i>
            المرضى
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Search & Filters --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="flex flex-wrap gap-4 items-end justify-between">
                <div class="flex-1 max-w-md">
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">البحث في المرضى</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="اسم المريض، الهاتف، أو البريد..." 
                               class="w-full pl-12 pr-8 py-4 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-lg">
                    </div>
                </div>
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500">
                        <option>الحالة الطبية</option>
                        <option>مكتمل</option>
                        <option>تحت المراقبة</option>
                        <option>جديد</option>
                    </select>
                    <button class="px-8 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                        <i class="fas fa-filter mr-2"></i>فلترة
                    </button>
                </div>
            </div>
        </div>

        {{-- Patients Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-users text-5xl mb-4"></i>
                <div class="text-4xl font-bold">{{ $totalPatients ?? 0 }}</div>
                <div class="opacity-90">إجمالي المرضى</div>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-user-plus text-5xl mb-4"></i>
                <div class="text-4xl font-bold">{{ $newPatients ?? 0 }}</div>
                <div class="opacity-90">مرضى جدد</div>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-heartbeat text-5xl mb-4"></i>
                <div class="text-4xl font-bold">{{ $activePatients ?? 0 }}</div>
                <div class="opacity-90">نشط حالياً</div>
            </div>
        </div>

        {{-- Patients Table --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الاسم</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الهاتف</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">آخر زيارة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">السجلات</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($patients ?? collect() as $patient)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl flex items-center justify-center text-white font-bold text-lg shadow-xl flex-shrink-0">
                                            {{ Str::upper(substr($patient->name, 0, 2)) }}
                                        </div>
                                        <div class="text-right min-w-0 flex-1">
                                            <div class="font-bold text-lg text-gray-900 dark:text-white truncate" title="{{ $patient->name }}">{{ $patient->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $patient->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-mono text-gray-900 dark:text-white">
                                    {{ $patient->phone ?? '-' }}
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $patient->last_visit ? \Carbon\Carbon::parse($patient->last_visit)->format('d M Y') : 'لم يزر' }}
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-2 bg-gradient-to-r from-emerald-100 to-blue-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-200 rounded-xl font-semibold shadow-md inline-flex items-center">
                                        <i class="fas fa-heartbeat mr-1 text-xs"></i>
                                        مستقر
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-sm font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $patient->records_count ?? 0 }} سجل
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <a href="#" class="p-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl hover:scale-105 transition-all shadow-md flex-1 text-center group-hover:bg-blue-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="p-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-xl hover:scale-105 transition-all shadow-md flex-1 text-center">
                                            <i class="fas fa-file-medical"></i>
                                        </a>
                                        <a href="#" class="p-3 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-xl hover:scale-105 transition-all shadow-md flex-1 text-center">
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-24 text-center">
                                    <i class="fas fa-users-slash text-8xl text-gray-300 dark:text-gray-600 mb-8 mx-auto block"></i>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا يوجد مرضى بعد</h3>
                                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">سيتم إضافة المرضى تلقائياً عند حجزهم لمواعيد</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($patients ?? false)
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $patients->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Search functionality (client-side)
        const searchInput = document.querySelector('input[placeholder*="اسم المريض"]');
        searchInput?.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // Smooth animations
        document.querySelectorAll('.hover:scale-105').forEach(el => {
            el.addEventListener('mouseenter', () => el.style.transform = 'scale(1.05)');
            el.addEventListener('mouseleave', () => el.style.transform = 'scale(1)');
        });
    </script>
</x-app-layout>
