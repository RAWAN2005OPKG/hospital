@extends('layouts.app')

@section('title', 'إدارة الأقسام - صحتي')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-black text-slate-900">إدارة الأقسام</h1>
                <p class="text-slate-600 mt-2">إدارة جميع الأقسام الطبية</p>
            </div>
            <a href="{{ route('admin.departments.create') }}" class="px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold hover:shadow-lg transition">
                <i class="fas fa-plus ml-2"></i>إضافة قسم جديد
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border-2 border-green-200 text-green-700 font-semibold">
                <i class="fas fa-check-circle ml-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Departments Table -->
        @if($departments->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-right font-bold">اسم القسم</th>
                                <th class="px-6 py-4 text-right font-bold">المسؤول</th>
                                <th class="px-6 py-4 text-right font-bold">الجوال</th>
                                <th class="px-6 py-4 text-right font-bold">الصورة</th>
                                <th class="px-6 py-4 text-center font-bold">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($departments as $department)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $department->name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $department->manager_name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $department->phone }}</td>
                                    <td class="px-6 py-4">
                                        @if($department->image)
                                            <img src="{{ asset($department->image) }}" alt="{{ $department->name }}" class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <span class="text-slate-400">بدون صورة</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.departments.edit', $department->id) }}" class="px-4 py-2 rounded-lg bg-blue-100 text-blue-600 font-bold hover:bg-blue-200 transition">
                                                <i class="fas fa-edit ml-1"></i>تعديل
                                            </a>
                                            <form method="POST" action="{{ route('admin.departments.destroy', $department->id) }}" class="inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded-lg bg-red-100 text-red-600 font-bold hover:bg-red-200 transition">
                                                    <i class="fas fa-trash ml-1"></i>حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-12 text-center">
                <i class="fas fa-inbox text-6xl text-slate-300 mb-4"></i>
                <p class="text-xl text-slate-600 mb-6">لا توجد أقسام بعد</p>
                <a href="{{ route('admin.departments.create') }}" class="inline-block px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold hover:shadow-lg transition">
                    <i class="fas fa-plus ml-2"></i>إضافة قسم جديد
                </a>
            </div>
        @endif
    </div>
</div>

@endsection