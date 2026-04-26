@extends('layouts.app')
@section('title', 'مختبر تحاليل')

@push('styles')
<style>
.service-hero {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
  box-shadow: 0 10px 40px rgba(16,185,129,0.15);
  border: 1px solid rgba(16,185,129,0.1);
  transition: all 0.3s;
}
.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(16,185,129,0.25);
}
.test-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-top: 3rem;
}
.test-badge {
  background: linear-gradient(135deg, var(--green), #059669);
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 0.9rem;
}
</style>
@endpush>

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="service-hero">
    <h1 class="text-4xl md:text-5xl font-black mb-4">مختبر تحاليل طبية</h1>
    <p class="text-xl md:text-2xl opacity-95">نتائج دقيقة خلال ساعات مع أحدث التقنيات</p>
    <a href="{{ route('contact') }}" class="inline-block mt-8 bg-white text-green-600 px-10 py-4 rounded-full font-bold text-xl hover:bg-green-50 transition-all duration-300 shadow-2xl">
      احجز تحليلك
    </a>
  </div>

  <div class="service-features">
    <div class="feature-card text-center">
      <div class="text-5xl mb-6">🧬</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">نتائج سريعة</h3>
      <p class="text-lg opacity-90">95% من التحاليل تُسلم خلال 4 ساعات مع ضمان الدقة 99.9%</p>
    </div>
    <div class="feature-card text-center">
      <div class="text-5xl mb-6">🔬</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">1000+ تحليل</h3>
      <p class="text-lg opacity-90">جميع أنواع التحاليل الروتينية والمتخصصة بأجهزة حديثة</p>
    </div>
    <div class="feature-card text-center">
      <div class="text-5xl mb-6">📱</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">نتائج إلكترونية</h3>
      <p class="text-lg opacity-90">استلم نتائجك عبر البريد الإلكتروني أو التطبيق مباشرة</p>
    </div>
  </div>

  <div class="test-grid">
    <div class="test-badge">CBC - صورة دم كاملة</div>
    <div class="test-badge">ESR - معدل ترسيب</div>
    <div class="test-badge">FBS - سكر صائم</div>
    <div class="test-badge">LFTs - وظائف الكبد</div>
    <div class="test-badge">KFTs - وظائف الكلى</div>
    <div class="test-badge">Lipid Profile</div>
  </div>
</div>
@endsection

