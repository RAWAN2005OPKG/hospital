@extends('layouts.app')
@section('title', 'خدماتنا الطبية')

@section('content')
<div class="section-head" style="margin-top: 100px;">
    <span class="sec-tag">خدماتنا</span>
    <h2>رعاية صحية متكاملة</h2>
    <p>نقدم مجموعة واسعة من الخدمات الطبية المتميزة بأحدث التقنيات العالمية</p>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 5rem;">
        @foreach([
            ['icon' => 'fa-truck-medical', 'title' => 'الطوارئ', 'desc' => 'خدمة طوارئ على مدار الساعة مع طاقم طبي متخصص.'],
            ['icon' => 'fa-flask-vial', 'title' => 'المختبرات', 'desc' => 'أحدث أجهزة التحليل الطبي لضمان دقة النتائج.'],
            ['icon' => 'fa-x-ray', 'title' => 'الأشعة', 'desc' => 'تصوير إشعاعي متقدم (رنين، مقطعية، وسينية).'],
            ['icon' => 'fa-pills', 'title' => 'الصيدلية', 'desc' => 'توفير كافة الأدوية والمستلزمات الطبية اللازمة.'],
            ['icon' => 'fa-user-doctor', 'title' => 'العيادات الخارجية', 'desc' => 'نخبة من الأطباء في كافة التخصصات الطبية.'],
            ['icon' => 'fa-bed-pulse', 'title' => 'العناية المركزة', 'desc' => 'وحدات مجهزة بأحدث أجهزة مراقبة المؤشرات الحيوية.']
        ] as $service)
        <div class="card" style="text-align: center;">
            <div style="width: 70px; height: 70px; border-radius: 20px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem;">
                <i class="fa-solid {{ $service['icon'] }}"></i>
            </div>
            <h3 style="margin-bottom: 1rem;">{{ $service['title'] }}</h3>
            <p style="color: var(--gray-500); font-size: 0.95rem;">{{ $service['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
