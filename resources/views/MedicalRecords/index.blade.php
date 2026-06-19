@extends('layouts.app')

@section('title', __('messages.medical_records_title'))

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-file-medical text-blue-600 mr-2"></i>
                {{ __('messages.medical_records_title') }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                {{ __('messages.medical_records_subtitle') }}
            </p>
        </div>

        <!-- Records Table -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm leading-normal">
                            <th class="py-4 px-6 font-bold text-lg text-center">التاريخ</th>
                            <th class="py-4 px-6 font-bold text-lg text-center">التشخيص</th>
                            <th class="py-4 px-6 font-bold text-lg text-center">الطبيب</th>
                            <th class="py-4 px-6 font-bold text-lg text-center">القسم</th>
                            <th class="py-4 px-6 font-bold text-lg text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-300 text-sm font-light">
                        @forelse($records ?? [] as $record)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-200">
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $record->created_at->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-4 py-2 bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 font-bold rounded-2xl text-sm">
                                    {{ $record->diagnosis }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ mb_substr($record->doctor->user->name ?? 'د', 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $record->doctor->user->name ?? 'طبيب' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-4 py-2 bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300 font-bold rounded-2xl text-sm">
                                    {{ $record->doctor->department->name ?? 'عام' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="#" class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all hover:shadow-lg">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-gray-500">لا توجد سجلات حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
