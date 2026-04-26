@extends('layouts.app')
@section('title', 'صيدلية داخلية')

@push('styles')
<style>
.pharmacy-hero {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  padding: 4rem 2rem;
  text-align: center;
  border-radius: 24px;
  margin-bottom: 3rem;
  position: relative;
}
.pharmacy-hero::before {
  content: '💊';
  font-size: 8rem;
  position: absolute;
  top: -40px;
  right: 2rem;
  opacity: 0.1;
}
.stock-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  margin: 3rem 0;
}
.stock-item {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 8px 32px rgba(245,158,11,0.15);
  border-top: 4px solid #f59e0b;
  transition: all 0.3s;
}
.stock-item:hover {
  transform: scale(1.05);
}
.meds-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}
</style>
@endpush>

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="pharmacy-hero">
    <h1 class="text-4xl md:text-5xl font-black mb-6 relative z-10">صيدلية داخلية 24 ساعة</h1>
    <p class="text-xl md:text-2xl opacity-95 relative z-10">أدوية موثوقة بأسعار تنافسية - خدمة توصيل داخل المستشفى</p>
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center relative z-10">
      <a href="{{ route('contact') }}" class="bg-white text-orange-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-orange-50 shadow-2xl">
        اطلب دواك
      </a>
      <span class="text-2xl opacity-90">🚚💊⚡</span>
    </div>
  </div>

  <div class="grid md:grid-cols-3 gap-6 mb-12">
    <div class="feature-card p-8 text-center bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl border border-orange-100">
      <div class="text-5xl mb-6">📦</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">15000+ دواء</h3>
      <p>مخزون شامل لجميع الأدوية الأصلية والجنيسة بأحدث المواعيد الصلاحية</p>
    </div>
    <div class="feature-card p-8 text-center bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl border border-orange-100">
      <div class="text-5xl mb-6">💳</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">أسعار تنافسية</h3>
      <p>خصم يصل 30% على جميع الأدوية مقارنة بالصيدليات الخارجية</p>
    </div>
    <div class="feature-card p-8 text-center bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl border border-orange-100">
      <div class="text-5xl mb-6">⏱️</div>
      <h3 class="text-2xl font-bold mb-4 text-gray-800">توصيل فوري</h3>
      <p>توصيل للأقسام والغرف خلال 15 دقيقة على مدار 24 ساعة</p>
    </div>
  </div>

  <div class="stock-grid">
    <div class="stock-item">
      <div class="meds-icon">💊</div>
      <h4 class="font-bold text-lg mb-2">مضادات حيوية</h4>
      <span class="text-sm text-gray-600">متوفرة 24/7</span>
    </div>
    <div class="stock-item">
      <div class="meds-icon">💉</div>
      <h4 class="font-bold text-lg mb-2">مسكنات</h4>
      <span class="text-sm text-gray-600">كافة الأنواع</span>
    </div>
    <div class="stock-item">
      <div class="meds-icon">🫀</div>
      <h4 class="font-bold text-lg mb-2">قلب وضغط</h4>
      <span class="text-sm text-gray-600">أحدث الأدوية</span>
    </div>
    <div class="stock-item">
      <div class="meds-icon">🩹</div>
      <h4 class="font-bold text-lg mb-2">علاج السكري</h4>
      <span class="text-sm text-gray-600">إنسولين + أقراص</span>
    </div>
    <div class="stock-item">
      <div class="meds-icon">🧪</div>
      <h4 class="font-bold text-lg mb-2">فيتامينات</h4>
      <span class="text-sm text-gray-600">حقن + أقراص</span>
    </div>
    <div class="stock-item">
      <div class="meds-icon">🌿</div>
      <h4 class="font-bold text-lg mb-2">أعشاب طبيعية</h4>
      <span class="text-sm text-gray-600">منتجات عضوية</span>
    </div>
  </div>
</div>
@endsection

