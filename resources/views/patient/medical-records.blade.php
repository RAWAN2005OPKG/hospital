<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-file-medical mr-3 text-emerald-500"></i>
            السجلات الطبية
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Header Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center">
                <i class="fas fa-file-alt text-5xl mb-4 opacity-90"></i>
                <div class="text-4xl font-bold">{{ $records ? $records->count() : 0 }}</div>
                <div class="text-emerald-100">السجلات الكلية</div>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center">
                <i class="fas fa-calendar-week text-5xl mb-4 opacity-90"></i>
                <div class="text-4xl font-bold">{{ $recentRecords ?? 0 }}</div>
                <div class="text-blue-100">السجلات الأخيرة</div>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center cursor-pointer" onclick="printRecords()">
                <i class="fas fa-print text-5xl mb-4 opacity-90"></i>
                <div class="text-xl font-bold">طباعة</div>
                <div class="text-purple-100 text-sm">تصدير PDF</div>
            </div>
        </div>

        {{-- Records Timeline --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-8 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-timeline mr-3 text-blue-500"></i>
                    تاريخ السجلات الطبية
                </h3>
                <div class="flex space-x-3 rtl:space-x-reverse">
                    <button id="timeline-prev" class="p-3 bg-gray-200 dark:bg-gray-800 rounded-2xl hover:bg-gray-300 dark:hover:bg-gray-700 transition-all">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button id="timeline-next" class="p-3 bg-gray-200 dark:bg-gray-800 rounded-2xl hover:bg-gray-300 dark:hover:bg-gray-700 transition-all">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-2">
                <div class="relative p-8">
                    {{-- Vertical timeline line --}}
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-500 to-emerald-500 rounded-full"></div>
                    
                    @forelse($records ?? collect() as $index => $record)
                        <div class="mb-12 flex items-center relative">
                            {{-- Timeline dot --}}
                            <div class="absolute left-4 w-6 h-6 bg-gradient-to-r from-blue-500 to-emerald-500 rounded-full shadow-lg ring-4 ring-white dark:ring-gray-900 z-10 flex items-center justify-center">
                                <i class="fas fa-file-medical-alt text-white text-sm"></i>
                            </div>
                            
                            <div class="ml-16 flex-1 bg-gray-50 dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:-translate-x-2 transition-all backdrop-blur-sm">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $record->doctor->user->name ?? 'غير محدد' }}</h4>
                                        <p class="text-emerald-600 font-semibold mb-1">
                                            {{ \Carbon\Carbon::parse($record->created_at)->format('d M Y, H:i') }}
                                        </p>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">
                                            {{ $record->appointment->reason ?? 'فحص روتيني' }}
                                        </span>
                                    </div>
                                    <a href="#" onclick="viewDetail({{ $record->id }})" class="p-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl hover:shadow-xl hover:scale-105 transition-all shadow-lg font-semibold whitespace-nowrap">
                                        <i class="fas fa-eye mr-2"></i>التفاصيل
                                    </a>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                    <div>
                                        <h5 class="font-bold text-gray-900 dark:text-white mb-2"><i class="fas fa-stethoscope mr-2 text-red-500"></i>التشخيص</h5>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                                            {{ Str::limit($record->diagnosis, 200) }}
                                        </p>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-gray-900 dark:text-white mb-2"><i class="fas fa-pills mr-2 text-orange-500"></i>العلاج</h5>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                                            {{ Str::limit($record->treatment, 200) }}
                                        </p>
                                    </div>
                                </div>
                                
                                @if($record->prescription)
                                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                        <h5 class="font-bold text-gray-900 dark:text-white mb-3"><i class="fas fa-prescription-bottle-alt mr-2 text-blue-500"></i>الوصفة الطبية</h5>
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 p-6 rounded-2xl border border-blue-200 dark:border-blue-800">
                                            <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $record->prescription }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-24">
                            <i class="fas fa-file-medical text-8xl text-gray-300 dark:text-gray-600 mb-8"></i>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">لا توجد سجلات طبية</h3>
                            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">ستظهر سجلاتك الطبية هنا بعد زيارتك للطبيب</p>
                            <a href="{{ route('appointments.search') }}" class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-emerald-600 to-blue-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl transition-all">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                حجز موعد أول
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center mt-12">
            {{ $records? $records->appends(request()->query())->links() : '' }}
        </div>
    </div>

    <script>
        // Timeline navigation
        let currentSlide = 0;
        const slides = document.querySelectorAll('[class*=ml-16]');
        const slideWidth = 600; // Approximate width of each slide

        document.getElementById('timeline-next').onclick = () => {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
                document.querySelector('.relative').scrollLeft += slideWidth;
            }
        };

        document.getElementById('timeline-prev').onclick = () => {
            if (currentSlide > 0) {
                currentSlide--;
                document.querySelector('.relative').scrollLeft -= slideWidth;
            }
        };

        function printRecords() {
            window.print();
        }

        function viewDetail(id) {
            window.location.href = `/patient/medical-records/${id}`;
        }
    </script>
</x-app-layout>
