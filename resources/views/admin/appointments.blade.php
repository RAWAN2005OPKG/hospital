@extends('layouts.app')

@section('title', 'إدارة المواعيد')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إدارة المواعيد</h1>
        <p class="page-subtitle">متابعة وتنظيم مواعيد المرضى مع الأطباء</p>
    </div>
</div>

<div class="grid-2" style="margin-bottom: 2rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
    <div class="card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 56px; height: 56px; border-radius: 16px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fa-solid fa-calendar-day"></i>
        </div>
        <div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--text-main); line-height: 1;">{{ $todayAppointments }}</div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-top: 0.25rem;">مواعيد اليوم</div>
        </div>
    </div>
    
    <div class="card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 56px; height: 56px; border-radius: 16px; background: #dcfce7; color: #15803d; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fa-solid fa-calendar-week"></i>
        </div>
        <div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--text-main); line-height: 1;">{{ $weekAppointments }}</div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-top: 0.25rem;">مواعيد الأسبوع</div>
        </div>
    </div>

    <div class="card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 56px; height: 56px; border-radius: 16px; background: #fee2e2; color: #b91c1c; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--text-main); line-height: 1;">{{ $pendingAppointments }}</div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-top: 0.25rem;">بانتظار التأكيد</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">جدول المواعيد</h3>
        <div style="display: flex; gap: 1rem;">
             <form method="GET" action="{{ route('admin.appointments') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                <select name="per_page" class="form-control" onchange="this.form.submit()" style="width: 80px; padding: 0.5rem;">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30</option>
                </select>
            </form>
            <input type="text" class="form-control" placeholder="بحث في المواعيد..." style="width: 250px;">
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
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $app)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--text-main);">{{ $app->patient->user->name ?? 'مريض غير معروف' }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $app->patient->user->phone ?? '' }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--primary);">د. {{ $app->doctor->user->name ?? '---' }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $app->doctor->specialization->name ?? 'تخصص عام' }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--text-main);">{{ $app->appointment_date }}</div>
                        <div style="font-size: 0.85rem; color: var(--info); font-weight: 600;">
                            <i class="fa-regular fa-clock"></i> {{ $app->appointment_time }}
                        </div>
                    </td>
                    <td>
                        @php
                            $statusClasses = [
                                'pending' => 'badge-warning',
                                'confirmed' => 'badge-primary',
                                'completed' => 'badge-success',
                                'cancelled' => 'badge-danger',
                            ];
                            $statusLabels = [
                                'pending' => 'قيد الانتظار',
                                'confirmed' => 'مؤكد',
                                'completed' => 'مكتمل',
                                'cancelled' => 'ملغي',
                            ];
                        @endphp
                        <span class="badge {{ $statusClasses[$app->status] ?? 'badge-secondary' }}">
                            {{ $statusLabels[$app->status] ?? $app->status }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="#" class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--primary);">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-light" style="padding: 0.5rem; border-radius: 8px; color: var(--danger);">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem;">
                        <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; color: var(--border-color); margin-bottom: 1rem; display: block;"></i>
                        <p style="color: var(--text-muted); font-weight: 600;">لا يوجد مواعيد مسجلة حالياً</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
