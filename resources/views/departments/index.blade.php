@extends('layouts.app')
@section('title','الأقسام الطبية')
@section('content')

<div class="page-header">
    <div class="container">
        <h1>الأقسام الطبية</h1>
        <p>استكشف جميع أقسامنا الطبية المتخصصة</p>
        <div class="breadcrumb"><a href="{{ route('home') }}">الرئيسية</a> <i class="fa-solid fa-chevron-left fa-xs"></i> الأقسام</div>
    </div>
</div>

<section class="section-sm"><div class="container">
@if($departments->count())
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:1.75rem">
    @foreach($departments as $department)
    <div style="background:#fff;border:2px solid var(--border);border-radius:20px;overflow:hidden;transition:all .3s cubic-bezier(.34,1.56,.64,1)"
         onmouseover="this.style.borderColor='var(--blue)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 48px rgba(37,99,235,.14)'"
         onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.boxShadow=''">

        <div style="height:165px;background:linear-gradient(135deg,var(--blue-lt),var(--cyan-lt));display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
            <div style="position:absolute;top:-25px;right:-25px;width:90px;height:90px;border-radius:50%;background:rgba(37,99,235,.07)"></div>
            <div style="position:absolute;bottom:-20px;left:-20px;width:70px;height:70px;border-radius:50%;background:rgba(6,182,212,.07)"></div>
            @if($department->image)
                <img src="{{ asset('storage/' . $department->image) }}" style="width:100%;height:100%;object-fit:cover">
            @else
                <div style="width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,var(--blue),var(--cyan));display:flex;align-items:center;justify-content:center;font-size:1.9rem;color:#fff;box-shadow:0 8px 24px rgba(37,99,235,.3);position:relative">
                    <i class="fa-solid fa-hospital"></i>
                </div>
            @endif
        </div>

        <div style="padding:1.4rem">
            <h3 style="font-size:1.05rem;font-weight:900;margin-bottom:.4rem">{{ $department->name }}</h3>
            @if($department->description)
            <p style="font-size:.84rem;color:var(--muted);line-height:1.7;margin-bottom:1rem">{{ Str::limit($department->description,85) }}</p>
            @endif
            <div style="display:flex;align-items:center;gap:.4rem;font-size:.82rem;color:var(--muted);margin-bottom:1.2rem">
                <div style="width:26px;height:26px;border-radius:7px;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:.72rem">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <span><strong style="color:var(--text)">{{ $department->doctors_count ?? 0 }}</strong> طبيب متخصص</span>
            </div>
            <a href="{{ route('departments.show',$department->id) }}"
               style="display:flex;align-items:center;justify-content:center;gap:.5rem;padding:.7rem;border-radius:50px;background:linear-gradient(135deg,var(--blue),var(--cyan));color:#fff;font-weight:700;font-size:.86rem;text-decoration:none;box-shadow:0 4px 14px rgba(37,99,235,.25);transition:all .25s"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 22px rgba(37,99,235,.35)'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(37,99,235,.25)'">
                <i class="fa-solid fa-stethoscope"></i> اعرف المزيد <i class="fa-solid fa-arrow-left fa-xs"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div style="text-align:center;padding:5rem;color:var(--muted)">
    <i class="fa-solid fa-folder-open" style="font-size:3.5rem;margin-bottom:1rem;display:block;opacity:.2"></i>
    <p style="font-size:1rem">لا توجد أقسام حالياً</p>s
</div>
@endif
</div></section>
@endsection