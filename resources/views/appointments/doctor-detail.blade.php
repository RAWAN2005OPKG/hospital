@extends('layouts.app')

@section('title', 'د. ' . $doctor->user->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
    <!-- Doctor Info Card -->
    <div class="md:col-span-1">
        <div class="card sticky top-24">
            <div class="bg-gradient-to-br from-blue-100 to-teal-100 h-64 flex items-center justify-center rounded-lg mb-4">
                <i class="fas fa-user-md text-8xl text-blue-600"></i>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-2">د. {{ $doctor->user->name }}</h1>
            <p class="text-teal-600 font-bold text-lg mb-1">{{ $doctor->specialization->name }}</p>
            <p class="text-gray-600 mb-4">{{ $doctor->department->name }}</p>
            
            <div class="border-t border-blue-100 pt-4 mb-4">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-gray-600">التقييم:</span>
                    <div class="flex items-center">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fas fa-star text-yellow-400"></i>
                        @endfor
                        <span class="ml-2 text-gray-700">4.8</span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mb-3">
                    <span class="text-gray-600">سنوات الخبرة:</span>
                    <span class="font-bold text-gray-800">{{ $doctor->experience_years }} سنة</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">رسم الاستشارة:</span>
                    <span class="font-bold text-blue-600 text-lg">{{ $doctor->consultation_fee }} ر.س</span>
                </div>
            </div>
            
            <a href="{{ route('appointments.create', $doctor) }}" class="btn-primary w-full text-center">
                <i class="fas fa-calendar-check ml-2"></i>احجز موعد
            </a>
        </div>
    </div>
    
    <!-- Doctor Details -->
    <div class="md:col-span-2">
        <!-- About Section -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">نبذة عن الطبيب</h2>
            <p class="text-gray-600 leading-relaxed">
                {{ $doctor->bio ?? 'طبيب متخصص ذو خبرة عالية في مجال التخصص. مكرس لتقديم أفضل الخدمات الطبية والرعاية الشخصية للمرضى.' }}
            </p>
        </div>
        
        <!-- Schedule Section -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">أوقات العمل</h2>
            <div class="space-y-3">
                @php
                    $days = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
                @endphp
                
                @forelse($schedules as $schedule)
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <span class="font-semibold text-gray-800">{{ $days[$schedule->day_of_week] }}</span>
                    <span class="text-gray-600">
                        من {{ $schedule->start_time }} إلى {{ $schedule->end_time }}
                        @if($schedule->break_start)
                            <span class="text-sm text-gray-500">(راحة: {{ $schedule->break_start }} - {{ $schedule->break_end }})</span>
                        @endif
                    </span>
                </div>
                @empty
                <p class="text-gray-600">لا توجد أوقات عمل محددة</p>
                @endforelse
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="card">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">آراء المرضى</h2>
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
                
                <div class="border-b border-blue-100 pb-4">
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