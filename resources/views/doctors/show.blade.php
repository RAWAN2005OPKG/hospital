@extends('layouts.app')

@section('title', 'د. ' . $doctor->user->name . ' - صحتي')

@section('content')
<div class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            <!-- Doctor Info Card -->
            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); height: fit-content;">
                <div style="width: 100%; height: 250px; background: linear-gradient(135deg, var(--blue), var(--cyan)); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 5rem; margin-bottom: 1.5rem; overflow: hidden;">
                    @if($doctor->user->avatar)
                        <img src="{{ asset('storage/' . $doctor->user->avatar) }}" alt="{{ $doctor->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-user-doctor"></i>
                    @endif
                </div>
                
                <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">د. {{ $doctor->user->name }}</h1>
                <p style="color: var(--blue); font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">{{ $doctor->specialization->name ?? 'تخصص' }}</p>
                
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.25rem;">القسم</p>
                        <p style="font-weight: 600;">{{ $doctor->department->name ?? 'قسم' }}</p>
                    </div>
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.25rem;">سنوات الخبرة</p>
                        <p style="font-weight: 600;">{{ $doctor->experience_years ?? 0 }} سنة</p>
                    </div>
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.25rem;">رقم الترخيص</p>
                        <p style="font-weight: 600; direction: ltr;">{{ $doctor->license_number }}</p>
                    </div>
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.25rem;">تكلفة الاستشارة</p>
                        <p style="font-weight: 600;">{{ $doctor->consultation_fee ?? 0 }} شيقل</p>
                    </div>
                </div>
                
                <a href="{{ route('appointments.create', ['doctor' => $doctor->id]) }}" class="btn btn-primary" style="width: 100%; padding: 0.85rem; text-align: center;">
                    <i class="fa-solid fa-calendar-plus"></i> احجز موعداً الآن
                </a>
            </div>
            
            <!-- Doctor Details -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <!-- Bio -->
                @if($doctor->bio)
                    <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem;">عن الطبيب</h2>
                        <p style="color: var(--gray-600); line-height: 1.8;">{{ $doctor->bio }}</p>
                    </div>
                @endif
                
                <!-- Schedule -->
                <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                    <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem;">جدول المواعيد</h2>
                    
                    @if($doctor->schedules->count() > 0)
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                            @foreach($doctor->schedules as $schedule)
                                <div style="background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05)); border: 1px solid var(--gray-200); border-radius: 10px; padding: 1rem; text-align: center;">
                                    <p style="font-weight: 700; margin-bottom: 0.5rem;">{{ ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'][$schedule->day_of_week] }}</p>
                                    <p style="color: var(--muted); font-size: 0.9rem;">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                                    @if($schedule->is_available)
                                        <span style="display: inline-block; background: rgba(16, 185, 129, 0.1); color: var(--green); padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8rem; margin-top: 0.5rem; font-weight: 600;">متاح</span>
                                    @else
                                        <span style="display: inline-block; background: rgba(239, 68, 68, 0.1); color: var(--red); padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8rem; margin-top: 0.5rem; font-weight: 600;">غير متاح</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: var(--muted); text-align: center; padding: 2rem;">لم يتم تحديد جدول مواعيد بعد</p>
                    @endif
                </div>
                
                <!-- Reviews/Ratings -->
                <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                    <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem;">التقييمات</h2>
                    
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200);">
                        <div>
                            <div style="font-size: 2.5rem; font-weight: 900; color: var(--yellow);">4.8</div>
                            <div style="color: var(--yellow); font-size: 1.1rem;">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half"></i>
                            </div>
                        </div>
                        <div>
                            <p style="color: var(--muted); font-size: 0.9rem;">بناءً على 128 تقييم</p>
                        </div>
                    </div>
                    
                    <p style="color: var(--muted); text-align: center;">التقييمات من المرضى قريباً...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection