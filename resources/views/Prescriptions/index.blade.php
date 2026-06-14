@extends('layouts.app')
@section('title', 'الوصفات الطبية')

@section('content')
<div class="section-head" style="margin-top: 100px;">
    <span class="sec-tag">الوصفات</span>
    <h2>وصفاتك الدوائية</h2>
    <p>تابع أدويتك، مواعيد تناولها، والجرعات المحددة من قبل الأطباء</p>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
        @forelse($prescriptions ?? [] as $presc)
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="fa-solid fa-pills"></i>
                </div>
                <span style="font-size: 0.8rem; color: var(--gray-400);">{{ $presc->created_at->format('Y/m/d') }}</span>
            </div>
            <h3 style="margin-bottom: 0.5rem;">{{ $presc->medicine_name }}</h3>
            <p style="color: var(--primary); font-weight: 700; margin-bottom: 1rem;">الجرعة: {{ $presc->dosage }}</p>
            <div style="background: var(--gray-50); padding: 1rem; border-radius: 10px; font-size: 0.9rem; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-circle-info" style="color: var(--info); margin-left: 0.5rem;"></i>
                {{ $presc->instructions }}
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--gray-100); padding-top: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <img src="https://i.pravatar.cc/150?u=doc" style="width: 30px; height: 30px; border-radius: 50%;">
                    <span style="font-size: 0.85rem; font-weight: 600;">{{ $presc->doctor->user->name }}</span>
                </div>
                <button class="btn btn-outline btn-sm">تكرار الوصفة</button>
            </div>
        </div>
        @empty
        <div class="card" style="grid-column: 1/-1; text-align: center; padding: 4rem;">
            <i class="fa-solid fa-capsules" style="font-size: 3rem; color: var(--gray-200); margin-bottom: 1rem; display: block;"></i>
            <p style="color: var(--gray-400);">لا توجد وصفات طبية نشطة حالياً</p>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm" style="margin-top: 1rem;">حجز موعد جديد</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
