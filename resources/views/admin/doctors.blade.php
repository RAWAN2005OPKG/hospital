@extends('layouts.dashboard')

@section('title', 'إدارة الأطباء')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إدارة الأطباء</h1>
        <p class="page-subtitle">عرض وإدارة الطاقم الطبي في المستشفى</p>
    </div>
    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> إضافة طبيب جديد
    </a>
</div>

<!-- Filters -->
<div class="card" style="background: rgba(0, 102, 204, 0.02); border: 1px solid rgba(0, 102, 204, 0.1);">
    <form action="" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end; padding: 1rem;">
        <div class="form-group" style="margin: 0;">
            <label class="form-label">بحث بالاسم</label>
            <input type="text" name="search" class="form-control" placeholder="ابحث عن طبيب..." value="{{ request('search') }}">
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">القسم</label>
            <select name="department" class="form-control">
                <option value="">كل الأقسام</option>
            </select>
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">التخصص</label>
            <select name="specialization" class="form-control">
                <option value="">كل التخصصات</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="padding: .75rem 1.5rem;">
            <i class="fa-solid fa-magnifying-glass"></i> فلترة
        </button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <span>قائمة الأطباء المسجلين</span>
        <span class="badge badge-blue">{{ $doctors->total() }} طبيب</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الطبيب</th>
                    <th>القسم</th>
                    <th>التخصص</th>
                    <th>الهاتف</th>
                    <th>سنوات الخبرة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: .75rem;">
                            <div style="width: 45px; height: 45px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 900;">
                                {{ mb_substr($doctor->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 700;">{{ $doctor->user->name }}</div>
                                <div style="font-size: .8rem; color: var(--muted);">{{ $doctor->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(0, 188, 212, 0.12); color: #0e7490;">{{ $doctor->department->name ?? 'غير محدد' }}</span>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(107, 114, 128, 0.12); color: #4b5563;">{{ $doctor->specialization->name ?? 'غير محدد' }}</span>
                    </td>
                    <td style="font-family: monospace;">{{ $doctor->user->phone ?? '-' }}</td>
                    <td>
                        <div style="font-weight: 700;">{{ $doctor->experience_years }} سنة</div>
                    </td>
                    <td>
                        <div style="display: flex; gap: .5rem;">
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn" style="padding: 0.5rem; background: transparent; color: var(--primary); border: 1px solid var(--primary); border-radius: 8px;" title="عرض"><i class="fa-solid fa-eye"></i></a>
                            <button class="btn" style="padding: 0.5rem; background: transparent; color: var(--primary); border: 1px solid var(--primary); border-radius: 8px;" title="تعديل"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn" style="padding: 0.5rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;" title="حذف"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 4rem; color: var(--muted);">
                        <i class="fa-solid fa-user-doctor" style="font-size: 3.5rem; margin-bottom: 1rem; display: block; opacity: .2;"></i>
                        لم يتم العثور على أطباء مطابقين للبحث
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $doctors->links() }}
    </div>
</div>
@endsection
