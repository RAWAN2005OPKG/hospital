<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-users mr-3 text-emerald-500"></i>
            إدارة المرضى
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Header --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">جميع المرضى</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $patients->total() ?? 0 }} مريض مسجل</p>
            </div>
            <button class="px-10 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all self-start sm:self-auto">
                <i class="fas fa-plus mr-2"></i>مريض جديد
            </button>
        </div>

        {{-- Filters & Search --}}
        <div class="bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-3xl shadow-xl border border-emerald-200 dark:border-emerald-800 p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                    <input type="text" placeholder="ابحث بالاسم أو الهاتف..." class="w-full pl-12 pr-4 py-4 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500 shadow-lg transition-all">
                </div>
                <select class="px-4 py-4 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500">
                    <option>الحالة</option>
                    <option>نشط</option>
                    <option>غير نشط</option>
                    <option>تحت المراقبة</option>
                </select>
                <input type="date" class="px-4 py-4 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-orange-500">
                <button class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                    <i class="fas fa-filter mr-2"></i>البحث
                </button>
            </div>
        </div>

        {{-- Patients Table --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الاسم</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الهاتف</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">البريد الإلكتروني</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">آخر موعد</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">السجلات الطبية</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($patients ?? collect() as $patient)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl flex items-center justify-center text-white font-bold text-lg shadow-2xl">
                                            {{ Str::upper(substr($patient->name, 0, 2)) }}
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-lg text-gray-900 dark:text-white truncate" title="{{ $patient->name }}">{{ $patient->name }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $patient->age ?? 'غير محدد' }} سنة</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-mono text-gray-900 dark:text-white">{{ $patient->phone ?? '-' }}</td>
                                <td class="px-8 py-6 text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate" title="{{ $patient->email }}">{{ $patient->email }}</td>
                                <td class="px-8 py-6 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $patient->last_appointment ? \Carbon\Carbon::parse($patient->last_appointment)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-6 font-bold text-emerald-600 dark:text-emerald-400">{{ $patient->records_count ?? 0 }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-2 bg-gradient-to-r from-emerald-100 to-blue-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-200 rounded-xl font-semibold shadow-md">
                                        <i class="fas fa-circle mr-1 text-emerald-500"></i>نشط
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <a href="#" class="p-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-eye text-xl"></i>
                                        </a>
                                        <a href="#" class="p-3 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-file-invoice text-xl"></i>
                                        </a>
                                        <a href="#" class="p-3 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-edit text-xl"></i>
                                        </a>
                                        <button class="p-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-trash text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-24 text-center">
                                    <i class="fas fa-users-slash text-9xl text-gray-300 dark:text-gray-600 mb-8"></i>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا يوجد مرضى</h3>
                                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">سيتم إضافة المرضى عند حجزهم لمواعيد</p>
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

        {{-- Patient Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-calendar-heart text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $patientsWithAppointments ?? 0 }}</div>
                <p class="opacity-90">لديهم مواعيد</p>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-indigo-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-file-medical-alt text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $patientsWithRecords ?? 0 }}</div>
                <p class="opacity-90">لديهم سجلات</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-pink-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-eye text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $activePatients ?? 0 }}</div>
                <p class="opacity-90">نشط الشهر</p>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-all text-center">
                <i class="fas fa-users-cog text-4xl mb-4"></i>
                <div class="text-3xl font-bold">{{ $needsAttention ?? 0 }}</div>
                <p class="opacity-90">يحتاجون متابعة</p>
            </div>
        </div>
    </div>

    <script>
        // Live search
        const searchInput = document.querySelector('input[placeholder*="ابحث"]');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('tbody tr').forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
                });
            });
        }

        // Button hover effects
        document.querySelectorAll('.hover:scale-105').forEach(btn => {
            btn.addEventListener('mouseenter', () => btn.style.transform = 'scale(1.05)');
            btn.addEventListener('mouseleave', () => btn.style.transform = 'scale(1)');
        });
    </script>
</x-app-layout>
