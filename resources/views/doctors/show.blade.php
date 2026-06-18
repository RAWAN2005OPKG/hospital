@extends('layouts.app')

@section('title', 'عرض الملف الشخصي')

@section('content')
<div style="padding-top: 120px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <!-- Header Section -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; box-shadow: 0 10px 15px rgba(59, 130, 246, 0.2);">
                    <i class="fas fa-id-card"></i>
                </div>
                <h1 style="font-size: 2rem; font-weight: 900; color: #111827; margin: 0;">الملف الشخصي</h1>
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
                        @if($doctor->user->avatar)
                            <img src="{{ asset('storage/' . $doctor->user->avatar) }}" alt="{{ $doctor->user->name }}" style="width: 100%; height: 100%; border-radius: 2rem; object-fit: cover; border: 4px solid #f0f9ff; box-shadow: 0 10px 15px rgba(0,0,0,0.1);">
                        @else
                            <div style="width: 100%; height: 100%; border-radius: 2rem; background: linear-gradient(135deg, #3b82f6, #60a5fa); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; box-shadow: 0 10px 15px rgba(59, 130, 246, 0.2);">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 0.5rem 0;">{{ $doctor->user->name }}</h2>
                    <div style="display:flex; flex-wrap:wrap; gap:0.75rem; justify-content:center; align-items:center;">
                        <span style="display: inline-block; padding: 0.4rem 1rem; background: #dbeafe; color: #1e40af; font-weight: bold; border-radius: 2rem; font-size: 0.85rem;">
                            <i class="fas fa-user-tag" style="margin-left: 0.25rem;"></i> {{ $doctor->user->role == 'patient' ? 'مريض' : 'طبيب' }}
                        </span>
                        <a href="{{ route('appointments.create', ['doctor' => $doctor->id]) }}" style="padding: 0.65rem 1rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; font-weight: bold; border-radius: 2rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 10px 15px rgba(37, 99, 235, 0.2);">
                            <i class="fas fa-calendar-check"></i>
                            <span>حجز موعد</span>
                        </a>
                    </div>
                    
                    <div style="margin-top: 2rem; text-align: right; display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="fas fa-envelope" style="width: 20px; color: #3b82f6;"></i>
                            <span style="font-size: 0.9rem; word-break: break-all;">{{ $doctor->user->email }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="fas fa-phone" style="width: 20px; color: #10b981;"></i>
                            <span style="font-size: 0.9rem;">{{ $doctor->user->phone ?? 'غير مسجل' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb;">
                    <h4 style="font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; font-size: 1.1rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 0.75rem;">إحصائيات سريعة</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="background: #f0f9ff; padding: 1rem; border-radius: 1rem; text-align: center;">
                            <p style="font-size: 1.5rem; font-weight: 800; color: #3b82f6; margin: 0;">{{ $doctor->appointments_count ?? 0 }}</p>
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">مواعيد</p>
                        </div>
                        <div style="background: #ecfdf5; padding: 1rem; border-radius: 1rem; text-align: center;">
                            <p style="font-size: 1.5rem; font-weight: 800; color: #10b981; margin: 0;">{{ $doctor->experience_years ?? 0 }}</p>
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">سنوات خبرة</p>
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
                        المعلومات المهنية
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div style="background: #f0fdf4; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #dcfce7;">
                            <p style="font-size: 0.85rem; color: #166534; font-weight: bold; margin: 0 0 0.25rem 0;">القسم</p>
                            <p style="font-size: 1.1rem; font-weight: 800; color: #15803d; margin: 0;">{{ $doctor->department->name ?? 'عام' }}</p>
                        </div>
                        <div style="background: #fefce8; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #fef08a;">
                            <p style="font-size: 0.85rem; color: #854d0e; font-weight: bold; margin: 0 0 0.25rem 0;">التخصص</p>
                            <p style="font-size: 1.1rem; font-weight: 800; color: #a16207; margin: 0;">{{ $doctor->specialization->name ?? 'عام' }}</p>
                        </div>
                        <div style="background: #f5f3ff; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #ddd6fe;">
                            <p style="font-size: 0.85rem; color: #5b21b6; font-weight: bold; margin: 0 0 0.25rem 0;">رقم الترخيص</p>
                            <p style="font-size: 1rem; font-weight: 800; color: #7c3aed; margin: 0;">{{ $doctor->license_number ?? 'غير مسجل' }}</p>
                        </div>
                        <div style="background: #fdf2f8; padding: 1.25rem; border-radius: 1.5rem; border: 1px solid #fce7f3;">
                            <p style="font-size: 0.85rem; color: #9d174d; font-weight: bold; margin: 0 0 0.25rem 0;">سنوات الخبرة</p>
                            <p style="font-size: 1rem; font-weight: 800; color: #be185d; margin: 0;">{{ $doctor->experience_years ?? 0 }} سنوات</p>
                        </div>
                    </div>
                </div>

                <!-- Bio Section -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1.3rem; font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-user-md" style="color: #3b82f6;"></i>
                        نبذة مهنية
                    </h3>
                    <div style="color: #4b5563; line-height: 1.8; font-size: 1rem;">
                        {{ $doctor->bio ?? 'لا توجد نبذة تعريفية مضافة لهذا الطبيب حالياً.' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
