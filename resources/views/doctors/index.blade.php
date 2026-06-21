@extends('layouts.app')
@section('title', __('messages.doctors') . ' - ' . __('messages.sehati'))

@push('styles')
<style>
    .doctors-hero { padding: 2rem 0 3rem; text-align: center; background: linear-gradient(180deg, rgba(224,244,255,0.4) 0%, transparent 100%); }
    .doctors-hero .sec-tag { display: inline-block; padding: 8px 20px; background: #e0f4ff; color: #0077B6; border-radius: 50px; font-weight: 700; font-size: 0.85rem; margin-bottom: 1rem; }
    .doctors-hero h2 { font-size: 2.75rem; font-weight: 900; color: #1f2937; margin-bottom: 0.75rem; }
    .doctors-hero p { font-size: 1.15rem; color: #6b7280; max-width: 650px; margin: 0 auto; line-height: 1.8; }
    .doctor-card-wrap .card { border-radius: 1rem; transition: transform 0.3s; }
    .doctor-card-wrap .card:hover { transform: translateY(-8px); }
    .doctor-card-wrap .card-img-area { height: 180px; overflow: hidden; }
    .doctor-card-wrap .card-body h5 { font-size: 1.05rem; }
    .bg-soft-primary { background-color: #e0f4ff; }
    .object-fit-cover { object-fit: cover; }
</style>
@endpush

@section('content')
<div class="doctors-hero">
    <div class="container">
        <span class="sec-tag">{{ __('messages.our_medical_team') }}</span>
        <h2>{{ __('messages.medical_team_subtitle') }}</h2>
        <p>{{ __('messages.medical_team_description') }}</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        @foreach($doctors as $doctor)
            <div class="col-md-6 col-lg-4 doctor-card-wrap">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-img-area position-relative">
                        @if($doctor->photo)
                            <img src="{{ asset('storage/' . $doctor->photo) }}" class="w-100 h-100 object-fit-cover" alt="{{ $doctor->user->name }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="fa-solid fa-user-doctor fa-3x text-secondary opacity-25"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <h5 class="fw-bold mb-1">{{ __('messages.dr') }} {{ $doctor->user->name }}</h5>
                        <p class="text-primary small fw-bold mb-1">{{ $doctor->specialization->name ?? __('messages.specialization') }}</p>
                        <p class="text-muted small mb-2">{{ $doctor->department->name ?? __('messages.department') }}</p>
                        @if($doctor->experience_years)
                            <div class="d-flex align-items-center mb-2 text-muted small">
                                <i class="fa-solid fa-briefcase me-2 ms-2"></i>
                                {{ $doctor->experience_years }} {{ __('messages.experience_years_count') }}
                            </div>
                        @endif
                        @auth
                            @if(auth()->user()->isPatient())
                            <a href="{{ route('appointments.create', $doctor) }}" class="btn btn-primary w-100 rounded-pill btn-sm">
                                <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_appointment_btn') }}
                            </a>
                            @else
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary w-100 rounded-pill btn-sm">
                                <i class="fa-solid fa-eye"></i> {{ __('messages.view_all') }}
                            </a>
                            @endif
                        @else
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary w-100 rounded-pill btn-sm">
                            <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.book_appointment_btn') }}
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $doctors->links() }}
    </div>
</div>
@endsection
