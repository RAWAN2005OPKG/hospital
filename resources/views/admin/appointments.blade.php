@extends('layouts.app')

@section('title', 'إدارة المواعيد')

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">إدارة المواعيد</h1>
        <p style="color: var(--muted);">مراقبة وإدارة كافة مواعيد المرضى المسجلة</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid-4 mb-8">
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="fa-solid fa-calendar-day"></i></div>
            <div>
                <div class="stat-num">{{ $todayAppointments }}</div>
                <div class="stat-lbl">مواعيد اليوم</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-cyan"><i class="fa-solid fa-calendar-week"></i></div>
            <div>
                <div class="stat-num">{{ $weekAppointments }}</div>
                <div class="stat-lbl">هذا الأسبوع</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-green"><i class="fa-solid fa-calendar-check"></i></div>
            <div>
                <div class="stat-num">{{ $monthAppointments }}</div>
                <div class="stat-lbl">هذا الشهر</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-orange" style="background: #fff7ed; color: #ea580c;"><i class="fa-solid fa-hourglass-half"></i></div>
            <div>
                <div class="stat-num">{{ $pendingAppointments }}</div>
                <div class="stat-lbl">قيد الانتظار</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span>سجل المواعيد</span>
            <div style="display: flex; gap: .5rem;">
                 <input type="text" id="appSearch" class="form-control" placeholder="بحث باسم المريض أو الطبيب..." style="width: 300px; padding: .4rem 1rem; font-size: .85rem;">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="appsTable">
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
                            <td style="font-weight: 700;">{{ $app->patient->name }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: .5rem;">
                                    <i class="fa-solid fa-user-doctor" style="color: var(--blue); font-size: .8rem;"></i>
                                    <span>{{ $app->doctor->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700;">{{ $app->appointment_date }}</div>
                                <div style="font-size: .8rem; color: var(--muted);">{{ $app->appointment_time }}</div>
                            </td>
                            <td>
                                @php
                                    $badges = [
                                        'pending' => 'badge-yellow',
                                        'confirmed' => 'badge-blue',
                                        'completed' => 'badge-green',
                                        'cancelled' => 'badge-red'
                                    ];
                                    $labels = [
                                        'pending' => 'انتظار',
                                        'confirmed' => 'مؤكد',
                                        'completed' => 'مكتمل',
                                        'cancelled' => 'ملغي'
                                    ];
                                @endphp
                                <span class="badge {{ $badges[$app->status] ?? 'badge-gray' }}">
                                    {{ $labels[$app->status] ?? $app->status }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: .5rem;">
                                    <button class="btn btn-sm btn-outline" title="عرض التفاصيل"><i class="fa-solid fa-eye"></i></button>
                                    @if($app->status === 'pending')
                                        <button class="btn btn-sm btn-success" title="تأكيد"><i class="fa-solid fa-check"></i></button>
                                    @endif
                                    <button class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none;" title="إلغاء"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 4rem; color: var(--muted);">
                                <i class="fa-solid fa-calendar-xmark" style="font-size: 3.5rem; margin-bottom: 1rem; display: block; opacity: .2;"></i>
                                لا توجد مواعيد مسجلة حالياً
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 1.5rem;">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('appSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#appsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection
