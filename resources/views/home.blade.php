@extends('layouts.app')
@section('title', app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home')

@push('styles')
<style>
.hero {
    min-height:calc(100vh - 80px);
    background:linear-gradient(135deg,#eff6ff 0%,#ecfeff 50%,#f0fdf4 100%);
    display:flex; align-items:center;
    position:relative; overflow:hidden;
    padding:4rem 0;
}
.hero-inner {
    display:grid; grid-template-columns:1fr 1fr;
    gap:4rem; align-items:center; position:relative; z-index:1;
}
.hero h1 {
    font-size:3rem; font-weight:900; line-height:1.2;
    margin-bottom:1.25rem; color:#1f2937;
}
.hero-desc { font-size:1.05rem; color:#4b5563; max-width:480px; margin-bottom:2.5rem; line-height:1.8; }
.hero-btns { display:flex; gap:1rem; flex-wrap:wrap; }
.section { padding: 5rem 0; }
.sec-head { text-align:center; margin-bottom:3.5rem; }
.sec-tag { display:inline-block; background:#e0f2fe; color:#0369a1; font-size:.75rem; font-weight:800; padding:.3rem 1rem; border-radius:50px; margin-bottom:.75rem; text-transform:uppercase; }
.dept-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1.25rem; }
.dept-card { background:#fff; padding:1.5rem; border-radius:1rem; text-align:center; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.3s; }
.dept-card:hover { transform: translateY(-5px); }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
<div class="container">
<div class="hero-inner">
    <div>
        <div class="sec-tag"><i class="fa-solid fa-shield-halved"></i> {{ __('messages.certified_by_ministry') }}</div>
        <h1>{{ __('messages.hero_title') }}</h1>
        <p class="hero-desc">{{ __('messages.hero_subtitle') }}</p>
        <div class="hero-btns">
            <a href="{{ route('doctors.index') }}" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_now') }}
            </a>
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

{{-- DEPARTMENTS --}}
<section class="section bg-white">
<div class="container">
    <div class="sec-head">
        <div class="sec-tag">{{ __('messages.our_departments' ) }}</div>
        <h2>{{ __('messages.discover_departments') }}</h2>
        <p>{{ __('messages.departments_description') }}</p>
    </div>
    <div class="dept-grid">
        @foreach($departments as $dept)
        <a href="{{ route('departments.show', $dept) }}" class="dept-card text-decoration-none text-dark">
            <div class="mb-3 text-primary" style="font-size: 2rem;">
                <i class="fa-solid fa-{{ $dept->icon ?? 'hospital' }}"></i>
            </div>
            <h3 class="h5 font-weight-bold">{{ $dept->name }}</h3>
            <p class="text-muted small">{{ $dept->doctors_count }} {{ __('messages.doctors_count') }}</p>
        </a>
        @endforeach
    </div>
</div>
</section>

{{-- WHY US --}}
<section class="section">
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="sec-tag">{{ __('messages.why_choose_us') }}</div>
            <h2 class="mb-4">{{ __('messages.best_choice') }}</h2>
            <div class="list-group list-group-flush">
                <div class="list-group-item bg-transparent border-0 px-0 mb-3">
                    <h5 class="font-weight-bold text-primary"><i class="fa-solid fa-user-doctor me-2"></i> {{ __('messages.outstanding_doctors') }}</h5>
                    <p class="text-muted">{{ __('messages.outstanding_doctors_desc') }}</p>
                </div>
                <div class="list-group-item bg-transparent border-0 px-0 mb-3">
                    <h5 class="font-weight-bold text-primary"><i class="fa-solid fa-clock me-2"></i> {{ __('messages.continuous_service') }}</h5>
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
