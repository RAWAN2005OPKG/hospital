@extends('layouts.app')
@section('title','الرئيسية')

@push('styles')
<style>
.hero {
    min-height:calc(100vh - var(--nav-h));
    background:linear-gradient(135deg,#eff6ff 0%,#ecfeff 50%,#f0fdf4 100%);
    display:flex; align-items:center;
    position:relative; overflow:hidden;
    padding:4rem 0;
}
.hero::before {
    content:''; position:absolute; top:-100px; left:-100px;
    width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(37,99,235,.08) 0%,transparent 70%);
    pointer-events:none;
}
.hero::after {
    content:''; position:absolute; bottom:-80px; right:-80px;
    width:400px; height:400px; border-radius:50%;
    background:radial-gradient(circle,rgba(6,182,212,.07) 0%,transparent 70%);
    pointer-events:none;
}
.hero-inner {
    display:grid; grid-template-columns:1fr 1fr;
    gap:4rem; align-items:center; position:relative; z-index:1;
}
.hero-eyebrow {
    display:inline-flex; align-items:center; gap:.5rem;
    background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.15);
    color:var(--blue); padding:.35rem 1rem; border-radius:50px;
    font-size:.82rem; font-weight:700; margin-bottom:1.5rem;
    letter-spacing:.04em; text-transform:uppercase;
}
.hero h1 {
    font-size:3rem; font-weight:900; line-height:1.2;
    margin-bottom:1.25rem; color:var(--text);
}
.hero h1 .hl {
    background:linear-gradient(135deg,var(--blue),var(--cyan));
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.hero-desc { font-size:1.05rem; color:var(--muted); max-width:480px; margin-bottom:2.5rem; line-height:1.8; }
.hero-btns { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:3rem; }
.hero-trust {
    display:flex; align-items:center; gap:1.5rem;
    padding:1rem 1.5rem; background:rgba(255,255,255,.8);
    backdrop-filter:blur(8px); border-radius:14px;
    border:1px solid rgba(37,99,235,.1);
    width:fit-content;
}
.hero-trust-item { text-align:center; }
.hero-trust-num { font-size:1.5rem; font-weight:900; color:var(--blue); line-height:1; }
.hero-trust-lbl { font-size:.75rem; color:var(--muted); margin-top:.2rem; }
.hero-trust-div { width:1px; height:40px; background:var(--border); }

/* visual side */
.hero-visual { display:flex; flex-direction:column; gap:1rem; position:relative; }
.hero-visual-main {
    background:url('{{ asset('https://i.pinimg.com/736x/c4/46/f8/c446f87b3bbd36dd386aebc3e55b7db3.jpg') }}');
    background-size: cover; background-position: center;
    height: 600px;
    position: relative;
    border-radius: var(--radius);
}
.hero-visual-main::before {
    content:''; position:absolute; top:-30px; right:-30px;
    width:120px; height:120px; border-radius:50%;
    background:rgba(255,255,255,.1);
}
.hero-float-card {
    background:rgba(255,255,255,.95); backdrop-filter:blur(8px);
    border-radius:14px; padding:1rem 1.25rem;
    display:flex; align-items:center; gap:.85rem;
    box-shadow:0 8px 28px rgba(0,0,0,.1);
    border:1px solid rgba(255,255,255,.8);
    transition:transform .3s;
}
.hero-float-card:hover { transform:translateX(-6px); }
.hfc-icon {
    width:44px; height:44px; border-radius:12px; flex-shrink:0;
    background:linear-gradient(135deg,var(--blue-lt),var(--cyan-lt));
    color:var(--blue); display:flex; align-items:center; justify-content:center; font-size:1.1rem;
}
.hfc-title { font-weight:700; font-size:.9rem; }
.hfc-sub { font-size:.78rem; color:var(--muted); }

/* SECTION HEADING */
.sec-head { text-align:center; margin-bottom:3.5rem; }
.sec-tag {
    display:inline-block; background:var(--blue-lt); color:var(--blue);
    font-size:.75rem; font-weight:800; padding:.3rem 1rem; border-radius:50px;
    margin-bottom:.75rem; letter-spacing:.06em; text-transform:uppercase;
}
.sec-head h2 { font-size:2rem; font-weight:900; margin-bottom:.5rem; }
.sec-head p { color:var(--muted); max-width:480px; margin:0 auto; }

/* SERVICES */
.svc-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; }
.svc-card {
    background:#fff; border:2px solid transparent; border-radius:var(--radius);
    padding:2rem; text-align:center; transition:all .3s;
    box-shadow:var(--shadow);
}
.svc-card:hover { border-color:var(--blue); transform:translateY(-4px); box-shadow:var(--shadow-lg); }
.svc-icon {
    width:72px; height:72px; border-radius:20px; margin:0 auto 1.25rem;
    background:linear-gradient(135deg,var(--blue-lt),var(--cyan-lt));
    color:var(--blue); display:flex; align-items:center; justify-content:center; font-size:1.8rem;
    transition:all .3s;
}
.svc-card:hover .svc-icon { background:linear-gradient(135deg,var(--blue),var(--cyan)); color:#fff; }
.svc-card h3 { font-size:1rem; font-weight:800; margin-bottom:.5rem; }
.svc-card p { font-size:.86rem; color:var(--muted); line-height:1.7; }

/* WHY US */
.why-grid { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
.why-list { display:flex; flex-direction:column; gap:1.25rem; }
.why-item { display:flex; gap:1rem; align-items:flex-start; }
.why-check { width:44px; height:44px; border-radius:12px; flex-shrink:0; background:var(--blue-lt); color:var(--blue); display:flex; align-items:center; justify-content:center; font-size:1rem; }
.why-item h4 { font-weight:800; margin-bottom:.2rem; }
.why-item p { font-size:.86rem; color:var(--muted); line-height:1.7; }

/* CTA */
.cta-section {
    background:url('{{ asset('https://i.pinimg.com/736x/f4/0d/93/f40d93b33a39be64f90258df05bb9ce2.jpg' ) }}');
    background-size: cover; background-position: center;
    background-attachment: fixed;
    color:#fff; text-align:center; 
    min-height: 60vh; 
    padding:4rem 2rem; 
    position:relative; 
    overflow:hidden;
    display: flex;
    align-items: center;
}
.cta-section::before {
    content:''; position:absolute; top:-50%; left:-20%;
    width:400px; height:400px; border-radius:50%;
    background:rgba(255,255,255,.05); pointer-events:none;
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
<div class="container">
<div class="hero-inner">
    <div>
        <div class="hero-eyebrow"><i class="fa-solid fa-shield-halved"></i> معتمد من وزارة الصحة</div>
        <h1>رعاية صحية <span class="hl">متكاملة</span><br>بأيدي أمينة</h1>
        <p class="hero-desc">نقدم لك أفضل الخدمات الطبية مع نخبة من الأطباء المتخصصين في بيئة علاجية حديثة ومريحة.</p>
        <div class="hero-btns">
            <a href="{{ route('doctors.index') }}" class="btn btn-primary">
                <i class="fa-solid fa-calendar-plus"></i> احجز موعداً الآن
            </a>
            <a href="{{ route('departments') }}" class="btn btn-outline">
                <i class="fa-solid fa-hospital"></i> استكشف الأقسام
            </a>
        </div>
        <div class="hero-trust">
            <div class="hero-trust-item">
                <div class="hero-trust-num">{{ $doctors->count() }}+</div>
                <div class="hero-trust-lbl">طبيب متخصص</div>
            </div>
            <div class="hero-trust-div"></div>
            <div class="hero-trust-item">
                <div class="hero-trust-num">{{ $departments->count() }}</div>
                <div class="hero-trust-lbl">قسم طبي</div>
            </div>
            <div class="hero-trust-div"></div>
            <div class="hero-trust-item">
                <div class="hero-trust-num">5K+</div>
                <div class="hero-trust-lbl">مريض راضٍ</div>
            </div>
            <div class="hero-trust-div"></div>
            <div class="hero-trust-item">
                <div class="hero-trust-num">95%</div>
                <div class="hero-trust-lbl">رضا المرضى</div>
            </div>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-visual-main">
            <div style="font-size:.8rem;opacity:.8;margin-bottom:.5rem">مرحباً بك في</div>
            <div style="font-size:1.5rem;font-weight:900;margin-bottom:.3rem">صحتي</div>
            <div style="font-size:.87rem;opacity:.85">الرعاية الصحية المتكاملة</div>
            <div style="margin-top:1.5rem;display:flex;gap:1rem">
                <div style="text-align:center;background:rgba(255,255,255,.15);border-radius:10px;padding:.75rem 1.1rem">
                    <div style="font-size:1.3rem;font-weight:900">24/7</div>
                    <div style="font-size:.72rem;opacity:.8">طوارئ</div>
                </div>
                <div style="text-align:center;background:rgba(255,255,255,.15);border-radius:10px;padding:.75rem 1.1rem">
                    <div style="font-size:1.3rem;font-weight:900">20+</div>
                    <div style="font-size:.72rem;opacity:.8">سنة خبرة</div>
                </div>
                <div style="text-align:center;background:rgba(255,255,255,.15);border-radius:10px;padding:.75rem 1.1rem">
                    <div style="font-size:1.3rem;font-weight:900">A+</div>
                    <div style="font-size:.72rem;opacity:.8">تقييم</div>
                </div>
            </div>
        </div>
        <div class="hero-float-card">
            <div class="hfc-icon"><i class="fa-solid fa-clock"></i></div>
            <div><div class="hfc-title">طوارئ على مدار الساعة</div><div class="hfc-sub">خدمة متواصلة 24/7</div></div>
        </div>
        <div class="hero-float-card">
            <div class="hfc-icon"><i class="fa-solid fa-user-doctor"></i></div>
            <div><div class="hfc-title">أطباء متخصصون</div><div class="hfc-sub">{{ $doctors->count() }}+ دكتور في مختلف التخصصات</div></div>
        </div>
        <div class="hero-float-card">
            <div class="hfc-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div><div class="hfc-title">حجز سهل وسريع</div><div class="hfc-sub">احجز موعدك أونلاين بدقائق</div></div>
        </div>
    </div>
</div>
</div>
</section>

{{-- DEPARTMENTS --}}
<section class="section" style="background:#fff">
<div class="container">
    <div class="sec-head">
        <div class="sec-tag">أقسامنا الطبية</div>
        <h2>اكتشف أقسام المستشفى</h2>
        <p>أقسام طبية متخصصة تغطي كافة احتياجاتك الصحية</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem">
@foreach($departments as $dept)
        <a href="{{ route('departments.show', $dept) }}" class="dept-card" style="text-decoration:none">
            <div class="dept-icon">
                <i class="fa-solid fa-{{ $dept->icon ?? 'hospital' }}"></i>
            </div>
            <h3 style="font-size:.95rem;font-weight:800;margin-bottom:.3rem">{{ $dept->name }}</h3>
            <p style="font-size:.8rem;color:var(--muted)">{{ $dept->doctors_count }} دكتور</p>
        </a>
        @endforeach
    </div>
    <div style="text-align:center;margin-top:2.5rem">
        <a href="{{ route('departments') }}" class="btn btn-outline">عرض الكل <i class="fa-solid fa-arrow-left"></i></a>
    </div>
</div>
</section>

{{-- DOCTORS --}}
<section class="section">
<div class="container">
    <div class="sec-head">
        <div class="sec-tag">فريقنا الطبي</div>
        <h2>نخبة من الأطباء المتخصصين</h2>
        <p>أفضل الكوادر الطبية في مختلف التخصصات</p>
    </div>
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
            </div>
            <div class="doc-card-footer">
                <span class="stars">★★★★★</span>
                <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary btn-sm">احجز</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="text-align:center;margin-top:2.5rem">
        <a href="{{ route('doctors.index') }}" class="btn btn-outline">جميع الدكاترة <i class="fa-solid fa-arrow-left"></i></a>
    </div>
</div>
</section>

{{-- WHY US --}}
<section class="section" style="background:#fff">
<div class="container">
<div class="why-grid">
    <div>
        <div class="sec-tag">لماذا تختارنا؟</div>
        <h2 style="font-size:2rem;font-weight:900;margin:.75rem 0 1.5rem">أسباب تجعلنا<br>الخيار الأمثل</h2>
        <div class="why-list">
            @foreach([
                ['fa-user-doctor','أطباء متميزون','نخبة من أفضل الأطباء المتخصصين ذوي الخبرة العالية'],
                ['fa-microscope','تقنيات حديثة','أحدث الأجهزة الطبية والتقنيات التشخيصية المتطورة'],
                ['fa-clock','خدمة متواصلة','طوارئ وخدمات طبية متاحة على مدار الساعة طوال الأسبوع'],
                ['fa-heart','رعاية شاملة','رعاية طبية متكاملة تشمل التشخيص والعلاج والمتابعة'],
            ] as [$icon,$title,$desc])
            <div class="why-item">
                <div class="why-check"><i class="fa-solid fa-{{ $icon }}"></i></div>
                <div><h4>{{ $title }}</h4><p>{{ $desc }}</p></div>
            </div>
            @endforeach
        </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
        @foreach([['si-blue','fa-user-doctor','20+','سنة خبرة'],['si-cyan','fa-hospital','10+','أقسام طبية'],['si-green','fa-smile','5K+','مريض راضٍ'],['si-purple','fa-award','50+','جائزة طبية']] as [$cls,$icon,$num,$lbl])
        <div class="stat-card" style="flex-direction:column;align-items:center;text-align:center;padding:2rem 1rem">
            <div class="stat-icon {{ $cls }}" style="margin-bottom:.75rem"><i class="fa-solid {{ $icon }}"></i></div>
            <div class="stat-num">{{ $num }}</div>
            <div class="stat-lbl">{{ $lbl }}</div>
        </div>
        @endforeach
    </div>
</div>
</div>
</section>

{{-- CTA --}}
<section class="cta-section">
<div class="container" style="position:relative;z-index:1">
    <div style="font-size:.82rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;opacity:.8;margin-bottom:.75rem">ابدأ رحلتك الصحية</div>
    <h2 style="font-size:2.2rem;font-weight:900;margin-bottom:1rem">لا تؤجل صحتك!</h2>
    <p style="opacity:.9;max-width:480px;margin:0 auto 2.5rem;font-size:1.05rem">احجز موعدك الآن مع أفضل الأطباء المتخصصين في دقائق معدودة.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
        <a href="{{ route('doctors.index') }}" class="btn btn-white">
            <i class="fa-solid fa-calendar-plus"></i> احجز موعداً
        </a>
        <a href="{{ route('contact') }}" class="btn" style="background:rgba(255,255,255,.15);color:#fff;border:2px solid rgba(255,255,255,.4)">
            <i class="fa-solid fa-phone"></i> تواصل معنا
        </a>
    </div>
</div>
</section>

@endsection