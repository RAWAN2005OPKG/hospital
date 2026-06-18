@extends('layouts.app')
@section('title', __('messages.profile_show'))

@php
    $user = $user ?? Auth::user();
@endphp

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <!-- Header Section -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; box-shadow: 0 10px 15px rgba(59, 130, 246, 0.2);">
                    <i class="fas fa-id-card"></i>
                </div>
                <h1 style="font-size: 2rem; font-weight: 900; color: #111827; margin: 0;">{{ __('messages.nav_profile') }}</h1>
            </div>
            <a href="{{ route('profile.edit') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: bold; border-radius: 1rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 10px 15px rgba(16, 185, 129, 0.2); transition: all 0.3s ease;">
                <i class="fas fa-edit"></i>
                <span>تعديل البيانات</span>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            
            <!-- Sidebar: Avatar & Basic Info -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid #e5e7eb; text-align: center;">
                    <div style="width: 150px; height: 150px; margin: 0 auto 1.5rem; position: relative;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; border-radius: 2rem; object-fit: cover; border: 4px solid #f0f9ff; box-shadow: 0 10px 15px rgba(0,0,0,0.1);">
                        @else
                            <div style="width: 100%; height: 100%; border-radius: 2rem; background: linear-gradient(135deg, #3b82f6, #60a5fa); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; box-shadow: 0 10px 15px rgba(59, 130, 246, 0.2);">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 0.5rem 0;">{{ $user->name }}</h2>
                    <span style="display: inline-block; padding: 0.4rem 1rem; background: #dbeafe; color: #1e40af; font-weight: bold; border-radius: 2rem; font-size: 0.85rem;">
                        <i class="fas fa-user-tag" style="margin-left: 0.25rem;"></i> {{ $user->isPatient() ? 'مريض' : 'طبيب' }}
                    </span>
                    
                    <div style="margin-top: 2rem; text-align: right; display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="fas fa-envelope" style="width: 20px; color: #3b82f6;"></i>
                            <span style="font-size: 0.9rem; word-break: break-all;">{{ $user->email }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="fas fa-phone" style="width: 20px; color: #10b981;"></i>
                            <span style="font-size: 0.9rem;">{{ $user->phone ?? 'غير مسجل' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="fas fa-map-marker-alt" style="width: 20px; color: #ef4444;"></i>
                            <span style="font-size: 0.9rem;">{{ $user->address ?? 'غير مسجل' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb;">
                    <h4 style="font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; font-size: 1.1rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 0.75rem;">إحصائيات سريعة</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="background: #f0f9ff; padding: 1rem; border-radius: 1rem; text-align: center;">
                            <p style="font-size: 1.5rem; font-weight: 800; color: #3b82f6; margin: 0;">{{ $user->patient->appointments_count ?? 0 }}</p>
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">مواعيد</p>
                        </div>
                        <div style="background: #ecfdf5; padding: 1rem; border-radius: 1rem; text-align: center;">
                            <p style="font-size: 1.5rem; font-weight: 800; color: #10b981; margin: 0;">{{ $user->patient->prescriptions_count ?? 0 }}</p>
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">وصفات</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Details -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Medical Info Card -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1.3rem; font-weight: bold; color: #111827; margin: 0 0 2rem 0; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-heartbeat" style="color: #ef4444;"></i>
                        المعلومات الطبية
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        @if($user->isPatient())
                        <div style="background: #fff5f5; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #fee2e2;">
                            <p style="font-size: 0.85rem; color: #991b1b; font-weight: bold; margin: 0 0 0.25rem 0;">فصيلة الدم</p>
                            <p style="font-size: 1.5rem; font-weight: 900; color: #dc2626; margin: 0;">{{ $user->patient->blood_type ?? 'غير محدد' }}</p>
                        </div>
                        @endif
                        @if($user->isPatient())
                        <div style="background: #f0fdf4; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #dcfce7;">
                            <p style="font-size: 0.85rem; color: #166534; font-weight: bold; margin: 0 0 0.25rem 0;">تاريخ الميلاد</p>
                            <p style="font-size: 1.1rem; font-weight: 800; color: #15803d; margin: 0;">{{ $user->patient->birth_date ? \Carbon\Carbon::parse($user->patient->birth_date)->format('Y/m/d') : 'غير مسجل' }}</p>
                        </div>
                        <div style="background: #fefce8; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #fef08a;">
                            <p style="font-size: 0.85rem; color: #854d0e; font-weight: bold; margin: 0 0 0.25rem 0;">الجنس</p>
                            <p style="font-size: 1.1rem; font-weight: 800; color: #a16207; margin: 0;">{{ $user->patient->gender === 'male' ? 'ذكر' : ($user->patient->gender === 'female' ? 'أنثى' : 'غير محدد') }}</p>
                        </div>
                        @else
                        <div style="background: #f0fdf4; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #dcfce7;">
                            <p style="font-size: 0.85rem; color: #166534; font-weight: bold; margin: 0 0 0.25rem 0;">القسم</p>
                            <p style="font-size: 1.1rem; font-weight: 800; color: #15803d; margin: 0;">{{ $user->doctor->department->name ?? 'عام' }}</p>
                        </div>
                        <div style="background: #fefce8; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #fef08a;">
                            <p style="font-size: 0.85rem; color: #854d0e; font-weight: bold; margin: 0 0 0.25rem 0;">التخصص</p>
                            <p style="font-size: 1.1rem; font-weight: 800; color: #a16207; margin: 0;">{{ $user->doctor->specialization->name ?? 'عام' }}</p>
                        </div>
                        @endif
                        @if($user->isPatient())
                        <div style="background: #f5f3ff; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #ddd6fe;">
                            <p style="font-size: 0.85rem; color: #5b21b6; font-weight: bold; margin: 0 0 0.25rem 0;">جهة الطوارئ</p>
                            <p style="font-size: 1rem; font-weight: 800; color: #7c3aed; margin: 0;">{{ $user->patient->emergency_contact ?? 'غير مسجل' }}</p>
                        </div>
                        @else
                        <div style="background: #f5f3ff; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #ddd6fe;">
                            <p style="font-size: 0.85rem; color: #5b21b6; font-weight: bold; margin: 0 0 0.25rem 0;">سنوات الخبرة</p>
                            <p style="font-size: 1rem; font-weight: 800; color: #7c3aed; margin: 0;">{{ $user->doctor->experience_years ?? 0 }} سنوات</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.3rem; font-weight: bold; color: #111827; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-history" style="color: #6366f1;"></i>
                            {{ __('messages.recent_medical_records') }}
                        </h3>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @if($user->patient && $user->patient->medicalRecords)
                            @forelse($user->patient->medicalRecords()->latest()->take(3)->get() as $record)
                                <div style="padding: 1.25rem; background: #f9fafb; border-radius: 1.25rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f3f4f6;">
                                    <div style="display: flex; gap: 1rem; align-items: center;">
                                        <div style="width: 45px; height: 45px; background: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #6366f1; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                        <div>
                                            <p style="font-weight: bold; color: #111827; margin: 0;">{{ $record->diagnosis }}</p>
                                            <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">{{ $record->created_at->format('Y/m/d') }}</p>
                                        </div>
                                    </div>
                                    <span style="font-size: 0.85rem; color: #4b5563; font-weight: 600; background: white; padding: 0.4rem 0.8rem; border-radius: 0.75rem; border: 1px solid #e5e7eb;">
                                        {{ $record->doctor->user->name ?? 'طبيب المختص' }}
                                    </span>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 3rem; color: #9ca3af; background: #f9fafb; border-radius: 1.5rem; border: 2px dashed #e5e7eb;">
                                    <i class="fas fa-folder-open" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                    <p style="margin: 0; font-weight: 600;">لا توجد سجلات طبية حتى الآن</p>
                                </div>
                            @endforelse
                        @else
                            <div style="text-align: center; padding: 3rem; color: #9ca3af; background: #f9fafb; border-radius: 1.5rem; border: 2px dashed #e5e7eb;">
                                <i class="fas fa-folder-open" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                <p style="margin: 0; font-weight: 600;">لا توجد سجلات طبية حتى الآن</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
