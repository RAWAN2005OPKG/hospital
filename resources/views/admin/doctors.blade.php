@extends('layouts.app')

@section('title', 'إدارة الأطباء')

@section('content')
<div class="container section">
    <div class="mb-8" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">إدارة الأطباء</h1>
            <p style="color: var(--muted);">عرض وإدارة الطاقم الطبي في المستشفى</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> إضافة طبيب جديد
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-8" style="background: var(--blue-lt); border-color: var(--blue-lt);">
        <div class="card-body">
            <form action="" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
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
    </div>

    <div class="card">
        <div class="card-header">
            <span>قائمة الأطباء المسجلين</span>
            <span class="badge badge-blue">{{ $doctors->total() }} طبيب</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
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
                                    <div style="width: 45px; height: 45px; border-radius: 12px; background: linear-gradient(135deg, var(--blue), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 900;">
                                        {{ mb_substr($doctor->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700;">{{ $doctor->user->name }}</div>
                                        <div style="font-size: .8rem; color: var(--muted);">{{ $doctor->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-cyan">{{ $doctor->department->name ?? 'غير محدد' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-gray">{{ $doctor->specialization->name ?? 'غير محدد' }}</span>
                            </td>
                            <td style="font-family: monospace;">{{ $doctor->user->phone ?? '-' }}</td>
                            <td>
                                <div style="font-weight: 700;">{{ $doctor->experience_years }} سنة</div>
                            </td>
                            <td>
                                <div style="display: flex; gap: .5rem;">
                                    <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-sm btn-outline" title="عرض"><i class="fa-solid fa-eye"></i></a>
                                    <button class="btn btn-sm btn-outline" title="تعديل"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none;" title="حذف"><i class="fa-solid fa-trash"></i></button>
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
    </div>
</div>
@endsection
