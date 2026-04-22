@extends('layouts.app')

@section('title', 'من نحن - صحتي')

@section('content')
<!-- Header -->
<div class="mb-16">
    <h1 class="section-title">من نحن</h1>
    <p class="section-subtitle">تعرف على قصة مستشفى صحتي</p>
</div>

<!-- About Content -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16 items-center">
    <div>
        <img src="https://via.placeholder.com/400x400?text=About" alt="عن المستشفى" class="rounded-3xl shadow-2xl">
    </div>
    <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-6">مستشفى صحتي</h2>
        <p class="text-gray-600 text-lg mb-4 leading-relaxed">
            مستشفى صحتي هو مؤسسة طبية رائدة متخصصة في تقديم خدمات صحية شاملة وعالية الجودة. تأسست المستشفى برؤية واضحة لتوفير رعاية صحية متميزة لجميع أفراد المجتمع.
        </p>
        <p class="text-gray-600 text-lg mb-4 leading-relaxed">
            نحن نؤمن بأن الصحة هي أعظم ثروة، ولذلك نسعى جاهدين لتوفير أفضل الخدمات الطبية باستخدام أحدث التقنيات والمعدات الطبية.
        </p>
        <p class="text-gray-600 text-lg leading-relaxed">
            فريقنا يتكون من أطباء متخصصين وذوي خبرة عالية، مما يضمن تقديم أفضل رعاية صحية لمرضانا.
        </p>
    </div>
</div>

<!-- Mission, Vision, Values -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
    <div class="card text-center">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-bullseye text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">رسالتنا</h3>
        <p class="text-gray-600">تقديم خدمات طبية عالية الجودة مع التركيز على رضا المريض والرعاية الشخصية</p>
    </div>
    
    <div class="card text-center">
        <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-eye text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">رؤيتنا</h3>
        <p class="text-gray-600">أن نكون المستشفى الأول المفضل لدى المرضى في تقديم الخدمات الصحية</p>
    </div>
    
    <div class="card text-center">
        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-heart text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">قيمنا</h3>
        <p class="text-gray-600">الأمانة والشفافية والتميز في تقديم الخدمات الطبية</p>
    </div>
</div>

<!-- Team Section -->
<div class="mb-16">
    <h2 class="section-title">فريق الإدارة</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $team = [
                ['name' => 'د. محمد أحمد', 'position' => 'المدير العام', 'image' => 'https://via.placeholder.com/300x300?text=Manager1'],
                ['name' => 'د. فاطمة علي', 'position' => 'مدير الخدمات الطبية', 'image' => 'https://via.placeholder.com/300x300?text=Manager2'],
                ['name' => 'د. سارة محمود', 'position' => 'مدير التمريض', 'image' => 'https://via.placeholder.com/300x300?text=Manager3'],
            ];
        @endphp
        
        @foreach($team as $member )
        <div class="card text-center">
            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-full h-64 object-cover rounded-2xl mb-4">
            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $member['name'] }}</h3>
            <p class="text-teal-600 font-semibold">{{ $member['position'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- Achievements Section -->
<div class="card mb-16">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">إنجازاتنا</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="text-center">
            <p class="text-4xl font-bold text-blue-600 mb-2">20+</p>
            <p class="text-gray-600">سنة من الخبرة</p>
        </div>
        <div class="text-center">
            <p class="text-4xl font-bold text-teal-600 mb-2">500K+</p>
            <p class="text-gray-600">مريض تم علاجهم</p>
        </div>
        <div class="text-center">
            <p class="text-4xl font-bold text-green-600 mb-2">150+</p>
            <p class="text-gray-600">طبيب متخصص</p>
        </div>
        <div class="text-center">
            <p class="text-4xl font-bold text-purple-600 mb-2">98%</p>
            <p class="text-gray-600">نسبة الشفاء</p>
        </div>
    </div>
</div>
@endsection