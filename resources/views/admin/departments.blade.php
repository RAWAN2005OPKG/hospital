@extends('layouts.app')

@section('title', 'إدارة الأقسام والتخصصات')

@section('content')
<div class="container section">
    @if(session('success'))
        <div style="padding: 1rem; background: #dcfce7; color: #166534; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #bbf7d0;">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="mb-8" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">الأقسام والتخصصات</h1>
            <p style="color: var(--muted);">إدارة هيكل الأقسام الطبية وتخصصات الأطباء</p>
        </div>
        <div style="display: flex; gap: .75rem;">
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #ea580c, #f97316); box-shadow: 0 4px 16px rgba(234, 88, 12, 0.3);">
                <i class="fa-solid fa-plus"></i> قسم جديد
            </a>
            <a href="{{ route('admin.specializations.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #7c3aed, #a855f7); box-shadow: 0 4px 16px rgba(124, 58, 237, 0.3);">
                <i class="fa-solid fa-plus"></i> تخصص جديد
            </a>
        </div>
    </div>

    <div class="grid-2">
        <!-- Departments Column -->
        <div>
            <div class="card">
                <div class="card-header" style="background: #fff7ed; color: #9a3412;">
                    <span>الأقسام الطبية</span>
                    <span class="badge badge-yellow">{{ $departments->total() }}</span>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @forelse($departments as $dept)
                        <div style="padding: 1.25rem; border: 1px solid var(--border); border-radius: 12px; transition: all .3s;" onmouseover="this.style.borderColor='var(--blue)'; this.style.boxShadow='var(--shadow)';" onmouseout="this.style.borderColor='var(--border)'; this.style.boxShadow='none';">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .75rem;">
                                <div>
                                    <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: .25rem;">{{ $dept->name }}</h3>
                                    <p style="font-size: .85rem; color: var(--muted); line-height: 1.5;">{{ Str::limit($dept->description, 100) }}</p>
                                </div>
                                <div class="badge badge-cyan" style="white-space: nowrap;">{{ $dept->doctors_count }} طبيب</div>
                            </div>
                            <div style="display: flex; justify-content: flex-end; gap: .5rem; border-top: 1px solid var(--border); padding-top: .75rem; margin-top: .75rem;">
                                <a href="{{ route('admin.departments.edit', $dept->id) }}" class="btn btn-sm btn-outline"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none;"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <p style="text-align: center; color: var(--muted); padding: 2rem;">لا توجد أقسام مسجلة</p>
                        @endforelse
                    </div>
                    <div style="margin-top: 1rem;">{{ $departments->appends(['specs_page' => $specializations->currentPage()])->links() }}</div>
                </div>
            </div>
        </div>

        <!-- Specializations Column -->
        <div>
            <div class="card">
                <div class="card-header" style="background: #f5f3ff; color: #4c1d95;">
                    <span>تخصصات الأطباء</span>
                    <span class="badge badge-blue">{{ $specializations->total() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>التخصص</th>
                                    <th>الأطباء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($specializations as $spec)
                                <tr>
                                    <td style="font-weight: 700;">{{ $spec->name }}</td>
                                    <td>
                                        <div style="font-weight: 900; color: var(--blue);">{{ $spec->doctors_count }}</div>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: .5rem;">
                                            <a href="{{ route('admin.specializations.edit', $spec->id) }}" class="btn btn-sm btn-outline"><i class="fa-solid fa-pen"></i></a>
                                            <form action="{{ route('admin.specializations.destroy', $spec->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا التخصص؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none;"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" style="text-align: center; color: var(--muted);">لا توجد تخصصات مسجلة</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 1rem;">{{ $specializations->appends(['departments_page' => $departments->currentPage()])->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
