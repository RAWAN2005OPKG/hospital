@extends('layouts.app')

@section('title', 'إضافة طبيب جديد')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إضافة طبيب جديد</h1>
        <p class="page-subtitle">إنشاء حساب جديد لطبيب وتعيينه لقسم وتخصص معين</p>
    </div>
    <a href="{{ route('admin.doctors') }}" class="btn" style="background: var(--gray-200); color: var(--gray-700);">
        <i class="fa-solid fa-arrow-right"></i> العودة للقائمة
    </a>
</div>

<form action="{{ route('admin.doctors.store') }}" method="POST">
    @csrf
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المعلومات الشخصية والمهنية</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" placeholder="د. خالد محمد" required>
                </div>
                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" placeholder="doctor@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" placeholder="0590000000">
                </div>
                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
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

            <div class="form-group">
                <label class="form-label">السيرة الذاتية / نبذة</label>
                <textarea name="bio" class="form-control" rows="4" placeholder="اكتب نبذة قصيرة عن الطبيب وخبراته..."></textarea>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تفاصيل إضافية</h3>
                </div>
                <div class="form-group">
                    <label class="form-label">سنوات الخبرة</label>
                    <input type="number" name="experience_years" class="form-control" value="0" min="0">
                </div>
                <div style="background: rgba(0, 102, 204, 0.05); padding: 1rem; border-radius: 12px; border: 1px dashed var(--primary);">
                    <p style="font-size: 0.8rem; color: var(--primary); font-weight: 700; line-height: 1.4;">
                        <i class="fa-solid fa-circle-info"></i> سيتم إنشاء حساب مستخدم للطبيب تلقائياً وسيتمكن من تسجيل الدخول باستخدام البريد الإلكتروني وكلمة المرور المحددة.
                    </p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                <i class="fa-solid fa-save"></i> حفظ بيانات الطبيب
            </button>
        </div>
    </div>
</form>
@endsection
