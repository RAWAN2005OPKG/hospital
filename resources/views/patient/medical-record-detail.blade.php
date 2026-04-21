<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-file-invoice mr-3 text-blue-500"></i>
            تفاصيل السجل الطبي
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        {{-- Record Header --}}
        <div class="bg-gradient-to-r from-emerald-500 via-blue-500 to-emerald-600 text-white p-12 rounded-4xl shadow-2xl relative overflow-hidden backdrop-blur-xl border border-white/30">
            <div class="absolute inset-0 bg-black/10 backdrop-blur-sm"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-6 rtl:space-x-reverse">
                        <div class="w-24 h-24 bg-white/20 rounded-3xl flex items-center justify-center backdrop-blur-xl border-4 border-white/50">
                            <i class="fas fa-user-md text-4xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <h1 class="text-4xl font-bold mb-2">{{ $record->doctor->user->name ?? 'د. غير محدد' }}</h1>
                            <p class="text-xl opacity-90 mb-1">{{ $record->doctor->specialization->name ?? '' }}</p>
                            <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($record->created_at)->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-4 rtl:space-x-reverse">
                        <button onclick="printRecord()" class="flex items-center space-x-2 rtl:space-x-reverse px-8 py-4 bg-white/20 backdrop-blur-xl text-white font-bold rounded-3xl hover:bg-white/30 shadow-2xl transition-all">
                            <i class="fas fa-print"></i>
                            <span>طباعة</span>
                        </button>
                        <button onclick="shareRecord()" class="flex items-center space-x-2 rtl:space-x-reverse px-8 py-4 bg-white/20 backdrop-blur-xl text-white font-bold rounded-3xl hover:bg-white/30 shadow-2xl transition-all">
                            <i class="fas fa-share-alt"></i>
                            <span>مشاركة</span>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Status badges --}}
            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                <span class="px-6 py-3 bg-white/30 backdrop-blur-xl rounded-2xl font-bold text-xl shadow-lg">
                    <i class="fas fa-check-double mr-2"></i>مكتمل
                </span>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Diagnosis &amp; Treatment --}}
            <div class="space-y-8">
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10 backdrop-blur-sm hover:shadow-3xl transition-all">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-stethoscope mr-3 text-red-500"></i>
                        التشخيص
                    </h3>
                    <div class="prose prose-2xl max-w-none text-gray-800 dark:text-gray-200 leading-relaxed bg-gradient-to-b from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-inner">
                        {!! nl2br(e($record->diagnosis)) !!}
                    </div>
                </div>

                @if($record->treatment)
                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10 backdrop-blur-sm hover:shadow-3xl transition-all">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                            <i class="fas fa-pills mr-3 text-orange-500"></i>
                            خطة العلاج
                        </h3>
                        <div class="prose prose-2xl max-w-none text-gray-800 dark:text-gray-200 leading-relaxed bg-gradient-to-b from-orange-50 to-white dark:from-orange-900/20 dark:to-gray-900 p-8 rounded-3xl border border-orange-200 dark:border-orange-800 shadow-inner">
                            {!! nl2br(e($record->treatment)) !!}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Prescription &amp; Notes --}}
            <div class="space-y-8">
                @if($record->prescription)
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-3xl shadow-2xl border border-blue-200 dark:border-blue-800 p-10 backdrop-blur-sm hover:shadow-3xl transition-all relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-indigo-500/5"></div>
                        <div class="relative">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                                <i class="fas fa-prescription-bottle-alt mr-3 text-blue-500"></i>
                                الوصفة الطبية
                            </h3>
                            <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl border-4 border-blue-100 dark:border-blue-900 shadow-2xl font-mono text-lg leading-relaxed whitespace-pre-wrap overflow-auto max-h-96">
                                {!! nl2br(e($record->prescription)) !!}
                            </div>
                            
                            <div class="mt-8 pt-8 border-t border-blue-200 dark:border-blue-800 flex items-center justify-between">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse text-sm text-blue-700 dark:text-blue-300 font-semibold">
                                    <i class="fas fa-capsules text-xl"></i>
                                    <span>تناول حسب تعليمات الطبيب</span>
                                </div>
                                <div class="flex space-x-3 rtl:space-x-reverse">
                                    <button onclick="copyPrescription()" class="flex items-center space-x-2 rtl:space-x-reverse px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 shadow-lg transition-all">
                                        <i class="fas fa-copy"></i>
                                        <span>نسخ</span>
                                    </button>
                                    <button onclick="printPrescription()" class="flex items-center space-x-2 rtl:space-x-reverse px-6 py-3 bg-emerald-600 text-white rounded-2xl font-bold hover:bg-emerald-700 shadow-lg transition-all">
                                        <i class="fas fa-print"></i>
                                        <span>طباعة</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($record->notes)
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl shadow-2xl border border-purple-200 dark:border-purple-800 p-10 backdrop-blur-sm hover:shadow-3xl transition-all">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                            <i class="fas fa-sticky-note mr-3 text-purple-500"></i>
                            ملاحظات إضافية
                        </h3>
                        <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-xl prose prose-lg max-w-none text-gray-800 dark:text-gray-200">
                            {!! nl2br(e($record->notes)) !!}
                        </div>
                    </div>
                @endif

                {{-- Appointment Info --}}
                @if($record->appointment)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                            <i class="fas fa-calendar-check mr-3 text-orange-500"></i>
                            تفاصيل الموعد
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                            <div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                                        <span class="text-gray-600 dark:text-gray-400"><i class="fas fa-calendar-day mr-2"></i>التاريخ</span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($record->appointment->appointment_date)->format('d F Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                                        <span class="text-gray-600 dark:text-gray-400"><i class="fas fa-clock mr-2"></i>الوقت</span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $record->appointment->appointment_time }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                                        <span class="text-gray-600 dark:text-gray-400"><i class="fas fa-align-left mr-2"></i>السبب</span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ Str::limit($record->appointment->reason, 50) }}</span>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm text-center">
                                        <span class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 rounded-2xl font-bold text-sm shadow">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            الموعد مكتمل
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Records Mini Timeline --}}
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <i class="fas fa-history mr-3 text-indigo-500"></i>
                سجلاتك الأخيرة
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Sample recent record cards --}}
                {{-- Add @foreach loop here in production --}}
                <div class="group cursor-pointer p-8 rounded-3xl bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900/30 border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-3 transition-all shadow-xl hover:shadow-2xl" onclick="window.history.back()">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white font-bold text-sm shadow-lg flex-shrink-0">
                            RD
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-1">د. رضوان</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">جراحة قلب</p>
                            <p class="text-emerald-600 font-semibold text-sm">15 يناير 2024</p>
                        </div>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 line-clamp-3 leading-relaxed">فحص روتيني...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printRecord() {
            window.print();
        }

        function shareRecord() {
            if (navigator.share) {
                navigator.share({
                    title: 'سجل طبي - {{ $record->doctor->user->name }}',
                    text: 'عرض سجلي الطبي',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('تم نسخ رابط السجل!');
            }
        }

        function printPrescription() {
            window.print();
        }

        function copyPrescription() {
            navigator.clipboard.writeText(`{{ addslashes($record->prescription ?? '') }}`);
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-emerald-500 text-white px-8 py-4 rounded-2xl shadow-2xl z-50 animate-in slide-in-from-top fade-in duration-300';
            toast.textContent = 'تم نسخ الوصفة!';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // Print styles
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .no-print { display: none !important; }
                body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                .bg-gradient-to-br { background: linear-gradient(to bottom right, var(--tw-gradient-stops)) !important; -webkit-print-color-adjust: exact; }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>
