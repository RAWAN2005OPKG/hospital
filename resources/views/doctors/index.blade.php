@extends('layouts.app')

@section('title', 'الأطباء - صحتي')

@section('content')
<div class="section">
    <div class="container">
        <div class="section-head">
            <div class="sec-tag">فريقنا الطبي</div>
            <h2>نخبة من الأطباء المتخصصين</h2>
            <p>أفضل الكوادر الطبية في مختلف التخصصات</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
            @foreach($doctors as $doctor)
                <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.05)'">
                    <div style="height: 200px; background: linear-gradient(135deg, var(--blue), var(--cyan)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 4rem;">
                        @if($doctor->photo)
                            <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @elseif($doctor->user->avatar)
                            <img src="{{ asset('storage/' . $doctor->user->avatar) }}" alt="{{ $doctor->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-user-doctor"></i>
                        @endif
                    </div>
                    
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">د. {{ $doctor->user->name }}</h3>
                        <p style="color: var(--blue); font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">{{ $doctor->specialization->name ?? 'تخصص' }}</p>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 1rem;">{{ $doctor->department->name ?? 'قسم' }}</p>
                        
                        @if($doctor->experience_years)
                            <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 1rem;">
                                <i class="fa-solid fa-briefcase" style="color: var(--cyan); margin-left: 0.5rem;"></i>
                                {{ $doctor->experience_years }} سنة خبرة
                            </p>
                        @endif
                        
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                            <span style="color: var(--yellow); font-size: 0.9rem;">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half"></i>
                            </span>
                        </div>
                        
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                            <i class="fa-solid fa-calendar-plus"></i> احجز موعداً
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection