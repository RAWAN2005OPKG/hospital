<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-building mr-3 text-orange-500"></i>
            إدارة الأقسام والتخصصات
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Header --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 flex items-center justify-between">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">الأقسام الطبية</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $departments->total() ?? 0 }} قسم | {{ $specializations->total() ?? 0 }} تخصص</p>
            </div>
            <div class="flex gap-3">
                <button class="px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all">
                    <i class="fas fa-plus mr-2"></i>قسم جديد
                </button>
                <button class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all">
                    <i class="fas fa-plus mr-2"></i>تخصص جديد
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Departments --}}
            <div>
                <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-3xl shadow-xl border border-orange-200 dark:border-orange-800 p-8 mb-8">
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-hospital mr-3 text-orange-500"></i>
                        الأقسام
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($departments ?? collect() as $department)
                            <div class="group p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-2 hover:border-orange-400 transition-all cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <h5 class="font-bold text-xl text-gray-900 dark:text-white">{{ $department->name }}</h5>
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs font-bold rounded-lg">{{ $department->doctors_count ?? 0 }} طبيب</span>
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg">{{ $department->patients_count ?? 0 }} مريض</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($department->description, 80) }}</p>
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <a href="#" class="p-2 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-xl hover:scale-105 transition-all">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="p-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-xl hover:scale-105 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl hover:scale-105 transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <i class="fas fa-building text-8xl text-gray-300 dark:text-gray-600 mb-8"></i>
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">لا توجد أقسام</h4>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">ابدأ بإضافة أول قسم طبي</p>
                                <button class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all">
                                    إضافة قسم
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Specializations --}}
            <div>
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-3xl shadow-xl border border-purple-200 dark:border-purple-800 p-8">
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-cogs mr-3 text-purple-500"></i>
                        التخصصات
                    </h4>
                    <div class="space-y-4">
                        @forelse($specializations ?? collect() as $specialization)
                            <div class="group flex items-center justify-between p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 hover:border-purple-400 transition-all cursor-pointer">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ Str::upper(substr($specialization->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-lg text-gray-900 dark:text-white">{{ $specialization->name }}</h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $specialization->description }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-lg shadow-sm">{{ $specialization->doctors_count ?? 0 }} طبيب</span>
                                    <div class="flex space-x-1">
                                        <a href="#" class="p-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-xl hover:scale-105 transition-all">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl hover:scale-105 transition-all">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <i class="fas fa-cog text-8xl text-gray-300 dark:text-gray-600 mb-8 animate-spin-slow"></i>
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">لا توجد تخصصات</h4>
                                <button class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all">
                                    إضافة تخصص
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Add New Forms (Modals would be better, but inline for demo) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-gray-50 to-orange-50 dark:from-gray-900 dark:to-orange-900/20 p-8 rounded-3xl shadow-2xl border border-orange-200 dark:border-orange-800">
                <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-orange-500"></i>
                    قسم جديد
                </h5>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">اسم القسم</label>
                        <input type="text" placeholder="مثال: قسم القلب" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">الوصف</label>
                        <textarea rows="3" placeholder="وصف مختصر..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 transition-all"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold py-4 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transition-all">
                        حفظ القسم
                    </button>
                </form>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-purple-50 dark:from-gray-900 dark:to-purple-900/20 p-8 rounded-3xl shadow-2xl border border-purple-200 dark:border-purple-800">
                <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-purple-500"></i>
                    تخصص جديد
                </h5>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">اسم التخصص</label>
                        <input type="text" placeholder="مثال: جراحة القلب" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">القسم الأب</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                            <option>اختر القسم</option>
                            @foreach($departments ?? [] as $dept)
                                <option>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold py-4 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transition-all">
                        حفظ التخصص
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
    </style>
</x-app-layout>
