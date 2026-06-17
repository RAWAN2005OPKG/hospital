@extends('layouts.app')

@section('title', 'إضافة طبيب جديد')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إضافة طبيب جديد</h1>
        <p class="page-subtitle">إدخال بيانات الطبيب الجديد وربطه بالقسم والتخصص المناسب</p>
    </div>
    <a href="{{ route('admin.doctors') }}" class="btn btn-light">
        <i class="fa-solid fa-arrow-right"></i> العودة للقائمة
    </a>
</div>

<form action="{{ route('admin.doctors.store') }}" method="POST">
    @csrf
    <div class="grid-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المعلومات الشخصية والمهنية</h3>
            </div>
            
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">اسم الطبيب الكامل</label>
                    <input type="text" name="name" class="form-control" placeholder="مثال: د. أحمد محمد" required>
                </div>
                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" placeholder="doctor@example.com" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" placeholder="0590000000">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">القسم</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">اختر القسم...</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">التخصص</label>
                    <select name="specialization_id" class="form-control" required>
                        <option value="">اختر التخصص...</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">تفاصيل إضافية</h3>
            </div>

            <div class="form-group">
                <label class="form-label">سنوات الخبرة</label>
                <input type="number" name="experience_years" class="form-control" value="0" min="0">
            </div>

            <div class="form-group">
                <label class="form-label">السيرة الذاتية / نبذة مختصرة</label>
                <textarea name="bio" class="form-control" placeholder="اكتب نبذة عن الطبيب وخبراته..." rows="5"></textarea>
            </div>

            <div style="margin-top: 2rem; padding: 1.5rem; background: var(--primary-light); border-radius: 16px;">
                <p style="font-size: 0.85rem; color: var(--primary); font-weight: 700; margin-bottom: 1rem;">
                    <i class="fa-solid fa-info-circle"></i> سيتم إنشاء حساب مستخدم للطبيب تلقائياً عند الحفظ.
                </p>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-save"></i> حفظ بيانات الطبيب
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
