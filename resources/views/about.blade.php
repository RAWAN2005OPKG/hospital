@extends('layouts.app')

@section('title', 'من نحن - مستشفى صحتي')

@section('content')
<!-- Hero Section -->
<div class="page-header" style="padding: 6rem 0;">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 900;">قصتنا ورسالتنا</h1>
        <p style="font-size: 1.2rem; opacity: .9; max-width: 700px; margin: 1rem auto;">نحن هنا لنقدم لك ولعائلتك أرقى مستويات الرعاية الصحية باستخدام أحدث التقنيات العالمية وبلمسة إنسانية حانية.</p>
    </div>
</div>

<div class="container section">
    <!-- About Section -->
    <div class="grid-2 mb-16" style="align-items: center; gap: 4rem;">
        <div style="position: relative;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: var(--blue-lt); border-radius: 20px; z-index: -1;"></div>
            <img src="/hospital_building_modern_1776935357941.png" alt="صحتي Building" style="width: 100%; border-radius: 30px; shadow: var(--shadow-lg); border: 8px solid #fff;">
            <div style="position: absolute; bottom: 30px; left: -30px; background: #fff; padding: 1.5rem; border-radius: 20px; box-shadow: var(--shadow-lg); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--blue); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <div style="font-weight: 900; font-size: 1.1rem;">20+ عاماً</div>
                    <div style="font-size: .85rem; color: var(--muted);">من التميز الطبي</div>
                </div>
            </div>
        </div>
        <div>
            <span class="badge badge-blue" style="margin-bottom: 1rem; padding: .5rem 1.2rem;">نبذة عن المستشفى</span>
            <h2 style="font-size: 2.5rem; font-weight: 900; color: var(--text); line-height: 1.2; margin-bottom: 1.5rem;">نحن نعيد تعريف مفهوم الرعاية الصحية في المنطقة</h2>
            <p style="font-size: 1.1rem; color: var(--muted); margin-bottom: 1.5rem; line-height: 1.8;">
                بدأت رحلتنا في صحتي بهدف بسيط ولكنه طموح: تقديم خدمات طبية تضاهي المعايير العالمية وتكون في متناول الجميع. اليوم، نفخر بأن نكون الوجهة الأولى للعائلات الباحثة عن الثقة والخبرة.
            </p>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: .75rem; font-weight: 700;">
                    <i class="fa-solid fa-circle-check" style="color: var(--cyan);"></i>
                    أحدث المعدات والتقنيات الطبية العالمية.
                </div>
                <div style="display: flex; align-items: center; gap: .75rem; font-weight: 700;">
                    <i class="fa-solid fa-circle-check" style="color: var(--cyan);"></i>
                    نخبة من الأطباء والاستشاريين المتخصصين.
                </div>
                <div style="display: flex; align-items: center; gap: .75rem; font-weight: 700;">
                    <i class="fa-solid fa-circle-check" style="color: var(--cyan);"></i>
                    بيئة آمنة ومريحة تركز على راحة المريض.
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid-4 mb-16">
        <div class="card" style="text-align: center; padding: 2.5rem;">
            <div style="font-size: 3rem; font-weight: 900; color: var(--blue); margin-bottom: .5rem;">500+</div>
            <div style="font-weight: 700; color: var(--text);">طبيب متخصص</div>
        </div>
        <div class="card" style="text-align: center; padding: 2.5rem;">
            <div style="font-size: 3rem; font-weight: 900; color: var(--cyan); margin-bottom: .5rem;">15k+</div>
            <div style="font-weight: 700; color: var(--text);">عملية ناجحة</div>
        </div>
        <div class="card" style="text-align: center; padding: 2.5rem;">
            <div style="font-size: 3rem; font-weight: 900; color: #10b981; margin-bottom: .5rem;">100k+</div>
            <div style="font-weight: 700; color: var(--text);">مريض سعيد</div>
        </div>
        <div class="card" style="text-align: center; padding: 2.5rem;">
            <div style="font-size: 3rem; font-weight: 900; color: #f59e0b; margin-bottom: .5rem;">25+</div>
            <div style="font-weight: 700; color: var(--text);">قسم طبي متطور</div>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div class="grid-3 mb-16">
        <div class="card" style="padding: 2.5rem; transition: all .3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.borderColor='var(--blue)';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--border)';">
            <div class="stat-icon si-blue" style="margin-bottom: 1.5rem; width: 70px; height: 70px; font-size: 2rem;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">رؤيتنا</h3>
            <p style="color: var(--muted); line-height: 1.7;">أن نصبح المركز الطبي الرائد إقليمياً، والمعروف بابتكاراته في رعاية المرضى والتميز في النتائج الطبية.</p>
        </div>
        <div class="card" style="padding: 2.5rem; transition: all .3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.borderColor='var(--cyan)';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--border)';">
            <div class="stat-icon si-cyan" style="margin-bottom: 1.5rem; width: 70px; height: 70px; font-size: 2rem;">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">رسالتنا</h3>
            <p style="color: var(--muted); line-height: 1.7;">توفير رعاية صحية آمنة وعالية الجودة تركز على المريض، باستخدام التكنولوجيا المتقدمة وبأعلى المعايير الأخلاقية.</p>
        </div>
        <div class="card" style="padding: 2.5rem; transition: all .3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.borderColor='#10b981';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--border)';">
            <div class="stat-icon si-green" style="margin-bottom: 1.5rem; width: 70px; height: 70px; font-size: 2rem;">
                <i class="fa-solid fa-heart"></i>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">قيمنا</h3>
            <p style="color: var(--muted); line-height: 1.7;">النزاهة، الاحترام، العمل بروح الفريق، والالتزام المستمر بالتحسين والتعلم والتعاطف مع كل مريض.</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div style="background: linear-gradient(135deg, var(--blue), var(--cyan)); border-radius: 30px; padding: 4rem; text-align: center; color: #fff; box-shadow: var(--shadow-lg);">
        <h2 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">هل أنت مستعد لتجربة رعاية صحية أفضل؟</h2>
        <p style="font-size: 1.1rem; opacity: .9; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">احجز موعدك الآن مع أحد استشاريينا المتميزين وابدأ رحلتك نحو صحة أفضل.</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('doctors.index') }}" class="btn btn-white" style="padding: 1rem 2.5rem; font-size: 1.1rem;">احجز موعداً</a>
            <a href="{{ route('contact') }}" class="btn btn-outline" style="padding: 1rem 2.5rem; font-size: 1.1rem; border-color: #fff; color: #fff;">تواصل معنا</a>
        </div>
    </div>
</div>
@endsection