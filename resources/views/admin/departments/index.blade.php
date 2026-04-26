{{-- ════ departments/index.blade.php ════ --}}
@extends('layouts.app')
@section('title','الأقسام الطبية')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>الأقسام الطبية</h1>
        <p>تخصصات طبية متنوعة تحت سقف واحد</p>
        <div class="breadcrumb"><a href="{{ route('home') }}">الرئيسية</a> / الأقسام</div>
    </div>
</div>
<section class="section-sm"><div class="container">
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem">
    @foreach($departments as $dept)
    <a href="{{ route('departments.show', $dept) }}" class="dept-card" style="text-decoration:none;display:block">
        <div class="dept-icon" style="height:120px;">
@if($dept->image)
<img src="{{ asset($dept->image) }}" alt="{{ $dept->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
@else
<i class="fa-solid fa-hospital" style="font-size:4rem;color:#3b82f6;"></i>
@endif
</div>
        <h3 style="font-size:1.05rem;font-weight:800;margin-bottom:.4rem">{{ $dept->name }}</h3>
        @if($dept->description)<p style="font-size:.86rem;color:var(--muted);margin-bottom:.75rem;line-height:1.6">{{ Str::limit($dept->description,80) }}</p>@endif
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:auto">
            <span class="badge badge-blue">{{ $dept->doctors_count }} دكتور</span>
            <span style="color:var(--blue);font-size:.85rem;font-weight:700">عرض الأطباء <i class="fa-solid fa-arrow-left fa-xs"></i></span>
        </div>
    </a>
    @endforeach
</div>
</div></section>
@endsection