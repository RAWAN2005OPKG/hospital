@extends('layouts.app')

@section('title', 'إعدادات النظام')

@section('page-title', 'إعدادات النظام')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إعدادات النظام</h1>
        <p class="page-subtitle">تخصيص معلومات المستشفى، الشعار، وإعدادات التواصل</p>
    </div>
</div>

@if(session('success'))
    <div style="padding: 1rem 1.5rem; background: rgba(16, 185, 129, 0.1); color: var(--success); border-radius: 12px; margin-bottom: 2rem; border-right: 4px solid var(--success); font-weight: 600;">
        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
        <!-- General Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-building"></i> معلومات المستشفى</h3>
            </div>
            <div style="padding-top: 1rem;">
                <div class="form-group">
                    <label class="form-label">اسم المستشفى / الموقع</label>
                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name ?? 'مستشفى صحتي') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني الرسمي</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email ?? 'info@sehhaty.com') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">رقم الهاتف الرسمي</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone ?? '+970 590000000') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">شعار المستشفى</label>
                    <div style="display: flex; align-items: center; gap: 1.5rem; margin-top: 0.5rem;">
                        <div style="width: 80px; height: 80px; border-radius: 12px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px dashed var(--gray-300);">
                            @if(isset($settings->logo))
                                <img src="{{ asset('storage/' . $settings->logo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fa-solid fa-image" style="font-size: 1.5rem; color: var(--gray-400);"></i>
                            @endif
                        </div>
                        <input type="file" name="logo" class="form-control" style="flex: 1;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Social & Advanced Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-share-nodes"></i> التواصل الاجتماعي والحماية</h3>
            </div>
            <div style="padding-top: 1rem;">
                <div class="form-group">
                    <label class="form-label"><i class="fa-brands fa-facebook" style="color: #1877F2;"></i> فيسبوك</label>
                    <input type="url" name="social_links[facebook]" class="form-control" value="{{ old('social_links.facebook', $settings->social_links['facebook'] ?? '') }}" placeholder="https://facebook.com/...">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fa-brands fa-twitter" style="color: #1DA1F2;"></i> تويتر (X)</label>
                    <input type="url" name="social_links[twitter]" class="form-control" value="{{ old('social_links.twitter', $settings->social_links['twitter'] ?? '') }}" placeholder="https://twitter.com/...">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fa-solid fa-shield-halved"></i> وضع الصيانة</label>
                    <div style="display: flex; align-items: center; gap: 1rem; background: var(--gray-50); padding: 1rem; border-radius: 12px; border: 1px solid var(--gray-200);">
                        <label class="switch" style="position: relative; display: inline-block; width: 50px; height: 24px;">
                            <input type="checkbox" name="maintenance_mode" value="1" {{ (isset($settings->maintenance_mode) && $settings->maintenance_mode) ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                            <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;"></span>
                        </label>
                        <span style="font-weight: 600; font-size: 0.9rem;">تفعيل وضع الصيانة (سيمنع وصول المرضى للموقع)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
        <button type="submit" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; border: none; padding: 1rem 3rem; border-radius: 12px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fa-solid fa-save"></i> حفظ الإعدادات
        </button>
    </div>
</form>

<style>
    .switch input:checked + .slider { background-color: var(--primary); }
    .switch input:checked + .slider:before { transform: translateX(26px); }
    .slider:before {
        position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px;
        background-color: white; transition: .4s; border-radius: 50%;
    }
</style>
@endsection
