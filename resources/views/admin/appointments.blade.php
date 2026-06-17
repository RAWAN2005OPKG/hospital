@extends('layouts.app')

@section('title', 'إدارة المواعيد')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إدارة المواعيد</h1>
        <p class="page-subtitle">مراقبة وإدارة كافة مواعيد المرضى في النظام</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <div class="card" style="border-right: 4px solid var(--primary);">
        <p style="color: var(--gray-500); font-weight: 700; font-size: 0.85rem;">مواعيد اليوم</p>
        <h3 style="font-size: 1.8rem; font-weight: 900; margin-top: 0.5rem;">{{ $todayAppointments }}</h3>
    </div>
    <div class="card" style="border-right: 4px solid var(--success);">
        <p style="color: var(--gray-500); font-weight: 700; font-size: 0.85rem;">هذا الأسبوع</p>
        <h3 style="font-size: 1.8rem; font-weight: 900; margin-top: 0.5rem;">{{ $weekAppointments }}</h3>
    </div>
    <div class="card" style="border-right: 4px solid var(--warning);">
        <p style="color: var(--gray-500); font-weight: 700; font-size: 0.85rem;">قيد الانتظار</p>
        <h3 style="font-size: 1.8rem; font-weight: 900; margin-top: 0.5rem;">{{ $pendingAppointments }}</h3>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">سجل المواعيد</h3>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <form method="GET" action="{{ route('admin.appointments') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                <label for="per_page_appointments" style="font-size: 0.85rem; color: var(--gray-600); font-weight: 700;">عرض</label>
                <select id="per_page_appointments" name="per_page" class="form-control" onchange="this.form.submit()" style="width: 100px; padding: 0.4rem 0.75rem;">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30</option>
                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>الكل</option>
                </select>
            </form>
        </div>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>المريض</th>
                    <th>الطبيب</th>
                    <th>التاريخ والوقت</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $app)
                <tr>
                    <td>
                        <div style="font-weight: 800; color: var(--gray-900);">{{ $app->patient->user->name ?? 'مريض غير معروف' }}</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">{{ $app->patient->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0, 102, 204, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <span style="font-weight: 700;">{{ $app->doctor->user->name ?? '---' }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 700;">{{ $app->appointment_date }}</div>
                        <div style="font-size: 0.8rem; color: var(--primary); font-weight: 600;">{{ $app->appointment_time }}</div>
                    </td>
                    <td>
                        @php
                            $statusStyles = [
                                'pending' => 'background: rgba(245, 158, 11, 0.1); color: #f59e0b;',
                                'confirmed' => 'background: rgba(0, 102, 204, 0.1); color: #0066cc;',
                                'completed' => 'background: rgba(16, 185, 129, 0.1); color: #10b981;',
                                'cancelled' => 'background: rgba(239, 68, 68, 0.1); color: #ef4444;'
                            ];
                            $statusLabels = ['pending' => 'انتظار', 'confirmed' => 'مؤكد', 'completed' => 'مكتمل', 'cancelled' => 'ملغي'];
                        @endphp
                        <span class="badge" style="{{ $statusStyles[$app->status] ?? 'background: #f3f4f6; color: #6b7280;' }}">
                            {{ $statusLabels[$app->status] ?? $app->status }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            {{-- Assuming a route for details might exist or be the same as doctor's --}}
                            <a href="{{ route('doctor.appointment-detail', $app->id) }}" class="btn btn-white btn-sm" title="عرض التفاصيل">
                                <i class="fa-solid fa-eye" style="color: var(--primary);"></i>
                            </a>
                            <form action="#" method="POST" onsubmit="return confirm('حذف الموعد؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-white btn-sm" title="حذف">
                                    <i class="fa-solid fa-trash" style="color: var(--danger);"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center; padding: 3rem; color: var(--gray-400);">لا توجد مواعيد مسجلة</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">{{ $appointments->links() }}</div>
</div>
@endsection
