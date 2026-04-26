@extends('layouts.app')

@section('title', 'الرئيسية - صحتي')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-2xl overflow-hidden mb-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-12 items-center">
        <div>
            <h1 class="text-5xl font-bold mb-4">رعاية حنونة، نتائج استثنائية</h1>
            <p class="text-xl text-blue-100 mb-8">فريقنا من الأطباء المتخصصين مكرسون لتقديم أفضل الخدمات الطبية والرعاية الشخصية لمرضانا.</p>
            <div class="flex gap-4">
                <a href="{{ route('appointments.search') }}" class="btn-primary bg-white text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-calendar-check ml-2"></i>احجز موعد
                </a>
                <button class="btn-outline border-white text-white hover:bg-white hover:text-blue-600">
                    <i class="fas fa-play-circle ml-2"></i>شاهد كيف نعمل
                </button>
            </div>
        </div>
        <div class="text-center">
            <img src="https://via.placeholder.com/400x400?text=Doctors" alt="أطباء" class="rounded-2xl shadow-2xl">
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
    <div class="card text-center">
        <div class="text-4xl font-bold text-blue-600 mb-2">20+</div>
        <p class="text-gray-600">سنة من الخبرة</p>
    </div>
    <div class="card text-center">
        <div class="text-4xl font-bold text-teal-600 mb-2">95%</div>
        <p class="text-gray-600">رضا المرضى</p>
    </div>
    <div class="card text-center">
        <div class="text-4xl font-bold text-blue-600 mb-2">5000+</div>
        <p class="text-gray-600">مريض سعيد</p>
    </div>
    <div class="card text-center">
        <div class="text-4xl font-bold text-teal-600 mb-2">10+</div>
        <p class="text-gray-600">أقسام متخصصة</p>
    </div>
</div>

<!-- About Us Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16 items-center">
    <div>
        <p class="text-blue-600 font-bold text-lg mb-2">من نحن</p>
        <h2 class="section-title">صحتي - فريق من المتخصصين الطبيين</h2>
        <p class="text-gray-600 text-lg mb-6">نحن مكرسون لتقديم خدمات طبية عالية الجودة مع التركيز على راحة المريض والرعاية الشخصية. فريقنا يتكون من أطباء ذوي خبرة عالية في مختلف التخصصات الطبية.</p>
        <ul class="space-y-4">
            <li class="flex items-center">
                <i class="fas fa-check-circle text-teal-600 ml-3 text-xl"></i>
                <span>أطباء متخصصون وذوو خبرة</span>
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-teal-600 ml-3 text-xl"></i>
                <span>معدات طبية حديثة</span>
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-teal-600 ml-3 text-xl"></i>
                <span>رعاية شاملة وشخصية</span>
            </li>
        </ul>
    </div>
    <div>
        <img src="https://via.placeholder.com/400x400?text=Medical+Team" alt="فريق طبي" class="rounded-2xl shadow-lg">
    </div>
</div>

<!-- Departments Section -->
<div class="mb-16">
    <p class="text-blue-600 font-bold text-lg mb-2">أقسامنا</p>
    <h2 class="section-title">لصحتك الأفضل</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $departments = [
                ['name' => 'قسم الطوارئ', 'icon' => 'fa-ambulance', 'color' => 'blue'],
                ['name' => 'طب الأطفال', 'icon' => 'fa-baby', 'color' => 'teal'],
                ['name' => 'النساء والتوليد', 'icon' => 'fa-heart', 'color' => 'blue'],
                ['name' => 'أمراض القلب', 'icon' => 'fa-heartbeat', 'color' => 'teal'],
                ['name' => 'الأعصاب', 'icon' => 'fa-brain', 'color' => 'blue'],
                ['name' => 'الطب النفسي', 'icon' => 'fa-head-side-virus', 'color' => 'teal'],
            ];
        @endphp
        
        @foreach($departments as $dept )
        <div class="card text-center hover:shadow-lg transition">
            <div class="w-16 h-16 bg-{{ $dept['color'] }}-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas {{ $dept['icon'] }} text-{{ $dept['color'] }}-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $dept['name'] }}</h3>
            <p class="text-gray-600">خدمات طبية متخصصة وعالية الجودة</p>
        </div>
        @endforeach
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-2xl p-12 text-center">
    <h2 class="text-4xl font-bold mb-4">هل أنت مستعد للعناية الصحية الأفضل؟</h2>
    <p class="text-xl text-blue-100 mb-8">احجز موعدك الآن مع أفضل الأطباء المتخصصين</p>
    <a href="{{ route('appointments.search') }}" class="btn-primary bg-white text-blue-600 hover:bg-blue-50 inline-block">
        <i class="fas fa-calendar-check ml-2"></i>احجز موعدك الآن
    </a>
</div>
@endsection