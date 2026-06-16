@extends('layouts.app')
@section('title', __('messages.doctors') . ' - ' . __('messages.sehati'))

@section('content')
<div class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 mb-2">{{ __('messages.our_medical_team') }}</div>
            <h2 class="fw-bold">{{ __('messages.medical_team_subtitle') }}</h2>
            <p class="text-muted">{{ __('messages.medical_team_description') }}</p>
        </div>
        
        <div class="row g-4">
            @foreach($doctors as $doctor)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-up transition-all">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" class="card-img-top h-100 w-100 object-fit-cover" alt="{{ $doctor->user->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="fa-solid fa-user-doctor fa-4x text-secondary opacity-25"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-1">د. {{ $doctor->user->name }}</h5>
                            <p class="text-primary small fw-bold mb-2">{{ $doctor->specialization->name ?? __('messages.specialization') }}</p>
                            <p class="text-muted small mb-3">{{ $doctor->department->name ?? __('messages.department') }}</p>
                            
                            @if($doctor->experience_years)
                                <div class="d-flex align-items-center mb-3 text-muted small">
                                    <i class="fa-solid fa-briefcase me-2 ms-2"></i>
                                    {{ $doctor->experience_years }} {{ __('messages.experience_years_count') }}
                                </div>
                            @endif
                            
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary w-100 rounded-pill">
                                <i class="fa-solid fa-calendar-plus me-1 ms-1"></i> {{ __('messages.book_appointment_btn') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{ $doctors->links() }}
        </div>
    </div>
</div>

<style>
    .hover-up:hover { transform: translateY(-10px); transition: 0.3s; }
    .bg-soft-primary { background-color: #e0f4ff; }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection
