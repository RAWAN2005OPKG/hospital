@extends('layouts.app')
@section('title', __('messages.our_departments'))
@php use Illuminate\Support\Facades\Storage; @endphp

@push('styles')
<style>
    :root {
        --primary: #0077B6;
        --primary-light: #e0f4ff;
        --secondary: #00B4D8;
        --success: #10b981;
        --danger: #ef4444;
        --gray-100: #f3f4f6;
        --gray-500: #6b7280;
        --white: #ffffff;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.12);
        --border: #e5e7eb;
    }

    .departments-hero {
        padding: 120px 0 80px;
        text-align: center;
        background: linear-gradient(180deg, rgba(224, 244, 255, 0.4) 0%, rgba(255, 255, 255, 0) 100%);
        position: relative;
        overflow: hidden;
    }

    .departments-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(0, 119, 182, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .departments-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(0, 180, 216, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .departments-hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-actions {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .btn-add-department {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.4rem;
        border-radius: 12px;
        font-weight: 800;
        text-decoration: none;
        color: #fff;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        box-shadow: 0 8px 20px rgba(0, 119, 182, 0.25);
        transition: all 0.3s ease;
    }

    .btn-add-department:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(0, 119, 182, 0.35);
    }

    .sec-tag {
        display: inline-block;
        padding: 8px 20px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        box-shadow: 0 4px 15px rgba(0, 119, 182, 0.1);
    }

    .departments-hero h2 {
        font-size: 3rem;
        font-weight: 900;
        color: #1f2937;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .departments-hero p {
        max-width: 700px;
        margin: 0 auto;
        color: var(--gray-500);
        font-size: 1.15rem;
        line-height: 1.8;
    }

    .departments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 3rem;
        padding: 60px 0 100px;
    }

    .department-card {
        background: var(--white);
        border-radius: 28px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .department-card:hover {
        transform: translateY(-16px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-light);
    }

    .department-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease;
        z-index: 10;
    }

    .department-card:hover::before {
        transform: scaleX(1);
    }

    .department-image {
        height: 220px;
        background: linear-gradient(135deg, var(--primary-light), rgba(0, 180, 216, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .department-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 119, 182, 0.05), rgba(0, 180, 216, 0.05));
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .department-card:hover .department-image::after {
        opacity: 1;
    }

    .department-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .department-card:hover .department-image img {
        transform: scale(1.1);
    }

    .department-image i {
        font-size: 4rem;
        color: var(--primary);
        opacity: 0.8;
        transition: all 0.5s ease;
    }

    .department-card:hover .department-image i {
        opacity: 1;
        transform: scale(1.2);
    }

    .department-content {
        padding: 2.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .department-name {
        font-size: 1.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: #111827;
        transition: color 0.3s ease;
    }

    .department-card:hover .department-name {
        color: var(--primary);
    }

    .department-description {
        font-size: 0.95rem;
        color: var(--gray-500);
        line-height: 1.7;
        margin-bottom: 2rem;
        flex: 1;
    }

    .department-stats {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }

    .stat-item {
        flex: 1;
        text-align: center;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--primary);
        display: block;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .department-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-department {
        flex: 1;
        padding: 14px 16px;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        border: 2px solid transparent;
    }

    .btn-primary-dept {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 15px rgba(0, 119, 182, 0.2);
    }

    .btn-primary-dept:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 119, 182, 0.3);
    }

    .btn-outline-dept {
        border: 2px solid var(--primary);
        color: var(--primary);
        background: transparent;
    }

    .btn-outline-dept:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .departments-hero h2 {
            font-size: 2rem;
        }

        .departments-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .department-stats {
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="departments-hero">
    <div class="container">
        <div class="departments-hero-content">
            <span class="sec-tag">{{ __('messages.departments') }}</span>
            <h2>{{ __('messages.our_departments') }}</h2>
            <p>{{ __('messages.departments_description') }}</p>
            <div class="hero-actions">
                <a href="{{ route('admin.departments.create') }}" class="btn-add-department">
                    <i class="fa-solid fa-plus"></i>
                    إضافة قسم
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @if($departments->count())
        <div class="departments-grid">
            @foreach($departments as $department)
            <div class="department-card">
                <div class="department-image">
                    @if($department->image)
                        <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}">
                    @else
                        <i class="fa-solid fa-hospital"></i>
                    @endif
                </div>

                <div class="department-content">
                    <h3 class="department-name">{{ $department->name }}</h3>
                    <p class="department-description">{{ Str::limit($department->description, 120) }}</p>

                    @if($department->doctors_count > 0 || $department->specializations_count > 0)
                    <div class="department-stats">
                        @if($department->doctors_count > 0)
                        <div class="stat-item">
                            <span class="stat-number">{{ $department->doctors_count }}</span>
                            <span class="stat-label">{{ __('messages.doctors') }}</span>
                        </div>
                        @endif
                        @if($department->specializations_count > 0)
                        <div class="stat-item">
                            <span class="stat-number">{{ $department->specializations_count }}</span>
                            <span class="stat-label">{{ __('messages.specializations') }}</span>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="department-actions">
                        <a href="{{ route('departments.show', $department->id) }}" class="btn-department btn-primary-dept">
                            <i class="fas fa-arrow-right"></i>
                            {{ __('messages.view_all') }}
                        </a>
                        <a href="{{ route('doctors.index') }}?department={{ $department->id }}" class="btn-department btn-outline-dept">
                            <i class="fas fa-user-md"></i>
                            {{ __('messages.view_doctors') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; color: var(--gray-500);">
            <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
            <p style="font-size: 1.1rem; font-weight: 600;">{{ __('messages.no_departments_available') }}</p>
            <a href="{{ route('admin.departments.create') }}" class="btn-add-department" style="margin-top: 1.25rem;">
                <i class="fa-solid fa-plus"></i>
                إضافة أول قسم
            </a>
        </div>
    @endif
</div>
@endsection
