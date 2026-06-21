@extends('layouts.app')
@section('title', __('messages.medical_services'))

@push('styles')
<style>
    :root { --primary: #0077B6; --primary-light: #e0f4ff; --secondary: #00B4D8; --gray-500: #6b7280; --shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .services-hero { padding: 2rem 0 3rem; text-align: center; background: linear-gradient(180deg, rgba(224,244,255,0.4) 0%, transparent 100%); }
    .sec-tag { display: inline-block; padding: 6px 16px; background: var(--primary-light); color: var(--primary); border-radius: 50px; font-weight: 600; font-size: 0.9rem; margin-bottom: 1rem; }
    .services-hero h2 { font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem; }
    .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; padding: 2rem 0 4rem; }
    .service-card { background: #fff; border-radius: 24px; padding: 2rem 1.5rem; text-align: center; border: 1px solid rgba(0,0,0,0.03); box-shadow: var(--shadow); display: flex; flex-direction: column; }
    .icon-box { width: 70px; height: 70px; border-radius: 20px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem; }
    .service-card h3 { font-size: 1.35rem; font-weight: 700; margin-bottom: 0.75rem; }
    .manager-info { background: #f9fafb; border-radius: 12px; padding: 0.85rem; margin: 1rem 0; text-align: right; font-size: 0.9rem; border: 1px solid #e5e7eb; }
    .patient-appt { background: #eff6ff; border-radius: 12px; padding: 0.85rem; margin: 0.75rem 0; text-align: right; font-size: 0.88rem; border: 1px solid #bfdbfe; }
    .card-actions { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; margin-top: auto; padding-top: 1rem; }
    .btn-service { padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; }
    .btn-primary-custom { background: var(--primary); color: #fff; }
    .btn-outline-custom { border: 2px solid var(--primary-light); color: var(--primary); }
    .btn-admin-link { background: #f3f4f6; color: #374151; font-size: 0.8rem; }
</style>
@endpush

@section('content')
<div class="services-hero">
    <div class="container">
        <span class="sec-tag">{{ __('messages.services') }}</span>
        <h2>{{ __('messages.integrated_healthcare') }}</h2>
        <p style="max-width:600px;margin:0 auto;color:var(--gray-500);">{{ __('messages.services_desc') }}</p>
    </div>
</div>

<div class="container">
    <div class="services-grid">
        @php
            $adminPath = env('ADMIN_PATH', 'my-secret-admin-area');
            $services = [
                ['key' => 'consultations', 'id' => 'consultations', 'icon' => 'fa-comments', 'title' => __('messages.footer_medical_consultations'), 'desc' => 'استشارات طبية عن بعد مع نخبة الأطباء', 'route' => route('consultations.index'), 'link_patient' => auth()->check() && auth()->user()->isPatient() ? route('patient.consultations') : route('consultations.index')],
                ['key' => 'lab', 'id' => 'lab', 'icon' => 'fa-flask-vial', 'title' => __('messages.footer_tests'), 'desc' => __('messages.lab_desc'), 'route' => route('services.lab'), 'link_patient' => route('patient.medical-records')],
                ['key' => 'surgeries', 'id' => 'surgeries', 'icon' => 'fa-user-doctor', 'title' => __('messages.footer_surgeries'), 'desc' => 'عمليات جراحية بأحدث التقنيات', 'route' => route('doctors.index'), 'link_patient' => route('appointments.create')],
                ['key' => 'emergency', 'id' => null, 'icon' => 'fa-truck-medical', 'title' => __('messages.emergency'), 'desc' => __('messages.emergency_desc'), 'route' => route('services.emergency'), 'link_patient' => route('appointments.create')],
                ['key' => 'radiology', 'id' => null, 'icon' => 'fa-x-ray', 'title' => __('messages.radiology'), 'desc' => __('messages.radiology_desc'), 'route' => route('services.radiology'), 'link_patient' => route('patient.medical-records')],
                ['key' => 'pharmacy', 'id' => null, 'icon' => 'fa-pills', 'title' => __('messages.pharmacy'), 'desc' => __('messages.pharmacy_desc'), 'route' => route('services.pharmacy'), 'link_patient' => route('patient.prescriptions_list')],
                ['key' => 'outpatient', 'id' => null, 'icon' => 'fa-user-doctor', 'title' => __('messages.outpatient_clinics'), 'desc' => __('messages.outpatient_clinics_desc'), 'route' => route('doctors.index'), 'link_patient' => route('appointments.create')],
                ['key' => 'icu', 'id' => null, 'icon' => 'fa-bed-pulse', 'title' => __('messages.intensive_care'), 'desc' => __('messages.intensive_care_desc'), 'route' => route('doctors.index'), 'link_patient' => route('patient.dashboard')],
            ];
        @endphp

        @foreach($services as $service)
        @php $dept = $managers[$service['key']] ?? null; @endphp
        <div class="service-card" @if($service['id']) id="{{ $service['id'] }}" @endif>
            <div class="icon-box"><i class="fa-solid {{ $service['icon'] }}"></i></div>
            <h3>{{ $service['title'] }}</h3>
            <p style="color:var(--gray-500);font-size:0.95rem;line-height:1.6;">{{ $service['desc'] }}</p>

            @if($dept && ($dept->manager_name || $dept->phone))
            <div class="manager-info">
                <div><i class="fas fa-user-tie text-primary"></i> <strong>المسؤول:</strong> {{ $dept->manager_name ?? 'غير محدد' }}</div>
                @if($dept->phone)<div class="mt-1"><i class="fas fa-phone text-primary"></i> {{ $dept->phone }}</div>@endif
            </div>
            @endif

            @auth
                @if(auth()->user()->isPatient() && isset($patientAppointments) && $patientAppointments->count())
                    @php
                        $relatedAppt = $patientAppointments->first(function($a) use ($dept) {
                            if (!$dept) return false;
                            return $a->doctor && $a->doctor->department_id === $dept->id;
                        }) ?? $patientAppointments->first();
                    @endphp
                    @if($relatedAppt)
                    <div class="patient-appt">
                        <div><i class="fas fa-calendar"></i> <strong>موعدك:</strong> {{ \Carbon\Carbon::parse($relatedAppt->appointment_date)->format('d/m/Y') }} - {{ $relatedAppt->appointment_time }}</div>
                        <div class="mt-1"><i class="fas fa-user-md"></i> <strong>الطبيب:</strong> د. {{ $relatedAppt->doctor->user->name ?? 'غير محدد' }}</div>
                    </div>
                    @endif
                @endif
            @endauth

            <div class="card-actions">
                <a href="{{ $service['route'] }}" class="btn-service btn-primary-custom"><i class="fa-solid fa-info-circle"></i> التفاصيل</a>
                <a href="{{ route('doctors.index') }}" class="btn-service btn-outline-custom"><i class="fa-solid fa-user-md"></i> {{ __('messages.view_doctors') }}</a>
                @auth
                    @if(auth()->user()->isPatient())
                    <a href="{{ $service['link_patient'] }}" class="btn-service btn-outline-custom"><i class="fa-solid fa-hospital-user"></i> بوابتي</a>
                    @endif
                    @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
                    <a href="/{{ $adminPath }}/departments" class="btn-service btn-admin-link"><i class="fas fa-cog"></i> إدارة المسؤول</a>
                    @endif
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
