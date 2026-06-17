@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إدارة المستخدمين</h1>
        <p class="page-subtitle">عرض وإدارة كافة الحسابات المسجلة في النظام</p>
    </div>
    <div style="display:flex; gap: 1rem; align-items: center;">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> إضافة مستخدم جديد
        </a>
        <div class="card" style="padding: 0.5rem 1.25rem; display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 120px;">
            <span style="font-size: 1.5rem; font-weight: 800; color: var(--primary); line-height: 1;">{{ $users->total() }}</span>
            <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">إجمالي المستخدمين</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">قائمة المستخدمين</h3>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <form method="GET" action="{{ route('admin.users') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                <select name="per_page" class="form-control" onchange="this.form.submit()" style="width: 80px; padding: 0.5rem;">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30</option>
                </select>
            </form>
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                <input type="text" class="form-control" placeholder="بحث..." style="width: 250px; padding-right: 2.5rem;">
            </div>
        </div>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>رقم الهاتف</th>
                    <th>الدور الوظيفي</th>
                    <th>تاريخ الانضمام</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--text-main);">{{ $user->name }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-family: monospace; font-weight: 600; color: var(--text-main);">{{ $user->phone ?? '---' }}</span>
                    </td>
                    <td>
                        @php
                            $roleValue = is_object($user->role) ? $user->role->value : (string)$user->role;
                            $roleClasses = ['admin' => 'badge-danger', 'doctor' => 'badge-primary', 'patient' => 'badge-success'];
                            $roleNames = ['admin' => 'مدير نظام', 'doctor' => 'طبيب', 'patient' => 'مريض'];
                        @endphp
                        <span class="badge {{ $roleClasses[$roleValue] ?? 'badge-secondary' }}">
                            <i class="fa-solid {{ $roleValue == 'admin' ? 'fa-shield-halved' : ($roleValue == 'doctor' ? 'fa-user-md' : 'fa-user') }}"></i>
                            {{ $roleNames[$roleValue] ?? $roleValue }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-muted);">
                            <i class="fa-regular fa-calendar-alt" style="margin-left: 0.4rem;"></i>
                            {{ $user->created_at->format('Y-m-d') }}
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--info);">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--danger);">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem;">
                        <i class="fa-solid fa-users-slash" style="font-size: 3rem; color: var(--border-color); margin-bottom: 1rem; display: block;"></i>
                        <p style="color: var(--text-muted); font-weight: 600;">لا يوجد مستخدمين مسجلين حالياً</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $users->links() }}
    </div>
</div>
@endsection
