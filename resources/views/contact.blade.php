@extends('layouts.app')

@section('title', 'اتصل بنا - صحتي')

@section('content')
<div class="mb-8">
    <h1 class="section-title">اتصل بنا</h1>
    <p class="section-subtitle">نحن هنا للإجابة على جميع استفساراتك</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
    <!-- Contact Info -->
    <div class="md:col-span-1">
        <div class="card mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-phone text-2xl text-blue-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">الهاتف</h3>
            <p class="text-gray-600">+966 50 000 0000</p>
        </div>
        
        <div class="card mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-teal-200 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-envelope text-2xl text-teal-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">البريد الإلكتروني</h3>
            <p class="text-gray-600">info@sahati.com</p>
        </div>
        
        <div class="card">
            <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-map-marker-alt text-2xl text-green-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">العنوان</h3>
            <p class="text-gray-600">الرياض، السعودية</p>
        </div>
    </div>
    
    <!-- Contact Form -->
    <div class="md:col-span-2">
        <div class="card">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-lg font-bold text-gray-800 mb-3">الاسم</label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-lg font-bold text-gray-800 mb-3">البريد الإلكتروني</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-lg font-bold text-gray-800 mb-3">الموضوع</label>
                    <input type="text" name="subject" class="input-field" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-lg font-bold text-gray-800 mb-3">الرسالة</label>
                    <textarea name="message" class="input-field" rows="6" required></textarea>
                </div>
                
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-paper-plane ml-2"></i>إرسال الرسالة
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="card">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">موقعنا</h2>
    <div class="h-96 bg-gray-200 rounded-xl flex items-center justify-center">
        <i class="fas fa-map text-6xl text-gray-400"></i>
    </div>
</div>
@endsection