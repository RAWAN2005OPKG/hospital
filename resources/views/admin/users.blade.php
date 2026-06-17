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
            <i class="fa-solid fa-user-plus"></i>
            إضافة مستخدم
        </a>
    <div style="background: #fff; padding: 0.75rem 1.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center;">
        <div style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">{{ $users->total() }}</div>
        <div style="font-size: 0.8rem; color: var(--gray-500); font-weight: 600;">إجمالي المستخدمين</div>
    </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">قائمة المستخدمين</h3>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <form method="GET" action="{{ route('admin.users') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                <label for="per_page_users" style="font-size: 0.85rem; color: var(--gray-600); font-weight: 700;">عرض</label>
                <select id="per_page_users" name="per_page" class="form-control" onchange="this.form.submit()" style="width: 120px; padding: 0.5rem 0.75rem;">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30</option>
                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>الكل</option>
                </select>
            </form>
            <input type="text" class="form-control" placeholder="بحث باسم المستخدم..." style="width: 300px; padding: 0.5rem 1rem;">
        </div>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>رقم الهاتف</th>
                    <th>الدور</th>
                    <th>تاريخ التسجيل</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="font-weight: 800; color: var(--gray-900);">{{ $user->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">{{ $user->email }}</div>
                    </td>
                    <td style="font-family: monospace; font-weight: 600;">{{ $user->phone ?? '---' }}</td>
                    <td>
                        @php
                            $roleValue = is_object($user->role) ? $user->role->value : (string)$user->role;
                            $roleStyles = [
                                'admin' => 'background: rgba(239, 68, 68, 0.1); color: #ef4444;',
                                'doctor' => 'background: rgba(0, 102, 204, 0.1); color: #0066cc;',
                                'patient' => 'background: rgba(16, 185, 129, 0.1); color: #10b981;'
                            ];
                            $roleNames = ['admin' => 'مدير', 'doctor' => 'طبيب', 'patient' => 'مريض'];
                        @endphp
                        <span class="badge" style="{{ $roleStyles[$roleValue] ?? 'background: #f3f4f6; color: #6b7280;' }}">
                            {{ $roleNames[$roleValue] ?? $roleValue }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size: 0.9rem; font-weight: 600; color: var(--gray-600);">{{ $user->created_at->format('Y-m-d') }}</div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.75rem;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" style="color: var(--primary); font-size: 1.1rem;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 1.1rem;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center; padding: 3rem; color: var(--gray-400);">لا يوجد مستخدمين مسجلين</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">{{ $users->links() }}</div>
</div>
@endsection
