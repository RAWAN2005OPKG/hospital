@extends('layouts.app')
@section('title','تفاصيل الموعد')
@section('content')

<div class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="{{ route('doctor.dashboard') }}">لوحتي</a> <i class="fa-solid fa-chevron-left fa-xs"></i> تفاصيل الموعد</div>
        <h1>تفاصيل الموعد</h1>
    </div>
</div>

<section class="section-sm"><div class="container">
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

    {{-- APPOINTMENT INFO --}}
    <div>
        <div class="card" style="margin-bottom:1.25rem">
            <div class="card-header">
                <span><i class="fa-solid fa-calendar-check" style="color:var(--blue);margin-left:.4rem"></i>معلومات الموعد</span>
                <span class="badge {{ ['pending'=>'badge-yellow','confirmed'=>'badge-blue','completed'=>'badge-green','cancelled'=>'badge-red'][$appointment->status] ?? 'badge-gray' }}">
                    {{ ['pending'=>'قيد الانتظار','confirmed'=>'مؤكد','completed'=>'مكتمل','cancelled'=>'ملغي'][$appointment->status] ?? $appointment->status }}
                </span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                    @foreach([['المريض',$appointment->patient->name??'-'],['التاريخ',$appointment->appointment_date->format('d/m/Y')],['الوقت',$appointment->appointment_time],['السبب',$appointment->reason??'—']] as [$lbl,$val])
                    <div style="background:var(--bg);border-radius:10px;padding:.9rem">
                        <div style="font-size:.73rem;color:var(--muted);margin-bottom:.2rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em">{{ $lbl }}</div>
                        <div style="font-weight:700;font-size:.9rem">{{ $val }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        @if($appointment->status === 'pending')
        <div class="card">
            <div class="card-header" style="font-size:.88rem">إجراءات سريعة</div>
            <div class="card-body" style="display:flex;gap:.75rem">
                <form method="POST" action="{{ route('doctor.confirm-appointment',$appointment) }}" style="flex:1">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                        <i class="fa-solid fa-check"></i> تأكيد الموعد
                    </button>
                </form>
                <form method="POST" action="{{ route('doctor.cancel-appointment',$appointment) }}" style="flex:1" onsubmit="return confirm('إلغاء هذا الموعد؟')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center">
                        <i class="fa-solid fa-xmark"></i> إلغاء
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- EXISTING RECORD --}}
        @if($appointment->medicalRecord)
        <div class="card" style="margin-top:1.25rem">
            <div class="card-header">
                <span><i class="fa-solid fa-file-medical" style="color:#059669;margin-left:.4rem"></i>السجل الطبي</span>
                <span class="badge badge-green">مُضاف</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">التشخيص</label>
                    <div style="background:var(--bg);border-radius:9px;padding:.85rem;font-size:.88rem">{{ $appointment->medicalRecord->diagnosis }}</div>
                </div>
                <div class="form-group">
                    <label class="form-label">العلاج</label>
                    <div style="background:var(--bg);border-radius:9px;padding:.85rem;font-size:.88rem">{{ $appointment->medicalRecord->treatment }}</div>
                </div>
                @if($appointment->medicalRecord->notes)
                <div class="form-group">
                    <label class="form-label">ملاحظات</label>
                    <div style="background:var(--bg);border-radius:9px;padding:.85rem;font-size:.88rem">{{ $appointment->medicalRecord->notes }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- ADD MEDICAL RECORD --}}
    @if($appointment->status !== 'cancelled' && !$appointment->medicalRecord)
    <div class="card">
        <div class="card-header">
            <span><i class="fa-solid fa-plus" style="color:var(--blue);margin-left:.4rem"></i>إضافة سجل طبي</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('doctor.add-medical-record',$appointment) }}">
            @csrf
            <div class="form-group">
                <label class="form-label">التشخيص <span style="color:#ef4444">*</span></label>
                <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror"
                    rows="3" required placeholder="اكتب التشخيص الطبي...">{{ old('diagnosis') }}</textarea>
                @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">العلاج الموصوف <span style="color:#ef4444">*</span></label>
                <textarea name="treatment" class="form-control @error('treatment') is-invalid @enderror"
                    rows="3" required placeholder="اكتب العلاج والأدوية الموصوفة...">{{ old('treatment') }}</textarea>
                @error('treatment')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">ملاحظات إضافية</label>
                <textarea name="notes" class="form-control" rows="2"
                    placeholder="أي ملاحظات إضافية...">{{ old('notes') }}</textarea>
            </div>
            <div style="background:#fff3cd;border-radius:10px;padding:.8rem 1rem;margin-bottom:1.25rem;font-size:.83rem;color:#856404;display:flex;gap:.5rem">
                <i class="fa-solid fa-triangle-exclamation" style="flex-shrink:0;margin-top:.1rem"></i>
                <span>بإضافة السجل الطبي سيتم تغيير حالة الموعد إلى <strong>مكتمل</strong> تلقائياً.</span>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%;justify-content:center;padding:.8rem">
                <i class="fa-solid fa-floppy-disk"></i> حفظ السجل الطبي
            </button>
            </form>
        </div>
    </div>
    @elseif($appointment->status === 'cancelled')
    <div style="text-align:center;padding:3rem;color:var(--muted)">
        <i class="fa-solid fa-ban" style="font-size:3rem;margin-bottom:1rem;display:block;opacity:.2"></i>
        الموعد ملغي — لا يمكن إضافة سجل طبي.
    </div>
    @endif

</div>
</div></section>
@endsection