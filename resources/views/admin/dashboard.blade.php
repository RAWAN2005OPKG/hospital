@extends('layouts.app')

@section('title', 'لوحة تحكم المدير')

@section('content')
<div class="container section">
    <div class="mb-8">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text);">لوحة التحكم الرئيسية</h1>
        <p style="color: var(--muted);">نظرة عامة على أداء المستشفى والنشاط الحالي</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid-4 mb-8">
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="fa-solid fa-user-doctor"></i></div>
            <div>
                <div class="stat-num">{{ $totalDoctors }}</div>
                <div class="stat-lbl">إجمالي الأطباء</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-cyan"><i class="fa-solid fa-calendar-check"></i></div>
            <div>
                <div class="stat-num">{{ $totalAppointments }}</div>
                <div class="stat-lbl">إجمالي المواعيد</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-green"><i class="fa-solid fa-building-user"></i></div>
            <div>
                <div class="stat-num">{{ $totalDepartments }}</div>
                <div class="stat-lbl">الأقسام</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-purple"><i class="fa-solid fa-users"></i></div>
            <div>
                <div class="stat-num">{{ $totalUsers }}</div>
                <div class="stat-lbl">المستخدمين</div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <!-- Recent Appointments -->
        <div class="card">
            <div class="card-header">
                <span>آخر المواعيد المحجوزة</span>
                <a href="{{ route('admin.appointments') }}" class="btn btn-sm btn-outline">الكل</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>المريض</th>
                                <th>الطبيب</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $app)
                            <tr>
                                <td style="font-weight: 700;">{{ $app->patient->name }}</td>
                                <td>{{ $app->doctor->user->name }}</td>
                                <td style="font-size: .8rem;">{{ $app->appointment_date }}</td>
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
                            </tr>
                            @empty
                            <tr><td colspan="4" style="text-align: center; color: var(--muted);">لا توجد مواعيد حالياً</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Appointment Status Stats -->
        <div class="card">
            <div class="card-header">توزيع المواعيد حسب الحالة</div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($appointmentStats as $status => $count)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: .75rem; background: var(--bg); border-radius: 10px;">
                        <div style="display: flex; align-items: center; gap: .75rem;">
                             @php
                                $statusIcons = [
                                    'pending' => 'fa-clock text-warning',
                                    'confirmed' => 'fa-circle-check text-primary',
                                    'completed' => 'fa-circle-check text-success',
                                    'cancelled' => 'fa-circle-xmark text-danger'
                                ];
                                $statusNames = [
                                    'pending' => 'قيد الانتظار',
                                    'confirmed' => 'مؤكدة',
                                    'completed' => 'مكتملة',
                                    'cancelled' => 'ملغاة'
                                ];
                            @endphp
                            <i class="fa-solid {{ $statusIcons[$status] ?? 'fa-circle' }}" style="font-size: 1.2rem;"></i>
                            <span style="font-weight: 700;">{{ $statusNames[$status] ?? $status }}</span>
                        </div>
                        <span style="font-size: 1.2rem; font-weight: 900;">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem;">إجراءات سريعة</h3>
        <div class="grid-4">
            <a href="{{ route('admin.doctors') }}" class="card-body card" style="text-align: center; transition: all .3s;">
                <i class="fa-solid fa-user-doctor" style="font-size: 2rem; color: var(--blue); margin-bottom: 1rem;"></i>
                <div style="font-weight: 700;">إدارة الأطباء</div>
            </a>
            <a href="{{ route('admin.departments') }}" class="card-body card" style="text-align: center; transition: all .3s;">
                <i class="fa-solid fa-hospital" style="font-size: 2rem; color: var(--cyan); margin-bottom: 1rem;"></i>
                <div style="font-weight: 700;">إدارة الأقسام</div>
            </a>
            <a href="{{ route('admin.users') }}" class="card-body card" style="text-align: center; transition: all .3s;">
                <i class="fa-solid fa-users-gear" style="font-size: 2rem; color: var(--purple); margin-bottom: 1rem;"></i>
                <div style="font-weight: 700;">إدارة المستخدمين</div>
            </a>
            <a href="{{ route('home') }}" class="card-body card" style="text-align: center; transition: all .3s;">
                <i class="fa-solid fa-house" style="font-size: 2rem; color: var(--muted); margin-bottom: 1rem;"></i>
                <div style="font-weight: 700;">الموقع الرئيسي</div>
            </a>
        </div>
    </div>
</div>
@endsection