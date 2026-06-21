@extends('layouts.app')
@section('title', app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home')

@push('styles')
<style>
.hero {
    min-height: 70vh;
    background: linear-gradient(135deg,#eff6ff 0%,#ecfeff 50%,#f0fdf4 100%);
    display: flex; align-items: center;
    padding: 3rem 0;
}
.hero-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
.hero h1 { font-size: 2.75rem; font-weight: 900; line-height: 1.2; margin-bottom: 1.25rem; color: #1f2937; }
.hero-desc { font-size: 1.1rem; color: #4b5563; max-width: 480px; margin-bottom: 2rem; line-height: 1.8; }
.hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
.home-section { padding: 4rem 0; }
.sec-head { text-align: center; margin-bottom: 3rem; }
.sec-tag { display: inline-block; background: #e0f2fe; color: #0369a1; font-size: 0.8rem; font-weight: 800; padding: 0.35rem 1rem; border-radius: 50px; margin-bottom: 0.75rem; }
.sec-head h2 { font-size: 2.25rem; font-weight: 900; color: #1f2937; }
.dept-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
.dept-card {
    background: #fff; border-radius: 1.25rem; overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;
    text-decoration: none; color: inherit; transition: transform 0.3s, box-shadow 0.3s;
    display: flex; flex-direction: column;
}
.dept-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
.dept-card-img { height: 140px; background: linear-gradient(135deg, #e0f4ff, #ecfeff); display: flex; align-items: center; justify-content: center; }
.dept-card-img i { font-size: 3rem; color: #0077B6; }
.dept-card-body { padding: 1.25rem; text-align: center; }
.dept-card-body h3 { font-size: 1.15rem; font-weight: 800; margin-bottom: 0.35rem; }
.services-quick { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 2rem; }
.service-quick-link {
    background: #fff; border-radius: 1rem; padding: 1.25rem; text-align: center;
    text-decoration: none; color: #1f2937; border: 1px solid #e5e7eb;
    transition: all 0.3s; box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.service-quick-link:hover { border-color: #0077B6; transform: translateY(-4px); color: #0077B6; }
.service-quick-link i { font-size: 1.75rem; color: #0077B6; display: block; margin-bottom: 0.5rem; }
@media (max-width: 768px) { .hero-inner { grid-template-columns: 1fr; } .services-quick { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<section class="hero">
<div class="container">
<div class="hero-inner">
    <div>
        <div class="sec-tag"><i class="fa-solid fa-shield-halved"></i> {{ __('messages.certified_by_ministry') }}</div>
        <h1>{{ __('messages.hero_title') }}</h1>
        <p class="hero-desc">{{ __('messages.hero_subtitle') }}</p>
        <div class="hero-btns">
            @auth
                @if(Auth::user()->isPatient())
                <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">
                    <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_now') }}
                </a>
                @else
                <a href="{{ route('doctors.index') }}" class="btn btn-primary btn-lg">
                    <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_now') }}
                </a>
                @endif
            @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_now') }}
            </a>
            @endauth
            <a href="{{ route('departments') }}" class="btn btn-outline-primary btn-lg">
                <i class="fa-solid fa-hospital"></i> {{ __('messages.explore_departments') }}
            </a>
        </div>
    </div>
    <div class="hero-visual">
        <img src="https://i.pinimg.com/736x/c4/46/f8/c446f87b3bbd36dd386aebc3e55b7db3.jpg" alt="Medical" class="img-fluid rounded-4 shadow-lg">
    </div>
</div>
</div>
</section>

<section class="home-section bg-white">
<div class="container">
    <div class="sec-head">
        <div class="sec-tag">{{ __('messages.our_departments') }}</div>
        <h2>{{ __('messages.discover_departments') }}</h2>
        <p class="text-muted">{{ __('messages.departments_description') }}</p>
    </div>
    <div class="dept-grid">
        @foreach($departments as $dept)
        <a href="{{ route('departments.show', $dept) }}" class="dept-card">
            <div class="dept-card-img">
                <i class="fa-solid fa-{{ $dept->icon ?? 'hospital' }}"></i>
            </div>
            <div class="dept-card-body">
                <h3>{{ $dept->name }}</h3>
                <p class="text-muted small mb-0">{{ $dept->doctors_count }} {{ __('messages.doctors_count') }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <div class="services-quick">
        <a href="{{ route('consultations.index') }}" class="service-quick-link">
            <i class="fa-solid fa-comments"></i>
            <strong>{{ __('messages.footer_medical_consultations') }}</strong>
        </a>
        <a href="{{ route('services.lab') }}" class="service-quick-link">
            <i class="fa-solid fa-flask-vial"></i>
            <strong>{{ __('messages.footer_tests') }}</strong>
        </a>
        <a href="{{ route('services.index') }}#surgeries" class="service-quick-link">
            <i class="fa-solid fa-user-doctor"></i>
            <strong>{{ __('messages.footer_surgeries') }}</strong>
        </a>
    </div>
</div>
</section>

<section class="home-section">
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="sec-tag">{{ __('messages.why_choose_us') }}</div>
            <h2 class="mb-4 fw-bold">{{ __('messages.best_choice') }}</h2>
            <div class="list-group list-group-flush">
                <div class="list-group-item bg-transparent border-0 px-0 mb-3">
                    <h5 class="fw-bold text-primary"><i class="fa-solid fa-user-doctor me-2"></i> {{ __('messages.outstanding_doctors') }}</h5>
                    <p class="text-muted">{{ __('messages.outstanding_doctors_desc') }}</p>
                </div>
                <div class="list-group-item bg-transparent border-0 px-0 mb-3">
                    <h5 class="fw-bold text-primary"><i class="fa-solid fa-clock me-2"></i> {{ __('messages.continuous_service') }}</h5>
                    <p class="text-muted">{{ __('messages.continuous_service_desc') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://i.pinimg.com/736x/f4/0d/93/f40d93b33a39be64f90258df05bb9ce2.jpg" alt="Why Us" class="img-fluid rounded-4 shadow">
        </div>
    </div>
</div>
</section>

@endsection
