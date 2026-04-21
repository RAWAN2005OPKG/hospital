<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-emerald-50 dark:from-gray-900 dark:via-gray-900 dark:to-blue-900/20 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Hero Section --}}
            <div class="text-center mb-20">
                <div class="w-32 h-32 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-4xl flex items-center justify-center mx-auto mb-8 shadow-2xl border-4 border-white">
                    <i class="fas fa-calendar-heart text-4xl text-white"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-gray-900 via-blue-900 to-emerald-900 bg-clip-text text-transparent mb-6 leading-tight">
                    احجز موعدك الطبي بسهولة
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                    اختر طبيبك المفضل من مختلف التخصصات الطبية واحجز موعدك في ثوان
                </p>
            </div>

            {{-- Search Form --}}
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-4xl shadow-2xl border border-white/50 dark:border-gray-800 p-10 mb-16">
                <form method="GET" action="#" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">التخصص الطبي</label>
                            <select name="specialization" class="w-full px-5 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-xl hover:shadow-2xl">
                                <option>اختر التخصص</option>
                                <option>القلب</option>
                                <option>جراحة العظام</option>
                                <option>الأسنان</option>
                                <option>الأطفال</option>
                                <option>الجلدية</option>
                                <option>العيون</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">اسم الطبيب</label>
                            <input type="text" name="doctor" placeholder="ابحث بالاسم..." class="w-full px-5 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-xl hover:shadow-2xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">القسم</label>
                            <select name="department" class="w-full px-5 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 transition-all shadow-xl hover:shadow-2xl">
                                <option>اختر القسم</option>
                                <option>العيادات الخارجية</option>
                                <option>طوارئ</option>
                                <option>جراحة</option>
                            </select>
                        </div>
                        <div class="lg:col-span-3">
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 via-teal-600 to-blue-600 text-white font-bold py-6 px-12 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all text-xl backdrop-blur-sm hover:from-emerald-700 hover:via-teal-700 hover:to-blue-700">
                                <i class="fas fa-search mr-3"></i>
                                ابحث عن موعد
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Featured Doctors (Live Search Results) --}}
            <div class="space-y-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center">أطباء مميزون</h2>
                
                {{-- Results Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Doctor Card 1 --}}
                    <div class="group bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-3xl hover:-translate-y-4 transition-all duration-500 hover:border-emerald-300">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-8 text-white text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                            <div class="w-24 h-24 bg-white/30 rounded-4xl mx-auto mb-4 backdrop-blur-xl border-4 border-white/50 flex items-center justify-center">
                                <i class="fas fa-user-md text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold relative z-10">د. أحمد محمد</h3>
                            <p class="opacity-90 relative z-10 mb-1">جراح قلب متقدم</p>
                            <div class="flex items-center justify-center space-x-2 rtl:space-x-reverse relative z-10">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-300"></i>
                                <span class="font-bold">4.8 (247)</span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">التخصص</span>
                                    <span class="font-bold text-gray-900 dark:text-white">جراحة القلب</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">القسم</span>
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">العيادات الخارجية</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">الموقع</span>
                                    <span class="font-bold text-blue-600 dark:text-blue-400">الرياض</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mb-8">
                                <button class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold py-4 px-6 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all group">
                                    <i class="fas fa-calendar-plus mr-2 group-hover:mr-3 transition-all"></i>
                                    حجز موعد
                                </button>
                                <button class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-800 dark:text-gray-200 font-bold py-4 px-6 rounded-3xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    التفاصيل
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Repeat similar cards for other doctors --}}
                    {{-- Doctor Card 2 --}}
                    <div class="group bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-3xl hover:-translate-y-4 transition-all duration-500 hover:border-blue-300">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                            <div class="w-24 h-24 bg-white/30 rounded-4xl mx-auto mb-4 backdrop-blur-xl border-4 border-white/50 flex items-center justify-center">
                                <i class="fas fa-user-md text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold relative z-10">د. فاطمة علي</h3>
                            <p class="opacity-90 relative z-10 mb-1">طبيبة أسنان</p>
                            <div class="flex items-center justify-center space-x-2 rtl:space-x-reverse relative z-10">
                                <i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i>
                                <span class="font-bold">5.0 (189)</span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">التخصص</span><span class="font-bold text-gray-900 dark:text-white">طب أسنان تجميلي</span></div>
                                <div class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">القسم</span><span class="font-bold text-blue-600 dark:text-blue-400">أسنان</span></div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mb-8">
                                <button class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold py-4 px-6 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all group">
                                    <i class="fas fa-calendar-plus mr-2 group-hover:mr-3 transition-all"></i>حجز موعد
                                </button>
                                <button class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-800 dark:text-gray-200 font-bold py-4 px-6 rounded-3xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                    <i class="fas fa-info-circle mr-2"></i>التفاصيل
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Doctor Card 3 --}}
                    <div class="group bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-3xl hover:-translate-y-4 transition-all duration-500 hover:border-purple-300">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-8 text-white text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                            <div class="w-24 h-24 bg-white/30 rounded-4xl mx-auto mb-4 backdrop-blur-xl border-4 border-white/50 flex items-center justify-center">
                                <i class="fas fa-user-md text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold relative z-10">د. خالد عبدالله</h3>
                            <p class="opacity-90 relative z-10 mb-1">جراح عظام</p>
                            <div class="flex items-center justify-center space-x-2 rtl:space-x-reverse relative z-10">
                                <i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-400"></i><i class="fas fa-star text-yellow-300"></i>
                                <span class="font-bold">4.9 (312)</span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">التخصص</span><span class="font-bold text-gray-900 dark:text-white">جراحة العظام</span></div>
                                <div class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">القسم</span><span class="font-bold text-purple-600 dark:text-purple-400">جراحة</span></div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mb-8">
                                <button class="bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold py-4 px-6 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all group">
                                    <i class="fas fa-calendar-plus mr-2 group-hover:mr-3 transition-all"></i>حجز موعد
                                </button>
                                <button class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-800 dark:text-gray-200 font-bold py-4 px-6 rounded-3xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                    <i class="fas fa-info-circle mr-2"></i>التفاصيل
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA Section --}}
            <div class="text-center py-20 bg-gradient-to-r from-emerald-600 to-blue-600 text-white rounded-4xl shadow-2xl">
                <h2 class="text-4xl font-bold mb-6">جاهز للحجز؟</h2>
                <p class="text-xl opacity-90 mb-10 max-w-2xl mx-auto">نظام حجز مواعيد آمن وسريع مع أفضل الأطباء</p>
                <button class="bg-white text-emerald-600 font-bold px-12 py-6 rounded-3xl text-xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all mx-auto">
                    <i class="fas fa-calendar-check mr-3"></i>
                    ابدأ الحجز الآن
                </button>
            </div>
        </div>
    </div>
</x-guest-layout>
