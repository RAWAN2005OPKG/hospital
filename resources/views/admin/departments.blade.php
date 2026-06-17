@extends('layouts.app')

@section('title', 'إدارة الأقسام والتخصصات')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">الهيكل التنظيمي</h1>
        <p class="page-subtitle">إدارة الأقسام الطبية وتوزيع التخصصات لضمان دقة توجيه المرضى</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--primary), #004499);">
            <i class="fa-solid fa-plus-circle"></i> إضافة قسم طبي
        </a>
        <a href="{{ route('admin.specializations.create') }}" class="btn" style="background: linear-gradient(135deg, var(--success), #059669); color: #fff; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
            <i class="fa-solid fa-stethoscope"></i> إضافة تخصص
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem;">
    <!-- Departments Management -->
    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
        <div style="padding: 1.5rem; background: #fff; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-hospital" style="color: var(--primary); margin-left: 0.5rem;"></i> الأقسام الطبية الحالية</h3>
            <span style="background: var(--gray-100); color: var(--gray-600); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 800;">{{ $departments->total() }} قسم</span>
        </div>
        
        <div class="table-container" style="padding: 1rem;">
            <table style="border-spacing: 0 0.5rem;">
                <thead>
                    <tr style="background: var(--gray-50);">
                        <th style="padding: 1rem; border-radius: 0 10px 10px 0;">القسم</th>
                        <th style="padding: 1rem; text-align: center;">التخصصات</th>
                        <th style="padding: 1rem; text-align: center;">الأطباء</th>
                        <th style="padding: 1rem; text-align: left; border-radius: 10px 0 0 10px;">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr style="transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.01)';" onmouseout="this.style.transform='scale(1)';">
                        <td style="padding: 1.25rem 1rem; border-radius: 0 12px 12px 0; background: #fff; border: 1px solid var(--gray-100); border-left: none;">
                            <div style="font-weight: 900; color: var(--gray-900); font-size: 1.05rem;">{{ $dept->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--gray-500); margin-top: 0.25rem;">{{ Str::limit($dept->description, 60) }}</div>
                        </td>
                        <td style="padding: 1.25rem 1rem; text-align: center; background: #fff; border-top: 1px solid var(--gray-100); border-bottom: 1px solid var(--gray-100);">
                            <span style="font-weight: 700; color: var(--gray-700);">{{ $dept->specializations_count ?? 0 }}</span>
                        </td>
                        <td style="padding: 1.25rem 1rem; text-align: center; background: #fff; border-top: 1px solid var(--gray-100); border-bottom: 1px solid var(--gray-100);">
                            <div style="background: rgba(0, 102, 204, 0.08); color: var(--primary); display: inline-block; padding: 0.25rem 0.75rem; border-radius: 30px; font-size: 0.85rem; font-weight: 800;">
                                {{ $dept->doctors_count }} طبيب
                            </div>
                        </td>
                        <td style="padding: 1.25rem 1rem; border-radius: 12px 0 0 12px; background: #fff; border: 1px solid var(--gray-100); border-right: none; text-align: left;">
                            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                <a href="{{ route('admin.departments.edit', $dept->id) }}" style="width: 35px; height: 35px; border-radius: 8px; background: var(--gray-50); color: var(--primary); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('حذف القسم سيؤدي لإزالة كافة التخصصات المرتبطة به. هل أنت متأكد؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="width: 35px; height: 35px; border-radius: 8px; background: #fff5f5; color: var(--danger); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='var(--danger)'; this.style.color='#fff';">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align: center; padding: 4rem; color: var(--gray-400);">
                        <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                        لا توجد أقسام طبية مسجلة حالياً
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;">{{ $departments->links() }}</div>
    </div>

    <!-- Specializations Summary -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card" style="border: none; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff;">
            <h4 style="font-weight: 800; margin-bottom: 0.5rem;">لماذا هذه الصفحة؟</h4>
            <p style="font-size: 0.85rem; line-height: 1.6; opacity: 0.9;">
                الأقسام التي تضيفها هنا هي العمود الفقري للمستشفى. بمجرد إضافة قسم، سيظهر فوراً كخيار للأطباء الجدد وللمرضى عند حجز مواعيدهم، مما يضمن ترحيل البيانات وتكاملها في كل النظام.
            </p>
        </div>

        <div class="card" style="padding: 0; overflow: hidden; border: none;">
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
                        <div style="font-weight: 900; color: var(--success); font-size: 1.1rem;">{{ $spec->doctors_count }}</div>
                    </div>
                    @empty
                    <p style="text-align: center; color: var(--gray-400); padding: 1rem;">لا توجد تخصصات</p>
                    @endforelse
                </div>
                <div style="margin-top: 1rem;">{{ $specializations->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
