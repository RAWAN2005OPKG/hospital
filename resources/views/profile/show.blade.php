@extends('layouts.app')

@section('title', 'الملف الشخصي - صحتي')

@section('content')
<div class="section">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h1 style="font-size: 1.8rem; font-weight: 700;">الملف الشخصي</h1>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-edit"></i> تعديل
                    </a>
                </div>
                
                <!-- Avatar -->
                <div style="text-align: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--gray-200);">
                    <div style="width: 120px; height: 120px; border-radius: 12px; background: linear-gradient(135deg, var(--blue), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem; margin: 0 auto 1rem; overflow: hidden;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
                    <p style="color: var(--blue); font-weight: 600;">
                        @if($user->isPatient())
                            مريض
                        @elseif($user->isDoctor())
                            طبيب
                        @elseif($user->isAdmin())
                            مسؤول
                        @endif
                    </p>
                </div>
                
                <!-- User Info -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">الاسم</p>
                        <p style="font-weight: 600;">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">البريد الإلكتروني</p>
                        <p style="font-weight: 600; direction: ltr;">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">رقم الجوال</p>
                        <p style="font-weight: 600; direction: ltr;">{{ $user->phone }}</p>
                    </div>
                    <div>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">العنوان</p>
                        <p style="font-weight: 600;">{{ $user->address ?? 'لم يتم تحديده' }}</p>
                    </div>
                </div>
                
                <!-- Patient Info -->
                @if($user->isPatient() && $user->patient)
                    <div style="background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 188, 212, 0.05)); border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem;">
                        <h3 style="font-weight: 700; margin-bottom: 1rem;">معلومات صحية</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">فصيلة الدم</p>
                                <p style="font-weight: 600;">{{ $user->patient->blood_type ?? 'لم يتم تحديده' }}</p>
                            </div>
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">تاريخ الميلاد</p>
                                <p style="font-weight: 600;">{{ $user->patient->birth_date ? $user->patient->birth_date->format('d/m/Y') : 'لم يتم تحديده' }}</p>
                            </div>
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">الجنس</p>
                                <p style="font-weight: 600;">{{ $user->patient->gender === 'male' ? 'ذكر' : ($user->patient->gender === 'female' ? 'أنثى' : 'لم يتم تحديده') }}</p>
                            </div>
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">جهة الاتصال الطارئة</p>
                                <p style="font-weight: 600;">{{ $user->patient->emergency_contact ?? 'لم يتم تحديده' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Doctor Info -->
                @if($user->isDoctor() && $user->doctor)
                    <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(16, 185, 129, 0.05)); border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem;">
                        <h3 style="font-weight: 700; margin-bottom: 1rem;">معلومات مهنية</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">التخصص</p>
                                <p style="font-weight: 600;">{{ $user->doctor->specialization->name ?? 'لم يتم تحديده' }}</p>
                            </div>
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">القسم</p>
                                <p style="font-weight: 600;">{{ $user->doctor->department->name ?? 'لم يتم تحديده' }}</p>
                            </div>
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">رقم الترخيص</p>
                                <p style="font-weight: 600; direction: ltr;">{{ $user->doctor->license_number ?? 'لم يتم تحديده' }}</p>
                            </div>
                            <div>
                                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">سنوات الخبرة</p>
                                <p style="font-weight: 600;">{{ $user->doctor->experience_years ?? 0 }} سنة</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Actions -->
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="flex: 1; padding: 0.85rem; text-align: center;">
                        <i class="fa-solid fa-edit"></i> تعديل الملف الشخصي
                    </a>
                    <a href="#" class="btn btn-outline" style="flex: 1; padding: 0.85rem; text-align: center;">
                        <i class="fa-solid fa-lock"></i> تغيير كلمة المرور
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection