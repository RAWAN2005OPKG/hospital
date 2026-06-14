@extends('layouts.app')
@section('title', 'حجز موعد جديد')

@section('content')
<div class="section-head" style="margin-top: 100px;">
    <span class="sec-tag">المواعيد</span>
    <h2>احجز موعدك الآن</h2>
    <p>اختر القسم والطبيب المناسب لك وسنقوم بتأكيد موعدك فوراً</p>
</div>

<div class="container">
    <div class="card glass" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">القسم الطبي</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">اختر القسم</option>
                        {{-- سيتم تحميل الأقسام من قاعدة البيانات --}}
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">الطبيب المختص</label>
                    <select name="doctor_id" class="form-control" required>
                        <option value="">اختر الطبيب</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">تاريخ الموعد</label>
                    <input type="date" name="appointment_date" class="form-control" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">الوقت المفضل</label>
                    <input type="time" name="appointment_time" class="form-control" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">سبب الزيارة (اختياري)</label>
                <textarea name="reason" class="form-control" rows="4" placeholder="اكتب باختصار سبب زيارتك للطبيب..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                <i class="fa-solid fa-calendar-check"></i> تأكيد الحجز
            </button>
        </form>
    </div>
</div>
@endsection
