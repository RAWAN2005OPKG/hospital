@extends('layouts.app')

@section('title', 'د. ' . $doctor->user->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
    <!-- Doctor Card -->
    <div class="md:col-span-1">
        <div class="card sticky top-24">
            <div class="h-64 bg-gradient-to-br from-blue-100 to-teal-100 flex items-center justify-center rounded-2xl mb-4 relative">
                <i class="fas fa-user-md text-8xl text-blue-600"></i>
                <div class="absolute top-4 left-4 green-dot">
                    <i class="fas fa-star text-white"></i>
                </div>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-1">د. {{ $doctor->user->name }}</h1>
            <p class="text-teal-600 font-bold text-lg mb-1">{{ $doctor->specialization->name }}</p>
            <p class="text-gray-600 mb-4">{{ $doctor->department->name }}</p>
            
            <div class="border-t border-b border-blue-100 py-4 mb-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">التقييم:</span>
                    <div class="flex items-center">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fas fa-star text-yellow-400"></i>
                        @endfor
                        <span class="ml-2 text-gray-700">4.8</span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">الخبرة:</span>
                    <span class="font-bold text-gray-800">{{ $doctor->experience_years }} سنة</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">الرسم:</span>
                    <span class="font-bold text-blue-600 text-lg">{{ $doctor->consultation_fee }} ر.س</span>
                </div>
            </div>
            
            <a href="{{ route('appointments.create', $doctor->id) }}" class="btn-primary w-full text-center">
                <i class="fas fa-calendar-check ml-2"></i>احجز موعد
            </a>
        </div>
    </div>
    
    <!-- Details -->
    <div class="md:col-span-2">
        <!-- About -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">نبذة عن الطبيب</h2>
            <p class="text-gray-600 leading-relaxed">
                {{ $doctor->bio ?? 'طبيب متخصص ذو خبرة عالية. مكرس لتقديم أفضل الخدمات الطبية والرعاية الشخصية للمرضى.' }}
            </p>
        </div>
        
        <!-- Schedule Table -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">جدول العمل</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-50 to-teal-50">
                        <tr>
                            <th class="px-4 py-3 text-right font-bold text-gray-800">اليوم</th>
                            <th class="px-4 py-3 text-right font-bold text-gray-800">البداية</th>
                            <th class="px-4 py-3 text-right font-bold text-gray-800">النهاية</th>
                            <th class="px-4 py-3 text-right font-bold text-gray-800">الراحة</th>
                            <th class="px-4 py-3 text-right font-bold text-gray-800">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                        @endphp
                        
                        @forelse($schedules as $schedule)
                        <tr class="border-b border-blue-100 hover:bg-blue-50">
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $days[$schedule->day_of_week] }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $schedule->start_time }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $schedule->end_time }}</td>
                            <td class="px-4 py-3 text-gray-700">
                                @if($schedule->break_start)
                                    {{ $schedule->break_start }} - {{ $schedule->break_end }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                    متاح
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-600">لا توجد أوقات عمل</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Reviews -->
        <div class="card">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">آراء المرضى</h2>
            <div class="space-y-4">
                <div class="border-b border-blue-100 pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-gray-800">محمد أحمد</h4>
                        <div class="flex items-center">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600">طبيب متميز جداً، معاملة احترافية وتشخيص دقيق.</p>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-gray-800">فاطمة علي</h4>
                        <div class="flex items-center">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600">تجربة رائعة جداً، سأعود بكل تأكيد.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection