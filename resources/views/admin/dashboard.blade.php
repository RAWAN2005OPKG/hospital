@extends('layouts.app')

@section('title', 'لوحة الإدارة - صحتي')

@section('content')
<div style="background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05)); padding: 2rem 0;">
    <div class="container">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">لوحة التحكم</h1>
            <p style="color: var(--muted);">إدارة المستخدمين والأطباء والمواعيد</p>
        </div>
        
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي المستخدمين</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--blue);">{{ $totalUsers }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(0, 102, 204, 0.1), rgba(0, 188, 212, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--blue); font-size: 1.5rem;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <a href="{{ route('admin.users') }}" style="color: var(--blue); text-decoration: none; font-size: 0.9rem; font-weight: 600;">إدارة المستخدمين →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">الأطباء المسجلين</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--green);">{{ $totalDoctors }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--green); font-size: 1.5rem;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                </div>
                <a href="{{ route('admin.doctors') }}" style="color: var(--green); text-decoration: none; font-size: 0.9rem; font-weight: 600;">إدارة الأطباء →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي المواعيد</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--purple);">{{ $totalAppointments }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(139, 92, 246, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--purple); font-size: 1.5rem;">
                        <i class="fa-solid fa-calendar"></i>
                    </div>
                </div>
                <a href="{{ route('admin.appointments') }}" style="color: var(--purple); text-decoration: none; font-size: 0.9rem; font-weight: 600;">إدارة المواعيد →</a>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">مواعيد قيد الانتظار</p>
                        <h3 style="font-size: 2rem; font-weight: 900; color: var(--red);">{{ $pendingAppointments }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.1)); display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 1.5rem;">
                        <i class="fa-solid fa-hourglass-end"></i>
                    </div>
                </div>
                <a href="{{ route('admin.appointments') }}" style="color: var(--red); text-decoration: none; font-size: 0.9rem; font-weight: 600;">عرض المعلقة →</a>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">الإجراءات السريعة</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('admin.users') }}" class="btn btn-outline" style="padding: 1rem; text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-user-plus"></i> إضافة مستخدم
                </a>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-outline" style="padding: 1rem; text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-user-doctor"></i> إضافة طبيب
                </a>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline" style="padding: 1rem; text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-hospital"></i> إدارة الأقسام
                </a>
                <a href="{{ route('admin.settings') }}" class="btn btn-outline" style="padding: 1rem; text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-gear"></i> الإعدادات
                </a>
            </div>
        </div>
    </div>
</div>
@endsection