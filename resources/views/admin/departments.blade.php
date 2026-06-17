@extends('layouts.app')

@section('title', 'إدارة الأقسام والتخصصات')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">الهيكل التنظيمي</h1>
        <p class="page-subtitle">إدارة الأقسام الطبية وتوزيع التخصصات</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus-circle"></i> إضافة قسم طبي
        </a>
        <a href="{{ route('admin.specializations.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--success), #059669);">
            <i class="fa-solid fa-stethoscope"></i> إضافة تخصص
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem;">
    <!-- Departments Management -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; background: #fff; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-hospital" style="color: var(--primary); margin-left: 0.5rem;"></i> الأقسام الطبية</h3>
            <span class="badge badge-gray">{{ $departments->total() }} قسم</span>
        </div>
        
        <div class="table-container" style="padding: 1rem;">
            <table>
                <thead>
                    <tr>
                        <th>القسم</th>
                        <th style="text-align: center;">الأطباء</th>
                        <th style="text-align: left;">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td>
                            <div style="font-weight: 900; color: var(--gray-900); font-size: 1.05rem;">{{ $dept->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--gray-500); margin-top: 0.25rem;">{{ Str::limit($dept->description, 60) }}</div>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-blue">{{ $dept->doctors_count }} طبيب</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                <a href="{{ route('admin.departments.edit', $dept->id) }}" class="btn btn-white btn-sm" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i>
                                </a>
                                <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('حذف القسم سيؤدي لإزالة كافة التخصصات المرتبطة به. هل أنت متأكد؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm" title="حذف">
                                        <i class="fa-solid fa-trash" style="color: var(--danger);"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align: center; padding: 4rem; color: var(--gray-400);">لا توجد أقسام مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;">{{ $departments->links() }}</div>
    </div>

    <!-- Specializations -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.25rem; background: #fff; border-bottom: 1px solid var(--gray-100);">
            <h3 class="card-title" style="font-size: 1rem; margin: 0;"><i class="fa-solid fa-stethoscope" style="color: var(--success); margin-left: 0.5rem;"></i> التخصصات الطبية</h3>
        </div>
        <div style="padding: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @forelse($specializations as $spec)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1rem; background: var(--gray-50); border-radius: 12px; border: 1px solid var(--gray-100);">
                    <div>
                        <div style="font-weight: 800; color: var(--gray-800); font-size: 0.95rem;">{{ $spec->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $spec->department->name ?? '---' }}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <a href="{{ route('admin.specializations.edit', $spec->id) }}" style="color: var(--primary);"><i class="fa-solid fa-edit"></i></a>
                        <form action="{{ route('admin.specializations.destroy', $spec->id) }}" method="POST" onsubmit="return confirm('حذف التخصص؟');">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: var(--gray-400); padding: 1rem;">لا توجد تخصصات</p>
                @endforelse
            </div>
            <div style="margin-top: 1rem;">{{ $specializations->links() }}</div>
        </div>
    </div>
</div>
@endsection
