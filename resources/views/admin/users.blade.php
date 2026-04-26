@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="container section">
    <div class="mb-8" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">إدارة المستخدمين</h1>
            <p style="color: var(--muted);">عرض وإدارة كافة الحسابات المسجلة في النظام</p>
        </div>
        <div class="stat-card" style="padding: .75rem 1.5rem;">
            <div style="text-align: center;">
                <div class="stat-num" style="font-size: 1.5rem;">{{ $users->total() }}</div>
                <div class="stat-lbl">إجمالي المستخدمين</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span>قائمة المستخدمين</span>
            <div style="display: flex; gap: .5rem;">
                <input type="text" id="userSearch" class="form-control" placeholder="بحث باسم المستخدم أو البريد..." style="width: 300px; padding: .4rem 1rem; font-size: .85rem;">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="usersTable">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الدور (Role)</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td style="font-weight: 700;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @php
                                    $roleBadges = [
                                        'admin' => 'badge-red',
                                        'doctor' => 'badge-blue',
                                        'patient' => 'badge-green'
                                    ];
                                    $roleNames = [
                                        'admin' => 'مدير',
                                        'doctor' => 'طبيب',
                                        'patient' => 'مريض'
                                    ];
                                @endphp
                                <span class="badge {{ $roleBadges[$user->role] ?? 'badge-gray' }}">
                                    {{ $roleNames[$user->role] ?? $user->role }}
                                </span>
                            </td>
                            <td style="font-size: .85rem; color: var(--muted);">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div style="display: flex; gap: .5rem;">
                                    <button class="btn btn-sm btn-outline" title="تعديل"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none;" title="حذف"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 3rem; color: var(--muted);">
                                <i class="fa-solid fa-users-slash" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: .3;"></i>
                                لا يوجد مستخدمين مسجلين حالياً
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 1.5rem;">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('userSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection
