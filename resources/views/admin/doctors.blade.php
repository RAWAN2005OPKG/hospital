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

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

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
                    <th>رقم الترخيص</th>
                    <th>سنوات الخبرة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: .75rem;">
                            <div style="width: 45px; height: 45px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 900; overflow: hidden;">
                                @if($doctor->user->avatar)
                                    <img src="{{ asset('storage/' . $doctor->user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{ mb_substr($doctor->user->name, 0, 1) }}
                                @endif
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
                    <td style="font-family: monospace; font-weight: 600;">{{ $doctor->license_number }}</td>
                    <td>
                        <div style="font-weight: 700;">{{ $doctor->experience_years }} سنة</div>
                    </td>
                    <td>
                        <div style="display: flex; gap: .5rem;">
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-white btn-sm" title="عرض">
                                <i class="fa-solid fa-eye" style="color: var(--primary);"></i>
                            </a>
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-white btn-sm" title="تعديل">
                                <i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i>
                            </a>
                            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟ سيتم حذف سجل الطبيب فقط وسيبقى حساب المستخدم.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-white btn-sm" title="حذف">
                                    <i class="fa-solid fa-trash" style="color: var(--danger);"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 4rem; color: var(--muted);">
                        <i class="fa-solid fa-user-doctor" style="font-size: 3.5rem; margin-bottom: 1rem; display: block; opacity: .2;"></i>
                        لم يتم العثور على أطباء مسجلين
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
