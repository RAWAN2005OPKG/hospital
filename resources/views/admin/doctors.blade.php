<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-user-md mr-3 text-indigo-500"></i>
            إدارة الأطباء
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Header with Add Button --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">قائمة الأطباء</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $doctors->total() ?? 0 }} طبيب مسجل</p>
            </div>
            <button class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all self-start sm:self-auto">
                <i class="fas fa-plus mr-2"></i>طبيب جديد
            </button>
        </div>

        {{-- Filters --}}
        <div class="bg-gradient-to-r from-gray-50 to-indigo-50 dark:from-gray-900 dark:to-indigo-900/20 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" placeholder="بحث بالاسم..." class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 transition-all">
                <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500">
                    <option>التخصص</option>
                    <option>جراحة عامة</option>
                    <option>قلب</option>
                    <option>أسنان</option>
                </select>
                <select class="px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-orange-500">
                    <option>الحالة</option>
                    <option>نشط</option>
                    <option>غير نشط</option>
                </select>
                <button class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-search mr-2"></i>فلترة
                </button>
            </div>
        </div>

        {{-- Doctors Table --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/30 dark:to-blue-900/30">
                        <tr>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الاسم</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">التخصص</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الهاتف</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">عدد المرضى</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الحالة</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($doctors ?? collect() as $doctor)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-white font-bold text-xl shadow-2xl border-4 border-white">
                                            {{ Str::upper(substr($doctor->name, 0, 2)) }}
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-lg text-gray-900 dark:text-white">{{ $doctor->name }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $doctor->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-2 bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 font-semibold rounded-xl shadow">
                                        {{ $doctor->specialization->name ?? 'غير محدد' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 font-mono text-gray-900 dark:text-white">{{ $doctor->phone ?? '-' }}</td>
                                <td class="px-8 py-6 font-bold text-2xl text-indigo-600 dark:text-indigo-400">{{ $doctor->patients_count ?? 0 }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-2 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-200 rounded-xl font-bold shadow inline-flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>نشط
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <a href="#" class="p-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl hover:scale-105 transition-all shadow-md">
                                            <i class="fas fa-eye text-xl"></i>
                                        </a>
                                        <a href="#" class="p-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-xl hover:scale-105 transition-all shadow-md">
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
                                <td colspan="6" class="py-24 text-center">
                                    <i class="fas fa-user-md text-9xl text-gray-300 dark:text-gray-600 mb-8"></i>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا يوجد أطباء</h3>
                                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">ابدأ بإضافة أول طبيب</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($doctors ?? false)
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $doctors->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Search filter
        document.querySelectorAll('input[placeholder*="بحث"]').forEach(input => {
            input.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('tbody tr').forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
