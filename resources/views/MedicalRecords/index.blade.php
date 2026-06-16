@extends('layouts.app')
@section('title', __('messages.our_medical_team'))

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
        --border: #e5e7eb;
    }

    .doctors-hero {
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

    .doctors-hero h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .doctors-hero p {
        max-width: 600px;
        margin: 0 auto;
        color: var(--gray-500);
        font-size: 1.1rem;
    }

    .filters-section {
        display: flex;
        gap: 1rem;
        margin: 2rem 0;
        flex-wrap: wrap;
        justify-content: center;
    }

    .filter-btn {
        padding: 10px 20px;
        border-radius: 50px;
        border: 2px solid var(--border);
        background: var(--white);
        color: var(--gray-500);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .doctors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2.5rem;
        padding: 40px 0 100px;
    }

    .doctor-card {
        background: var(--white);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .doctor-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .doctor-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-light);
    }

    .doctor-card:hover::before {
        opacity: 1;
    }

    .doctor-image {
        height: 240px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
        position: relative;
        overflow: hidden;
    }

    .doctor-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doctor-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.2) 100%);
    }

    .doctor-content {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .doctor-name {
        font-size: 1.3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #111827;
    }

    .doctor-specialty {
        color: var(--primary);
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .doctor-department {
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .doctor-experience {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .doctor-experience i {
        color: var(--secondary);
    }

    .doctor-rating {
        display: flex;
        gap: 0.25rem;
        margin-bottom: 1.5rem;
        color: #fbbf24;
    }

    .doctor-actions {
        display: flex;
        gap: 1rem;
        margin-top: auto;
    }

    .btn-doctor {
        flex: 1;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .btn-primary-doctor {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-primary-doctor:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 119, 182, 0.3);
    }

    .btn-outline-doctor {
        border: 2px solid var(--primary-light);
        color: var(--primary);
        background: transparent;
    }

    .btn-outline-doctor:hover {
        background: var(--primary-light);
        color: var(--primary);
        transform: translateY(-2px);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid var(--border);
        text-decoration: none;
        color: var(--gray-500);
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }

    .pagination .active span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    [dir="rtl"] .btn-doctor i {
        transform: rotate(180deg);
    }
</style>
@endpush

@section('content')
<div class="doctors-hero">
    <div class="container">
        <span class="sec-tag">{{ __('messages.our_medical_team') }}</span>
        <h2>{{ __('messages.specialist_doctors_title') }}</h2>
        <p>{{ __('messages.best_medical_staff') }}</p>
    </div>
</div>

<div class="container">
    @if($doctors->count())
        <div class="doctors-grid">
            @foreach($doctors as $doctor)
            <div class="doctor-card">
                <div class="doctor-image">
                    @if($doctor->photo)
                        <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->user->name }}">
                    @elseif($doctor->user->avatar)
                        <img src="{{ asset('storage/' . $doctor->user->avatar) }}" alt="{{ $doctor->user->name }}">
                    @else
                        <i class="fa-solid fa-user-doctor"></i>
                    @endif
                </div>

                <div class="doctor-content">
                    <h3 class="doctor-name">د. {{ $doctor->user->name }}</h3>
                    
                    @if($doctor->specialization)
                        <p class="doctor-specialty">{{ $doctor->specialization->name }}</p>
                    @endif

                    @if($doctor->department)
                        <p class="doctor-department">
                            <i class="fa-solid fa-hospital"></i>
                            {{ $doctor->department->name }}
                        </p>
                    @endif

                    @if($doctor->experience_years)
                        <div class="doctor-experience">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>{{ $doctor->experience_years }} {{ __('messages.years_experience') }}</span>
                        </div>
                    @endif

                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                    </div>

                    <div class="doctor-actions">
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn-doctor btn-primary-doctor">
                            <i class="fa-solid fa-calendar-plus"></i>
                            {{ __('messages.book') }}
                        </a>
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn-doctor btn-outline-doctor">
                            <i class="fa-solid fa-info-circle"></i>
                            {{ __('messages.view_all') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $doctors->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 5rem 2rem; color: var(--gray-500);">
            <i class="fa-solid fa-folder-open" style="font-size: 4rem; margin-bottom: 1rem; display: block; opacity: 0.2;"></i>
            <p style="font-size: 1.1rem;">{{ __('messages.no_doctors') }}</p>
        </div>
    @endif
</div>
@endsection
