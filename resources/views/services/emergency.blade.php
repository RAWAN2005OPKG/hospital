@extends('layouts.app')
@section('title', 'طوارئ 24 ساعة')

@push('styles')
<style>
.service-hero {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color: white;
  padding: 4rem 2rem;
  text-align: center;
  border-radius: 24px;
  margin-bottom: 3rem;
  position: relative;
  overflow: hidden;
}
.service-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"25\" cy=\"25\" r=\"1\" fill=\"white\" opacity=\"0.1\"/><circle cx=\"75\" cy=\"75\" r=\"1.5\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"></rect></svg>');
}
.service-features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}
.feature-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 10px 40px rgba(239,68,68,0.15);
  border: 1px solid rgba(239,68,68,0.1);
  transition: all 0.3s;
}
.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(239,68,68,0.25);
}
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="service-hero">
    <h1 class="text-4xl md:text-5xl font-black mb-4">طوارئ 24 ساعة</h1>
    <p class="text-xl md:text-2xl opacity-95">متوفر على مدار الساعة طوال أيام الأسبوع</p>
    <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center items-center">
      <a href="{{ route('contact') }}" class="bg-white text-red-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-red-50 transition-all duration-300 shadow-2xl">
        اطلب الإسعاف الآن
      </a>
      <div class="text-2xl">🩹 ☎️ ⚡</div>
    </div>
  </div>

  <div class="service-features">
    <div class="feature-card text-center">
      <div class="text-4xl mb-4">⏰</div>
      <h3 class="text-2xl font-bold mb-3 text-gray-800">عمل متواصل 24/7</h3>
      <p>فريق طبي متخصص متواجد على مدار 24 ساعة للتعامل مع جميع الحالات الطارئة</p>
    </div>
    <div class="feature-card text-center">
      <div class="text-4xl mb-4">🚑</div>
      <h3 class="text-2xl font-bold mb-3 text-gray-800">استقبال فوري</h3>
      <p>دخول مباشر بدون انتظار مع أحدث المعدات الطبية والأجهزة التشخيصية</p>
    </div>
    <div class="feature-card text-center">
      <div class="text-4xl mb-4">👨‍⚕️</div>
      <h3 class="text-2xl font-bold mb-3 text-gray-800">أطباء متخصصون</h3>
      <p>25 طبيب متخصص في جميع التخصصات الطارئة مع خبرة تزيد عن 15 سنة</p>
    </div>
  </div>
</div>
@endsection

