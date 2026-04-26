{{-- ════ doctors/index.blade.php ════ --}}
@extends('layouts.app')
@section('title','الدكاترة')
@section('content')

<div class="page-header">
    <div class="container">
        <h1>فريقنا الطبي</h1>
        <p>نخبة من الأطباء المتخصصين في مختلف التخصصات</p>
        <div class="breadcrumb"><a href="{{ route('home') }}">الرئيسية</a> / الدكاترة</div>
    </div>
</div>

<section class="section-sm">
<div class="container">

{{-- Filters --}}
<div class="card" style="margin-bottom:2rem">
    <div class="card-body">
    <form method="GET" style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
            <label class="form-label">بحث</label>
            <div style="position:relative">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.82rem"></i>
                <input type="text" name="search" class="form-control" style="padding-right:2.5rem"
                    placeholder="اسم الدكتور..." value="{{ request('search') }}">
            </div>
        </div>
        <div style="min-width:180px">
            <label class="form-label">القسم</label>
            <select name="department_id" class="form-control">
                <option value="">جميع الأقسام</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id')==$dept->id?'selected':'' }}>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="min-width:180px">
            <label class="form-label">التخصص</label>
            <select name="specialization_id" class="form-control">
                <option value="">جميع التخصصات</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->id }}" {{ request('specialization_id')==$spec->id?'selected':'' }}>{{ $spec->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> تصفية</button>
        @if(request()->hasAny(['search','department_id','specialization_id']))
        <a href="{{ route('doctors.index') }}" class="btn btn-outline">مسح</a>
        @endif
    </form>
    </div>
</div>

@if($doctors->count())
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem">
    @foreach($doctors as $doctor)
    <div class="doc-card">
        <div class="doc-card-img">
            @if($doctor->user->avatar ?? false)
                <img src="{{ asset('storage/'.$doctor->user->avatar) }}" alt="{{ $doctor->user->name }}">
            @else
                <i class="fa-solid fa-user-doctor"></i>
            @endif
        </div>
        <div class="doc-card-body">
            <div class="doc-card-name">{{ $doctor->user->name }}</div>
            <div class="doc-card-spec">{{ $doctor->specialization->name ?? '' }}</div>
            <div class="doc-card-dept"><i class="fa-solid fa-hospital" style="margin-left:.3rem;color:var(--muted)"></i>{{ $doctor->department->name ?? '' }}</div>
            <div style="margin-top:.6rem;display:flex;gap:.5rem;flex-wrap:wrap">
                @if($doctor->specialization)
                <span class="badge badge-blue">{{ $doctor->specialization->name }}</span>
                @endif
            </div>
        </div>
        <div class="doc-card-footer">
            <span class="stars">★★★★<span style="color:#e2e8f0">★</span></span>
            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary btn-sm">احجز موعد</a>
        </div>
    </div>
    @endforeach
</div>
<div>{{ $doctors->withQueryString()->links() }}</div>
@else
<div style="text-align:center;padding:5rem;color:var(--muted)">
    <i class="fa-solid fa-user-doctor" style="font-size:3.5rem;margin-bottom:1rem;display:block;opacity:.2"></i>
    لا يوجد دكاترة يطابقون بحثك.
</div>
@endif

</div>
</section>
@endsection