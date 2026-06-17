@extends('layouts.app')

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

<div class="card" style="margin-bottom: 2rem;">
    <form action="" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
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
        <button type="submit" class="btn btn-light">
            <i class="fa-solid fa-filter"></i> فلترة
        </button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">قائمة الأطباء المسجلين</h3>
        <span class="badge badge-primary">{{ $doctors->total() }} طبيب</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الطبيب</th>
                    <th>القسم</th>
                    <th>التخصص</th>
                    <th>الهاتف</th>
                    <th>الخبرة</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), #3b82f6); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);">
                                {{ mb_substr($doctor->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--text-main);">{{ $doctor->user->name }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $doctor->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ $doctor->department->name ?? 'غير محدد' }}</span>
                    </td>
                    <td>
                        <span class="badge badge-secondary" style="background: #f1f5f9; color: #475569;">{{ $doctor->specialization->name ?? 'غير محدد' }}</span>
                    </td>
                    <td style="font-family: monospace; font-weight: 600;">{{ $doctor->user->phone ?? '-' }}</td>
                    <td>
                        <div class="badge badge-warning" style="background: #fffbeb; color: #92400e;">{{ $doctor->experience_years }} سنة</div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--primary);"><i class="fa-solid fa-eye"></i></a>
                            <button class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--info);"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--danger);"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 4rem;">
                        <i class="fa-solid fa-user-doctor" style="font-size: 3.5rem; color: var(--border-color); margin-bottom: 1rem; display: block; opacity: .5;"></i>
                        <p style="color: var(--text-muted); font-weight: 600;">لم يتم العثور على أطباء مطابقين للبحث</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $doctors->links() }}
    </div>
</div>
@endsection
