@extends('layouts.app')

@section('title', 'الاستشارات الطبية')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" style="margin-top: 80px;">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-bold mb-4">الاستشارات</span>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">استشارات طبية عن بعد</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">تواصل مع نخبة من الأطباء من منزلك وبكل خصوصية</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Chat Section -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl shadow-lg">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">مساعدك الطبي الذكي</h4>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 min-h-[300px] mb-6 border border-gray-200 dark:border-gray-700 flex justify-center items-center text-gray-400">
                        ابدأ المحادثة الآن لوصف حالتك...
                    </div>
                    <form action="#" class="flex gap-3">
                        <input type="text" class="flex-1 px-6 py-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none dark:text-white" placeholder="اكتب سؤالك هنا...">
                        <button class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-lg">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar Doctors -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 border border-gray-100 dark:border-gray-700">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6">أطباء متاحون الآن</h4>
                    <div class="space-y-6">
                        @php $realDoctors = \App\Models\Doctor::with('user', 'specialization')->limit(5)->get(); @endphp
                        @foreach($realDoctors as $doc)
                        <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                {{ mb_substr($doc->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $doc->user->name }}</div>
                                <div class="text-xs text-blue-600">{{ $doc->specialization->name ?? 'طبيب عام' }}</div>
                            </div>
                            <a href="{{ route('doctors.show', $doc) }}" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-bold">اتصال</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
