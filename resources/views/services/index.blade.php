@extends('layouts.app')
@section('title', __('messages.medical_services'))

@push('styles')
<style>
    :root {
        --primary: #0077B6;
        --primary-light: #e0f4ff;
        --secondary: #00B4D8;
        --gray-100: #f3f4f6;
        --gray-500: #6b7280;
        --white: #ffffff;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .services-hero {
        padding: 120px 0 60px;
        text-align: center;
        background: linear-gradient(180deg, rgba(224, 244, 255, 0.4) 0%, rgba(255, 255, 255, 0) 100%);
    }

    .sec-tag {
        display: inline-block;
        padding: 6px 16px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .services-hero h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .services-hero p {
        max-width: 600px;
        margin: 0 auto;
        color: var(--gray-500);
        font-size: 1.1rem;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2.5rem;
        padding: 40px 0 100px;
    }

    .service-card {
        background: var(--white);
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0, 0, 0, 0.03);
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .service-card:hover::before {
        opacity: 1;
    }

    .icon-box {
        width: 80px;
        height: 80px;
        border-radius: 22px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }

    .service-card:hover .icon-box {
        background: var(--primary);
        color: var(--white);
        transform: rotate(-5deg);
    }

    .service-card h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #111827;
    }

    .service-card p {
        color: var(--gray-500);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .card-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: auto;
    }

    .btn-service {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom {
        background: var(--primary);
        color: white;
    }

    .btn-primary-custom:hover {
        background: #005f91;
        color: white;
        transform: scale(1.05);
    }

    .btn-outline-custom {
        border: 2px solid var(--primary-light);
        color: var(--primary);
    }

    .btn-outline-custom:hover {
        background: var(--primary-light);
        color: var(--primary);
        transform: scale(1.05);
    }

    [dir="rtl"] .btn-service i {
        transform: rotate(180deg);
    }
</style>
@endpush

@section('content')
<div class="services-hero">
    <div class="container">
        <span class="sec-tag">{{ __('messages.services') }}</span>
        <h2>{{ __('messages.integrated_healthcare') }}</h2>
        <p>{{ __('messages.services_desc') }}</p>
    </div>
</div>

<div class="container">
    <div class="services-grid">
        @php
            $services = [
                [
                    'icon' => 'fa-truck-medical', 
                    'title' => __('messages.emergency'), 
                    'desc' => __('messages.emergency_desc'),
                    'link_doctors' => route('doctors.index'),
                    'link_patient' => route('patient.dashboard')
                ],
                [
                    'icon' => 'fa-flask-vial', 
                    'title' => __('messages.lab'), 
                    'desc' => __('messages.lab_desc'),
                    'link_doctors' => route('doctors.index'),
                    'link_patient' => route('patient.medical-records')
                ],
                [
                    'icon' => 'fa-x-ray', 
                    'title' => __('messages.radiology'), 
                    'desc' => __('messages.radiology_desc'),
                    'link_doctors' => route('doctors.index'),
                    'link_patient' => route('patient.medical-records')
                ],
                [
                    'icon' => 'fa-pills', 
                    'title' => __('messages.pharmacy'), 
                    'desc' => __('messages.pharmacy_desc'),
                    'link_doctors' => route('doctors.index'),
                    'link_patient' => route('patient.dashboard')
                ],
                [
                    'icon' => 'fa-user-doctor', 
                    'title' => __('messages.outpatient_clinics'), 
                    'desc' => __('messages.outpatient_clinics_desc'),
                    'link_doctors' => route('doctors.index'),
                    'link_patient' => route('appointments.book')
                ],
                [
                    'icon' => 'fa-bed-pulse', 
                    'title' => __('messages.intensive_care'), 
                    'desc' => __('messages.intensive_care_desc'),
                    'link_doctors' => route('doctors.index'),
                    'link_patient' => route('patient.dashboard')
                ]
            ];
        @endphp

        @foreach($services as $service)
        <div class="service-card">
            <div>
                <div class="icon-box">
                    <i class="fa-solid {{ $service['icon'] }}"></i>
                </div>
                <h3>{{ $service['title'] }}</h3>
                <p>{{ $service['desc'] }}</p>
            </div>
            
            <div class="card-actions">
                <a href="{{ $service['link_doctors'] }}" class="btn-service btn-primary-custom">
                    <i class="fa-solid fa-user-md"></i>
                    {{ __('messages.view_doctors') }}
                </a>
                <a href="{{ $service['link_patient'] }}" class="btn-service btn-outline-custom">
                    <i class="fa-solid fa-hospital-user"></i>
                    {{ __('messages.patient_portal') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
