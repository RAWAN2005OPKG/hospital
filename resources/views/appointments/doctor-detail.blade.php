<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-user-md mr-3 text-emerald-500"></i>
            د. أحمد محمد - جراح قلب
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-12">
        {{-- Doctor Profile Header --}}
        <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-blue-600 text-white rounded-4xl p-12 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
            <div class="relative z-10">
                <div class="w-40 h-40 bg-white/20 rounded-full mx-auto mb-8 backdrop-blur-2xl border-8 border-white/50 shadow-2xl flex items-center justify-center">
                    <i class="fas fa-user-md text-6xl"></i>
                </div>
                <h1 class="text-5xl font-bold mb-4">د. أحمد محمد</h1>
                <p class="text-2xl opacity-95 mb-2">استشاري جراحة القلب</p>
                <div class="flex items-center justify-center space-x-6 rtl:space-x-reverse mb-8">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <div class="flex space-x-1">
                            <i class="fas fa-star text-yellow-400 text-2xl"></i>
                            <i class="fas fa-star text-yellow-400 text-2xl"></i>
                            <i class="fas fa-star text-yellow-400 text-2xl"></i>
                            <i class="fas fa-star text-yellow-400 text-2xl"></i>
                            <i class="fas fa-star text-yellow-300 text-2xl"></i>
                        </div>
                        <span class="text-2xl font-bold">4.8</span>
                        <span class="text-lg opacity-90">(247 تقييم)</span>
                    </div>
                    <div class="flex items-center space-x-1 rtl:space-x-reverse">
                        <i class="fas fa-users text-2xl"></i>
                        <span class="text-2xl font-bold">1,247</span>
                        <span class="text-lg opacity-90">مريض</span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="#schedule" class="bg-white/20 backdrop-blur-xl px-8 py-4 rounded-3xl font-bold text-xl hover:bg-white/30 transition-all shadow-2xl border border-white/30 hover:shadow-3xl">
                        <i class="fas fa-calendar-plus mr-2"></i>حجز موعد
                    </a>
                    <button class="bg-white/20 backdrop-blur-xl px-8 py-4 rounded-3xl font-bold text-xl hover:bg-white/30 transition-all shadow-2xl border border-white/30 hover:shadow-3xl">
                        <i class="fas fa-phone mr-2"></i>اتصل
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- About Doctor --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-blue-500"></i>
                        نبذة عن الطبيب
                    </h3>
                    <div class="prose prose-xl max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                        <p class="text-lg">يتمتع الدكتور أحمد بخبرة تزيد عن 15 عاماً في مجال جراحة القلب والأوعية الدموية. تخرج من كلية الطب بجامعة الملك سعود وحصل على زمالة في جراحة القلب من مستشفى كليفلاند كلينيك بأمريكا.</p>
                        <p>يقدم الدكتور أحمد مجموعة واسعة من الخدمات تشمل تركيب الدلايل القلبية، تصحيح التشوهات القلبية، والجراحات المفتوحة للقلب. يعمل في قسم القلب بالمستشفى منذ 8 سنوات.</p>
                        <ul class="mt-6 space-y-2">
                            <li><i class="fas fa-graduation-cap text-emerald-500 mr-3"></i>بكالوريوس الطب - جامعة الملك سعود 2005</li>
                            <li><i class="fas fa-certificate text-blue-500 mr-3"></i>زمالة جراحة القلب - كليفلاند كلينيك 2010</li>
                            <li><i class="fas fa-award text-yellow-500 mr-3"></i>أفضل طبيب قلب 2022</li>
                        </ul>
                    </div>
                </div>

                {{-- Patient Reviews --}}
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-comments mr-3 text-purple-500"></i>
                        آراء المرضى (247)
                    </h3>
                    <div class="space-y-6">
                        <div class="flex space-x-6 rtl:space-x-reverse p-6 bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-3xl">
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <span class="font-bold text-lg text-gray-900 dark:text-white">5.0</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-900 dark:text-white font-semibold">"تجربة رائعة، الدكتور محترف جداً"</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">محمد أحمد - قبل شهر</p>
                            </div>
                        </div>
                        <div class="flex space-x-6 rtl:space-x-reverse p-6 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900/20 rounded-3xl">
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-300"></i>
                                </div>
                                <span class="font-bold text-lg text-gray-900 dark:text-white">4.5</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-900 dark:text-white font-semibold">"مهني ويقدم شرح واضح للحالة"</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">فاطمة سالم - قبل أسبوعين</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Schedule & Booking --}}
            <div class="space-y-8">
                <div id="schedule" class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10 sticky top-24">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-calendar-days mr-3 text-orange-500"></i>
                        جدول المواعيد
                    </h3>
                    
                    {{-- Days of Week --}}
                    <div class="grid grid-cols-7 gap-3 mb-8 text-center">
                        @foreach(['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'] as $day)
                            <div class="p-4 rounded-2xl {{ $loop->odd ? 'bg-emerald-100 text-emerald-800 font-bold shadow-md border-2 border-emerald-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all cursor-pointer' }}">
                                {{ $day }}<br>
                                <span class="block text-sm font-bold mt-1">{{ $loop->odd ? 'متاح' : 'غير متاح' }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Available Times --}}
                    <div class="space-y-3 mb-10">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>
                            الفترات المتاحة غداً (15 يناير)
                        </h4>
                        <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            @foreach(['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'] as $time)
                                <button class="p-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all group relative overflow-hidden">
                                    <div class="absolute inset-0 bg-white/20 group-hover:bg-white/30 transition-all"></div>
                                    <span class="relative z-10">{{ $time }}</span>
                                    <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-white/30 rounded-full group-hover:w-8 group-hover:h-8 transition-all"></div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Booking Summary --}}
                    <div class="bg-gradient-to-br from-gray-50 to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 p-8 rounded-3xl border-2 border-emerald-200 dark:border-emerald-800">
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">ملخص الحجز</h4>
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center p-4 bg-white dark:bg-gray-900 rounded-2xl shadow-sm">
                                <span class="text-gray-700 dark:text-gray-300 font-medium">الطبيب</span>
                                <span class="font-bold text-gray-900 dark:text-white">د. أحمد محمد</span>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-white dark:bg-gray-900 rounded-2xl shadow-sm">
                                <span class="text-gray-700 dark:text-gray-300 font-medium">التاريخ</span>
                                <span class="font-bold text-gray-900 dark:text-white text-lg">15 يناير 2024</span>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-white dark:bg-gray-900 rounded-2xl shadow-sm">
                                <span class="text-gray-700 dark:text-gray-300 font-medium">الوقت</span>
                                <span class="font-bold text-gray-900 dark:text-white text-lg">10:00 ص</span>
                            </div>
                        </div>
                        <button class="w-full bg-gradient-to-r from-emerald-600 to-blue-600 text-white font-bold py-5 px-8 rounded-3xl text-xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-sm">
                            <i class="fas fa-credit-card mr-3"></i>
                            تأكيد الحجز 150 ر.س
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
