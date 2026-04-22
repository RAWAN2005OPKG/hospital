@extends('layouts.app')

@section('title', 'إنشاء حساب Admin - صحتي')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-orange-600 px-8 py-8 text-center">
                <h1 class="text-3xl font-black text-white mb-2">صحتي</h1>
                <p class="text-orange-100">إنشاء حساب مدير النظام</p>
            </div>

            <!-- Warning -->
            <div class="bg-yellow-50 border-b border-yellow-200 px-8 py-4">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-exclamation-triangle ml-2"></i>
                    هذه الصفحة متاحة فقط لإنشاء أول حساب admin
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('create-admin') }}" class="p-8 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-user ml-2 text-red-600"></i>الاسم الكامل
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-red-500 focus:outline-none transition @error('name') border-red-500 @enderror"
                        placeholder="أدخل اسمك الكامل">
                    @error('name')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-envelope ml-2 text-red-600"></i>البريد الإلكتروني
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-red-500 focus:outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-phone ml-2 text-red-600"></i>رقم الجوال
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-red-500 focus:outline-none transition @error('phone') border-red-500 @enderror"
                        placeholder="+966 50 000 0000">
                    @error('phone')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-lock ml-2 text-red-600"></i>كلمة المرور
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-red-500 focus:outline-none transition @error('password') border-red-500 @enderror"
                        placeholder="أدخل كلمة المرور">
                    @error('password')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-lock ml-2 text-red-600"></i>تأكيد كلمة المرور
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-red-500 focus:outline-none transition"
                        placeholder="أعد إدخال كلمة المرور">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-red-600 to-orange-600 text-white font-bold hover:shadow-lg transition">
                    <i class="fas fa-shield-alt ml-2"></i>إنشاء حساب Admin
                </button>
            </form>
        </div>
    </div>
</div>

@endsection