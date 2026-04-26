@extends('layouts.app')
@section('title', 'أشعة وتصوير')

@push('styles')
<style>
.service-hero {
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  color: white;
  padding: 4rem 2rem;
  text-align: center;
  border-radius: 24px;
  margin-bottom: 3rem;
}
.feature-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 10px 40px rgba(59,130,246,0.15);
  border: 1px solid rgba(59,130,246,0.1);
}
.equipment-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin: 3rem 0;
}
.equipment-card {
  text-align: center;
  padding: 2rem;
  background: linear-gradient(135deg, #eff6ff, #dbeafe);
  border-radius: 20px;
  border: 2px solid rgba(59,130,246,0.2);
}
</style>
@endpush>

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="service-hero">
    <h1 class="text-4xl md:text-5xl font-black mb-4">أشعة وتصوير طبي</h1>
    <p class="text-xl md:text-2xl opacity-95">أحدث الأجهزة التشخيصية بدقة فائقة</p>
    <a href="{{ route('contact') }}" class="inline-block mt-8 bg-white text-blue-600 px-10 py-4 rounded-full font-bold text-xl hover:bg-blue-50 transition-all">
      احجز موعد تصوير
    </a>
  </div>

  <div class="service-features">
    <div class="feature-card">
      <div class="text-5xl mb-6 inline-block">📸</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">تصوير رقمي</h3>
      <p>أشعة سينية رقمية بجرعات إشعاع منخفضة مع جودة صورة فائقة الوضوح</p>
    </div>
    <div class="feature-card">
      <div class="text-5xl mb-6 inline-block">🧲</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">MRI 1.5 Tesla</h3>
      <p>جهاز رنين مغناطيسي حديث للتشخيص الدقيق لجميع أنواع الأنسجة والعظام</p>
    </div>
    <div class="feature-card">
      <div class="text-5xl mb-6 inline-block">🔬</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">سونار 4D</h3>
      <p>تصوير بالموجات فوق الصوتية بتقنية 4D للكشف المبكر والمتابعة الدورية</p>
    </div>
  </div>

  <div class="equipment-grid">
    <div class="equipment-card">
      <div class="text-5xl mb-4">🖼️</div>
      <h4 class="text-xl font-bold mb-2">X-Ray Digital</h4>
      <p>صور أشعة فورية</p>
    </div>
    <div class="equipment-card">
      <div class="text-5xl mb-4">🧲</div>
      <h4 class="text-xl font-bold mb-2">MRI 1.5T</h4>
      <p>رنين مغناطيسي</p>
    </div>
    <div class="equipment-card">
      <div class="text-5xl mb-4">📡</div>
      <h4 class="text-xl font-bold mb-2">CT Scan 128 Slice</h4>
      <p>توموغرافيا مقطعية</p>
    </div>
    <div class="equipment-card">
      <div class="text-5xl mb-4">🔊</div>
      <h4 class="text-xl font-bold mb-2">Ultrasound 4D</h4>
      <p>سونار ثلاثي الأبعاد</p>
    </div>
  </div>
</div>
@endsection

