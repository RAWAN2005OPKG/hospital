@extends('layouts.app')
@section('title', 'الاستشارات الطبية')

@push('styles')
<style>
.consult-page { background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); min-height: 80vh; padding: 2rem 0 4rem; }
.consult-hero { text-align: center; margin-bottom: 2.5rem; }
.consult-hero h1 { font-size: 2.5rem; font-weight: 900; color: #111827; }
.consult-hero p { color: #6b7280; font-size: 1.1rem; max-width: 600px; margin: 0.5rem auto 0; }
.consult-tag { display: inline-block; padding: 0.4rem 1.2rem; background: #e0f4ff; color: #0077B6; border-radius: 50px; font-weight: 700; font-size: 0.85rem; }
.doctor-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; margin-top: 2rem; }
.doc-card { background: #fff; border-radius: 1rem; padding: 1.5rem; border: 1px solid #e5e7eb; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
.doc-avatar { width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem; margin: 0 auto 0.75rem; }
.ai-box { background: #fff; border-radius: 1.25rem; padding: 2rem; border: 1px solid #e5e7eb; margin-top: 2rem; text-align: center; }
</style>
@endpush

@section('content')
<div class="consult-page">
    <div class="container">
        <div class="consult-hero">
            <span class="consult-tag">الاستشارات الطبية</span>
            <h1>استشارات طبية عن بعد</h1>
            <p>تواصل مع نخبة من الأطباء من منزلك وبكل خصوصية</p>
        </div>

        <h3 style="font-weight:800;margin-bottom:0.5rem;"><i class="fas fa-user-doctor" style="color:#06b6d4;"></i> أطباء متاحون للاستشارة</h3>
        <div class="doctor-grid">
            @foreach($doctors as $doc)
            <div class="doc-card">
                <div class="doc-avatar">{{ mb_substr($doc->user->name, 0, 1) }}</div>
                <div style="font-weight:700;">د. {{ $doc->user->name }}</div>
                <div style="font-size:0.85rem;color:#06b6d4;margin:0.25rem 0 1rem;">{{ $doc->specialization->name ?? 'طبيب عام' }}</div>
                @auth
                    @if(auth()->user()->isPatient())
                    <a href="{{ route('patient.chat.show', $doc->user_id) }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-comment-medical"></i> بدء استشارة
                    </a>
                    @else
                    <a href="{{ route('doctors.show', $doc) }}" class="btn btn-outline-primary btn-sm w-100">عرض الملف</a>
                    @endif
                @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-sign-in-alt"></i> سجّل دخولك للاستشارة
                </a>
                @endauth
            </div>
            @endforeach
        </div>

        <div class="ai-box">
            <i class="fa-solid fa-robot" style="font-size:2.5rem;color:#06b6d4;margin-bottom:1rem;"></i>
            <h3 style="font-weight:700;">مساعدك الطبي الذكي</h3>
            <p style="color:#6b7280;margin:0.5rem 0 1rem;">للحصول على استشارة مباشرة مع طبيب، سجّل دخولك كمريض واختر الطبيب المناسب</p>
            <a href="{{ auth()->check() ? route('patient.ai.symptoms') : route('login') }}" class="btn btn-outline-primary">تحليل الأعراض بالذكاء الاصطناعي</a>
        </div>
    </div>
</div>
@endsection
