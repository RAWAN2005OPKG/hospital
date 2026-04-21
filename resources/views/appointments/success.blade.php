<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-check-double mr-3 text-emerald-500"></i>
            حجز موعدك مكتمل!
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-20">
        <div class="text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full mx-auto mb-8 shadow-2xl flex items-center justify-center border-8 border-white">
                <i class="fas fa-check text-5xl text-white"></i>
            </div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent mb-6">
                تهانينا!
            </h1>
            <p class="text-2xl text-gray-700 dark:text-gray-300 mb-12 leading-relaxed max-w-2xl mx-auto">
                لقد تم حجز موعدك بنجاح مع <span class="font-bold text-emerald-600 dark:text-emerald-400">د. أحمد محمد</span><br>
                ستجد جميع التفاصيل في بريدك الإلكتروني أو لوحة التحكم
            </p>
            
            <div class="bg-white dark:bg-gray-900 rounded-4xl shadow-2xl p-12 max-w-3xl mx-auto border border-gray-200 dark:border-gray-700">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">ملخص سريع</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-black text-emerald-600 dark:text-emerald-400 mb-2">15 يناير</div>
                        <div class="text-xl font-bold text-gray-900 dark:text-white">الأحد</div>
                        <div class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold uppercase tracking-wide mt-1">التاريخ</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-blue-600 dark:text-blue-400 mb-2">10:00 ص</div>
                        <div class="text-sm font-bold text-gray-600 dark:text-gray-400">صباحاً</div>
                        <div class="text-sm text-blue-600 dark:text-blue-400 font-semibold uppercase tracking-wide mt-1">الوقت</div>
                    </div>
                </div>
                <div class="mt-12 pt-12 border-t-4 border-emerald-200 dark:border-emerald-800">
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center space-x-3 rtl:space-x-reverse px-12 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-4xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all text-xl">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                        <button onclick="printReceipt()" class="flex items-center justify-center space-x-3 rtl:space-x-reverse px-12 py-5 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold rounded-4xl shadow-2xl hover:shadow-3xl border-2 border-gray-200 dark:border-gray-700 transition-all text-xl">
                            <i class="fas fa-print"></i>
                            <span>إيصال PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24">
            <div class="text-center p-10 rounded-4xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 shadow-xl border border-blue-200 dark:border-blue-800">
                <i class="fas fa-envelope text-5xl text-blue-500 mb-6"></i>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">تحقق من البريد</h4>
                <p class="text-gray-600 dark:text-gray-400">تم إرسال تأكيد الحجز إلى بريدك الإلكتروني</p>
            </div>
            <div class="text-center p-10 rounded-4xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 shadow-xl border border-emerald-200 dark:border-emerald-800">
                <i class="fas fa-calendar-check text-5xl text-emerald-500 mb-6"></i>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">أضف للتقويم</h4>
                <p class="text-gray-600 dark:text-gray-400">يمكنك إضافة الموعد لتقويم هاتفك</p>
            </div>
            <div class="text-center p-10 rounded-4xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 shadow-xl border border-purple-200 dark:border-purple-800">
                <i class="fas fa-bell text-5xl text-purple-500 mb-6"></i>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">تذكير</h4>
                <p class="text-gray-600 dark:text-gray-400">ستتلقى تذكيراً قبل الموعد بساعة</p>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            window.print();
        }

        // Auto-print option
        if (window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
            setTimeout(() => {
                if (confirm('هل تريد طباعة الإيصال الآن؟')) {
                    printReceipt();
                }
            }, 3000);
        }
    </script>
</x-app-layout>
