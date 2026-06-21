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
.service-features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
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
  padding: 1rem 1.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1rem;
  text-align: center;
  transition: all 0.3s;
}
.test-badge:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(16,185,129,0.3);
}
.section-title {
  text-align: center;
  font-size: 2.5rem;
  font-weight: 800;
  color: #1f2937;
  margin: 4rem 0 2rem;
}
.how-it-work {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.step-number {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: 800;
  margin: 0 auto 1rem;
}
.cta-section {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  padding: 4rem 2rem;
  text-align: center;
  border-radius: 24px;
  margin-top: 4rem;
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

  <h2 class="section-title">التحاليل المتوفرة</h2>
  <div class="test-grid">
    <div class="test-badge">CBC - صورة دم كاملة</div>
    <div class="test-badge">ESR - معدل ترسيب</div>
    <div class="test-badge">FBS - سكر صائم</div>
    <div class="test-badge">LFTs - وظائف الكبد</div>
    <div class="test-badge">KFTs - وظائف الكلى</div>
    <div class="test-badge">Lipid Profile</div>
    <div class="test-badge">TSH - هرمون الغدة الدرقية</div>
    <div class="test-badge">HbA1c - سكر تراكمي</div>
    <div class="test-badge">Vit D - فيتامين د</div>
    <div class="test-badge">Iron Profile - حديد</div>
    <div class="test-badge">Urine Analysis - تحليل بول</div>
    <div class="test-badge">Stool Analysis - تحليل براز</div>
  </div>

  <h2 class="section-title">كيف نعمل</h2>
  <div class="service-features">
    <div class="how-it-work">
      <div class="step-number">1</div>
      <h3 class="text-xl font-bold mb-3 text-gray-800">احجز موعدك</h3>
      <p class="text-gray-600">احجز عبر الموقع أو التطبيق أو اتصل بنا</p>
    </div>
    <div class="how-it-work">
      <div class="step-number">2</div>
      <h3 class="text-xl font-bold mb-3 text-gray-800">أخذ العينة</h3>
      <p class="text-gray-600">زيارتنا في المختبر أو نأتي العينة لمنزلك</p>
    </div>
    <div class="how-it-work">
      <div class="step-number">3</div>
      <h3 class="text-xl font-bold mb-3 text-gray-800">التحليل</h3>
      <p class="text-gray-600">نقوم بالتحليل بأحدث الأجهزة بدقة عالية</p>
    </div>
    <div class="how-it-work">
      <div class="step-number">4</div>
      <h3 class="text-xl font-bold mb-3 text-gray-800">استلم النتائج</h3>
      <p class="text-gray-600">احصل على نتائجك إلكترونياً خلال ساعات</p>
    </div>
  </div>

  <div class="cta-section">
    <h2 class="text-3xl md:text-4xl font-black mb-4">جاهز لحجز تحليلك؟</h2>
    <p class="text-xl opacity-95 mb-8">فريقنا الطبي جاهز لخدمتك بأعلى معايير الجودة</p>
    <a href="{{ route('contact') }}" class="inline-block bg-white text-green-600 px-12 py-4 rounded-full font-bold text-xl hover:bg-green-50 transition-all duration-300 shadow-2xl">
      تواصل معنا الآن
    </a>
  </div>
</div>
@endsection

