<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-calendar-check mr-3 text-emerald-500"></i>
            تأكيد الحجز
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-12">
        {{-- Success Header --}}
        <div class="text-center py-20 bg-gradient-to-r from-emerald-500 via-teal-500 to-blue-600 text-white rounded-4xl shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-white/5 backdrop-blur-sm"></div>
            <div class="relative z-10">
                <div class="w-32 h-32 bg-white/20 rounded-full mx-auto mb-8 backdrop-blur-xl border-8 border-white/50 shadow-2xl flex items-center justify-center animate-pulse">
                    <i class="fas fa-check-circle text-6xl"></i>
                </div>
                <h1 class="text-5xl font-bold mb-4">تم حجز موعدك!</h1>
                <p class="text-2xl opacity-95 mb-12">رقم الحجز: <span class="font-black text-3xl bg-white/30 px-6 py-3 rounded-3xl backdrop-blur-xl">#APP-{{ rand(100000,999999) }}</span></p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center max-w-2xl mx-auto">
                    <button onclick="printConfirmation()" class="flex items-center space-x-3 rtl:space-x-reverse px-10 py-4 bg-white/30 backdrop-blur-xl text-white font-bold rounded-4xl hover:bg-white/50 shadow-2xl transition-all border border-white/30">
                        <i class="fas fa-print"></i>
                        <span>طباعة</span>
                    </button>
                    <button onclick="shareAppointment()" class="flex items-center space-x-3 rtl:space-x-reverse px-10 py-4 bg-white text-emerald-600 font-bold rounded-4xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all">
                        <i class="fas fa-share-alt"></i>
                        <span>مشاركة</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Appointment Details --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Doctor Info --}}
            <div class="bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                    <i class="fas fa-user-md mr-3 text-emerald-500"></i>
                    بيانات الطبيب
                </h3>
                <div class="space-y-6">
                    <div class="flex items-center p-6 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/20 rounded-3xl">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl flex items-center justify-center text-white font-bold text-2xl shadow-2xl mr-6 flex-shrink-0">
                            أ م
                        </div>
                        <div class="text-right">
                            <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">د. أحمد محمد</h4>
                            <p class="text-emerald-600 font-semibold mb-2">استشاري جراحة القلب</p>
                            <p class="text-gray-600 dark:text-gray-400">قسم القلب - العيادات الخارجية</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl">
                            <i class="fas fa-phone text-emerald-500 mr-2"></i>
                            <span class="font-bold text-gray-900 dark:text-white">+966 50 123 4567</span>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl">
                            <i class="fas fa-envelope text-blue-500 mr-2"></i>
                            <span class="font-bold text-gray-900 dark:text-white">ahmed@example.com</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Appointment Details --}}
            <div class="bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                    <i class="fas fa-calendar-check mr-3 text-blue-500"></i>
                    تفاصيل الموعد
                </h3>
                <div class="space-y-6">
                    <div class="p-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-4xl border-4 border-blue-200 dark:border-blue-800 shadow-2xl">
                        <div class="grid grid-cols-2 gap-8 text-center">
                            <div>
                                <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $appointment_date_formatted ?? '15 يناير' }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wide font-bold">الأحد</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-white mt-2">التاريخ</div>
                            </div>
                            <div>
                                <div class="text-4xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">{{ $appointment_time ?? '10:00' }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 font-bold">صباحاً</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-white mt-2">الوقت</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-gray-50 to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-3xl">
                        <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-align-left mr-2 text-blue-500"></i>
                            سبب الحجز
                        </h4>
                        <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">{{ $reason ?? 'فحص روتيني للقلب والأوعية الدموية' }}</p>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-3xl border-2 border-orange-200 dark:border-orange-800">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xl font-bold text-gray-900 dark:text-white">التكلفة</span>
                            <span class="text-3xl font-black text-orange-600 dark:text-orange-400">150 ر.س</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <div><i class="fas fa-shield-alt text-emerald-500 mr-2"></i>مدفوع</div>
                            <div><i class="fas fa-clock text-blue-500 mr-2"></i>حالة: مؤكد</div>
                            <div><i class="fas fa-credit-card text-green-500 mr-2"></i>بطاقة ائتمان</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Next Steps --}}
        <div class="bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-4xl p-12 text-center">
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">ماذا تفعل الآن؟</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="p-8 bg-white dark:bg-gray-900 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-white text-2xl shadow-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">حضور الموعد</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">تأكد من الحضور قبل الموعد بنصف ساعة لإكمال الإجراءات</p>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full animate-pulse" style="width: 100%"></div>
                    </div>
                </div>
                <div class="p-8 bg-white dark:bg-gray-900 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-white text-2xl shadow-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">سجل طبي</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">ستجد سجلك الطبي في لوحة التحكم بعد الزيارة</p>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-blue-500 h-full rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div class="p-8 bg-white dark:bg-gray-900 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-white text-2xl shadow-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">الدعم</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">تواصل معنا في أي وقت لأي استفسار</p>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-purple-500 h-full rounded-full" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Support Info --}}
        <div class="text-center pt-16 pb-20">
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">هل لديك أي أسئلة؟</p>
            <div class="flex flex-col sm:flex-row gap-8 justify-center items-center max-w-2xl mx-auto p-8 bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-900 dark:to-emerald-900/20 rounded-4xl">
                <div class="flex items-center space-x-4 rtl:space-x-reverse p-6 bg-white dark:bg-gray-900 rounded-3xl shadow-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-2xl">
                        📞
                    </div>
                    <div class="text-right">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-white">الدعم الفني</h5>
                        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">+966 50 123 4567</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 rtl:space-x-reverse p-6 bg-white dark:bg-gray-900 rounded-3xl shadow-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-2xl">
                        💬
                    </div>
                    <div class="text-right">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-white">واتساب</h5>
                        <p class="text-2xl font-black text-blue-600 dark:text-blue-400">اضغط للتواصل</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printConfirmation() {
            window.print();
        }

        function shareAppointment() {
            if (navigator.share) {
                navigator.share({
                    title: 'تأكيد موعد طبي - مستشفى الريادة',
                    text: 'تم حجز موعدي بنجاح! رقم الحجز: #APP-{{ rand(100000,999999) }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('تم نسخ رابط الحجز!');
            }
        }

        // Print styles
        const style = document.createElement('style');
        style.innerHTML = `
            @media print {
                .no-print { display: none !important; }
                body * { color-adjust: exact; -webkit-print-color-adjust: exact; }
                .bg-gradient-to-r { background: linear-gradient(to right, var(--tw-gradient-stops)) !important; -webkit-print-color-adjust: exact; }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>
