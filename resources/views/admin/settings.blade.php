@extends('layouts.app')

@section('title', 'إعدادات النظام')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إعدادات النظام</h1>
        <p class="page-subtitle">تخصيص معلومات المستشفى وإعدادات الموقع العامة</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
        <!-- Hospital Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-hospital-user" style="color: var(--primary); margin-left: 0.5rem;"></i> معلومات المستشفى</h3>
            </div>
            
            <div class="form-group">
                <label class="form-label">اسم الموقع / المستشفى</label>
                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name ?? 'مستشفى صحتي') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">البريد الإلكتروني الرسمي</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email ?? 'info@sehhaty.com') }}">
            </div>

            <div class="form-group">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone ?? '+970 590000000') }}">
            </div>

            <div class="form-group">
                <label class="form-label">شعار المستشفى</label>
                <div style="display: flex; align-items: center; gap: 1.5rem; background: var(--bg-body); padding: 1rem; border-radius: 12px; border: 1px dashed var(--border-color);">
                    @if(isset($settings->logo))
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" style="height: 60px; border-radius: 8px; box-shadow: var(--shadow);">
                    @else
                        <div style="width: 60px; height: 60px; background: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                            <i class="fa-solid fa-image fa-2x"></i>
                        </div>
                    @endif
                    <div style="flex: 1;">
                        <input type="file" name="logo" class="form-control" style="padding: 0.4rem; font-size: 0.85rem;">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">يُفضل استخدام صورة بصيغة PNG وبخلفية شفافة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social & Security -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-shield-halved" style="color: var(--success); margin-left: 0.5rem;"></i> الإعدادات العامة والأمان</h3>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-brands fa-facebook" style="color: #1877F2;"></i> فيسبوك</label>
                <input type="url" name="social_links[facebook]" class="form-control" value="{{ old('social_links.facebook', $settings->social_links['facebook'] ?? '') }}" placeholder="https://facebook.com/...">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-brands fa-twitter" style="color: #1DA1F2;"></i> تويتر (X )</label>
                <input type="url" name="social_links[twitter]" class="form-control" value="{{ old('social_links.twitter', $settings->social_links['twitter'] ?? '') }}" placeholder="https://twitter.com/...">
            </div>

            <div class="form-group">
                <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                    وضع الصيانة
                    <div class="switch-container">
                        <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" {{ (isset($settings->maintenance_mode ) && $settings->maintenance_mode) ? 'checked' : '' }} style="display: none;">
                        <label for="maintenance_mode" class="switch-label"></label>
                    </div>
                </label>
                <p style="font-size: 0.85rem; color: var(--text-muted);">عند تفعيل هذا الوضع، سيتم إغلاق الموقع أمام الزوار العاديين.</p>
            </div>

            <div style="margin-top: 2rem; padding: 1.5rem; background: var(--primary-light); border-radius: 16px; border: 1px solid rgba(37, 99, 235, 0.1);">
                <h4 style="font-weight: 800; color: var(--primary); margin-bottom: 0.5rem; font-size: 1rem;">حفظ التغييرات</h4>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">تأكد من مراجعة كافة البيانات قبل الحفظ، سيتم تطبيق التغييرات فوراً.</p>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-save"></i> حفظ كافة الإعدادات
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    .switch-label {
        width: 50px; height: 26px; background: #e2e8f0; border-radius: 50px; position: relative; cursor: pointer; transition: 0.3s; display: block;
    }
    .switch-label::after {
        content: ''; width: 20px; height: 20px; background: #fff; border-radius: 50%; position: absolute; top: 3px; right: 3px; transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    input:checked + .switch-label { background: var(--success); }
    input:checked + .switch-label::after { transform: translateX(-24px); }
</style>
@endsection
