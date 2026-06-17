@extends('layouts.dashboard')

@section('title', 'لوحة الإدارة - صحتي')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">لوحة التحكم</h1>
        <p class="page-subtitle">إدارة المستخدمين والأطباء والمواعيد</p>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي المستخدمين</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--primary);">{{ $totalUsers }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(0, 102, 204, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem;">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <a href="{{ route('admin.users') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">إدارة المستخدمين →</a>
    </div>
    
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">الأطباء المسجلين</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--success);">{{ $totalDoctors }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: var(--success); font-size: 1.5rem;">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>
        <a href="{{ route('admin.doctors') }}" style="color: var(--success); text-decoration: none; font-size: 0.9rem; font-weight: 600;">إدارة الأطباء →</a>
    </div>
    
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي المواعيد</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--purple);">{{ $totalAppointments }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; color: var(--purple); font-size: 1.5rem;">
                <i class="fa-solid fa-calendar"></i>
            </div>
        </div>
        <a href="{{ route('admin.appointments') }}" style="color: var(--purple); text-decoration: none; font-size: 0.9rem; font-weight: 600;">إدارة المواعيد →</a>
    </div>
    
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">مواعيد قيد الانتظار</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--red);">{{ $pendingAppointments }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 1.5rem;">
                <i class="fa-solid fa-hourglass-end"></i>
            </div>
        </div>
        <a href="{{ route('admin.appointments') }}" style="color: var(--red); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض المعلقة →</a>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">الإجراءات السريعة</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.users') }}" class="btn btn-primary" style="padding: 1rem; text-align: center; text-decoration: none;">
            <i class="fa-solid fa-user-plus"></i> إضافة مستخدم
        </a>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary" style="padding: 1rem; text-align: center; text-decoration: none;">
            <i class="fa-solid fa-user-doctor"></i> إضافة طبيب
        </a>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-primary" style="padding: 1rem; text-align: center; text-decoration: none;">
            <i class="fa-solid fa-hospital"></i> إدارة الأقسام
        </a>
        <a href="{{ route('admin.settings') }}" class="btn btn-primary" style="padding: 1rem; text-align: center; text-decoration: none;">
            <i class="fa-solid fa-gear"></i> الإعدادات
        </a>
    </div>
</div>
@endsection
