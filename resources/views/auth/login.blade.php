@extends('layouts.app')

@section('title', 'تسجيل الدخول - صحتي')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-8 py-8 text-center">
                <h1 class="text-3xl font-black text-white mb-2">صحتي</h1>
                <p class="text-blue-100">تسجيل الدخول</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="p-8 space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-envelope ml-2 text-blue-600"></i>البريد الإلكتروني
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-lock ml-2 text-blue-600"></i>كلمة المرور
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition"
                        placeholder="أدخل كلمة المرور">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="w-4 h-4 rounded border-slate-300 text-blue-600 cursor-pointer">
                    <label for="remember" class="mr-2 text-sm text-slate-600 cursor-pointer">تذكرني</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold hover:shadow-lg transition">
                    <i class="fas fa-sign-in-alt ml-2"></i>تسجيل الدخول
                </button>

                <!-- Register Link -->
                <p class="text-center text-slate-600">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">إنشاء حساب</a>
                </p>
            </form>
        </div>
    </div>
</div>

@endsection