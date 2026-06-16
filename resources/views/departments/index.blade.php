@extends('layouts.app')
@section('title', __('messages.our_departments'))

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

    .departments-hero {
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

    .departments-hero h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .departments-hero p {
        max-width: 600px;
        margin: 0 auto;
        color: var(--gray-500);
        font-size: 1.1rem;
    }

    .departments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
        padding: 40px 0 100px;
    }

    .department-card {
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

    .department-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    .department-image {
        height: 200px;
        background: linear-gradient(135deg, var(--primary-light), rgba(0, 180, 216, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .department-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .department-content {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .department-name {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        color: #111827;
    }

    .department-description {
        font-size: 0.95rem;
        color: var(--gray-500);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .department-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-department {
        flex: 1;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: 0.3s;
    }

    .btn-primary-dept { background: var(--primary); color: white; }
    .btn-outline-dept { border: 2px solid var(--primary-light); color: var(--primary); }
</style>
@endpush

@section('content')
<div class="departments-hero">
    <div class="container">
        <span class="sec-tag">{{ __('messages.departments') }}</span>
        <h2>{{ __('messages.our_departments') }}</h2>
        <p>{{ __('messages.departments_description') }}</p>
    </div>
</div>

<div class="container">
    @if($departments->count())
        <div class="departments-grid">
            @foreach($departments as $department)
            <div class="department-card">
                <div class="department-image">
                    @if($department->image)
                        <img src="{{ asset($department->image) }}" alt="{{ $department->name }}">
                    @else
                        <i class="fa-solid fa-hospital fa-3x text-primary"></i>
                    @endif
                </div>

                <div class="department-content">
                    <h3 class="department-name">{{ $department->name }}</h3>
                    <p class="department-description">{{ Str::limit($department->description, 120) }}</p>

                    <div class="department-actions">
                        <a href="{{ route('departments.show', $department->id) }}" class="btn-department btn-primary-dept">
                            {{ __('messages.view_all') }}
                        </a>
                        <a href="{{ route('doctors.index') }}?department={{ $department->id }}" class="btn-department btn-outline-dept">
                            {{ __('messages.view_doctors') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
