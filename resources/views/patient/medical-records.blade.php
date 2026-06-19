index.blade.php<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fas fa-file-medical text-3xl text-emerald-600 mr-4"></i>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.medical_records_title') }}</h2>
        </div>
    </x-slot>

    <div class="space-y-12">
        {{-- Enhanced Header Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center cursor-pointer" onclick="printRecords()">
                <i class="fas fa-file-alt text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-4xl font-bold mb-2">{{ $records ? $records->count() : 0 }}</div>
                <div class="text-emerald-100 font-semibold text-lg">السجلات الكلية</div>
            </div>
            
            <div class="group bg-gradient-to-br from-blue-500 to-blue-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center">
                <i class="fas fa-calendar-week text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-4xl font-bold mb-2">{{ $recentRecords ?? 0 }}</div>
                <div class="text-blue-100 font-semibold text-lg">السجلات الأخيرة</div>
            </div>
            
            <div class="group bg-gradient-to-br from-purple-500 to-indigo-600 text-white p-8 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all backdrop-blur-xl border border-white/20 text-center cursor-pointer" onclick="exportPDF()">
                <i class="fas fa-file-pdf text-5xl mb-4 opacity-90 group-hover:scale-110 transition-transform"></i>
                <div class="text-xl font-bold mb-1">تصدير PDF</div>
                <div class="text-purple-100 text-sm">تنزيل السجلات</div>
            </div>
        </div>

        {{-- Records Timeline --}}
        <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-8 border-b border-white/30 flex items-center justify-between">
                <h3 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-timeline mr-4 text-2xl"></i>
                    {{ __('messages.medical_records_history') }}
                </h3>
                <div class="flex space-x-3 rtl:space-x-reverse">
                    <button id="timeline-prev" class="w-14 h-14 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white font-bold shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-chevron-right text-xl"></i>
                    </button>
                    <button id="timeline-next" class="w-14 h-14 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white font-bold shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-chevron-left text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-100 dark:scrollbar-track-gray-800">
                <div class="p-8 min-w-max relative">
                    {{-- Vertical timeline line --}}
                    <div class="absolute left-10 top-0 bottom-0 w-1 bg-gradient-to-b from-emerald-500 to-blue-500 rounded-full shadow-lg"></div>
                    
                    @forelse($records ?? collect() as $index => $record)
                        <div class="mb-16 flex items-start min-w-[600px]">
                            {{-- Timeline dot --}}
                            <div class="relative z-10 flex-shrink-0">
                                <div class="w-6 h-6 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full shadow-lg ring-8 ring-white/50 dark:ring-gray-900/50 flex items-center justify-center mr-6 -ml-3">
                                    <i class="fas fa-chart-line text-white text-xs"></i>
                                </div>
                            </div>
                            
                            {{-- Record Card --}}
                            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700 hover:shadow-3xl hover:border-emerald-200 dark:hover:border-emerald-800 transition-all duration-300 flex-1 max-w-4xl">
                                <div class="flex flex-wrap items-start justify-between gap-6 mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                                    <div>
                                        <h4 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">{{ $record->doctor->user->name ?? 'غير محدد' }}</h4>
                                        <div class="flex items-center text-emerald-600 font-bold text-xl mb-2">
                                            <i class="fas fa-clock mr-2"></i>
                                            {{ \Carbon\Carbon::parse($record->created_at)->format('d M Y, H:i') }}
                                        </div>
                                        <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-emerald-500 text-white text-lg font-bold rounded-2xl shadow-lg">
                                            {{ $record->appointment->reason ?? 'فحص روتيني' }}
                                        </span>
                                    </div>
                                    <a href="/patient/medical-records/{{ $record->id }}" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-blue-600 hover:from-emerald-700 hover:to-blue-700 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl transition-all group-hover:-translate-y-1">
                                        <i class="fas fa-eye mr-3 text-xl group-hover:animate-pulse"></i>
                                        عرض التفاصيل
                                    </a>
                                </div>
                                
                                {{-- Content Grid --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div>
                                        <h5 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                            <i class="fas fa-stethoscope text-red-500 mr-3 text-xl"></i>
                                            التشخيص
                                        </h5>
                                        <div class="bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 p-8 rounded-3xl border border-red-200 dark:border-red-800 shadow-lg">
                                            <div class="text-lg leading-relaxed text-gray-800 dark:text-gray-200 whitespace-pre-wrap">
                                                {{ Str::limit($record->diagnosis, 400, '...') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h5 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                            <i class="fas fa-pills text-orange-500 mr-3 text-xl"></i>
                                            خطة العلاج
                                        </h5>
                                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-8 rounded-3xl border border-orange-200 dark:border-orange-800 shadow-lg">
                                            <div class="text-lg leading-relaxed text-gray-800 dark:text-gray-200 whitespace-pre-wrap">
                                                {{ Str::limit($record->treatment, 400, '...') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($record->prescription)
                                    <div class="mt-12 pt-10 border-t-4 border-gradient-to-r border-blue-200 dark:border-blue-800">
                                        <h5 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                            <i class="fas fa-prescription-bottle-alt text-blue-500 mr-3 text-xl"></i>
                                            الوصفة الطبية
                                        </h5>
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-10 rounded-3xl border-4 border-blue-200 dark:border-blue-800 shadow-2xl backdrop-blur-sm">
                                            <div class="text-xl text-gray-800 dark:text-gray-200 leading-relaxed font-mono whitespace-pre-wrap text-center">
                                                {{ $record->prescription }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="min-w-max text-center py-32 px-20">
                            <div class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl">
                                <i class="fas fa-file-medical text-5xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">لا توجد سجلات طبية بعد</h3>
                            <p class="text-2xl text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                                سجلاتك الطبية ستظهر هنا تلقائياً بعد إتمام أول زيارة للطبيب
                            </p>
                            <div class="space-y-4">
<a href="{{ route('appointments.book') }}" class="block w-full max-w-md mx-auto inline-flex items-center justify-center px-12 py-6 bg-gradient-to-r from-emerald-600 to-blue-600 hover:from-emerald-700 hover:to-blue-700 text-white font-bold text-xl rounded-3xl shadow-2xl hover:shadow-4xl transition-all transform hover:-translate-y-2 mx-auto group">
                                    <i class="fas fa-calendar-plus text-2xl mr-4 group-hover:animate-bounce"></i>
                                    {{ __('messages.book_first_appointment_now') }}
                                </a>
                                <p class="text-lg text-gray-500 dark:text-gray-400 text-center">
                                    أو <a href="{{ route('doctors.index') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">{{ __('messages.browse_doctors') }}</a>
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Enhanced Pagination --}}
        @if(isset($records) && $records->hasPages())
        <div class="flex justify-center">
            {{ $records->appends(request()->query())->links('vendor.pagination.tailwindcss-modern') }}
        </div>
        @endif
    </div>

    <script>
        function printRecords() {
            window.print();
        }

        function exportPDF() {
            alert('قريباً سيتم إضافة تصدير PDF');
            // window.open('/patient/medical-records/export-pdf');
        }

        // Enhanced Timeline Navigation
        let currentSlide = 0;
        const timelineContainer = document.querySelector('.overflow-x-auto');
        const slideWidth = 650;

        document.getElementById('timeline-next')?.addEventListener('click', () => {
            if (timelineContainer.scrollLeft < timelineContainer.scrollWidth - timelineContainer.clientWidth - 50) {
                timelineContainer.scrollLeft += slideWidth;
            }
        });

        document.getElementById('timeline-prev')?.addEventListener('click', () => {
            if (timelineContainer.scrollLeft > 50) {
                timelineContainer.scrollLeft -= slideWidth;
            }
        });

        // Auto-scroll on hover
        timelineContainer?.addEventListener('mouseenter', () => clearInterval(window.timelineInterval));
        timelineContainer?.addEventListener('mouseleave', () => {
            window.timelineInterval = setInterval(() => {
                if (timelineContainer.scrollLeft < timelineContainer.scrollWidth - timelineContainer.clientWidth) {
                    timelineContainer.scrollLeft += 2;
                }
            }, 50);
        });

        function viewDetail(id) {
            window.location.href = `/patient/medical-records/${id}`;
        }
    </script>

    <style>
        .border-gradient-to-r {
            border-image: linear-gradient(to right, #10b981, #3b82f6) 1;
        }
        .scrollbar-thin {
            scrollbar-width: thin;
        }
        .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
        }
    </style>
</x-app-layout>

