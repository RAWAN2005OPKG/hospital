{{-- contact.blade.php --}}
@extends('layouts.app')
@section('title','تواصل معنا')
@section('content')
<div class="page-header">
    <div class="container"><h1>تواصل معنا</h1><p>نحن هنا للإجابة على جميع استفساراتك</p></div>
</div>
<section class="section-sm"><div class="container">
<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:2.5rem;align-items:start">
    <div>
        @foreach([['fa-location-dot','العنوان','=غزة الشفاء'],['fa-phone','الهاتف','02-2345678'],['fa-envelope','البريد','info@صحتي.com'],['fa-clock','ساعات العمل','السبت — الخميس: 8ص — 8م']] as [$icon,$title,$val])
        <div class="card" style="margin-bottom:1rem">
            <div class="card-body" style="display:flex;align-items:center;gap:1rem;padding:1.25rem">
                <div style="width:48px;height:48px;border-radius:12px;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
                <div>
                    <div style="font-weight:700;font-size:.88rem">{{ $title }}</div>
                    <div style="font-size:.85rem;color:var(--muted)">{{ $val }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="card">
        <div class="card-header"><span><i class="fa-solid fa-paper-plane" style="color:var(--blue);margin-left:.4rem"></i>أرسل رسالة</span></div>
        <div class="card-body">
        <form method="POST" action="{{ route('contact.store') }}">@csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label class="form-label">الاسم *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">الموضوع *</label>
            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">الرسالة *</label>
            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.8rem">
            <i class="fa-solid fa-paper-plane"></i> إرسال الرسالة
        </button>
        </form>
        </div>
    </div>
</div>
</div></section>
@endsection