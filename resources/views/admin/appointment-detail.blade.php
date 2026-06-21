@extends('layouts.app')
@section('title','تفاصيل الموعد')

@push('styles')
<style>
    .appointment-detail-container {
        padding: 2rem 0;
    }
    .detail-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .detail-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .detail-card-header span:first-child {
        color: #fff;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
    }
    .detail-card-header span:first-child i {
        margin-left: 0.5rem;
    }
    .detail-card-body {
        padding: 1.5rem;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .info-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    .info-item:hover {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }
    .info-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .info-value {
        font-weight: 700;
        font-size: 1rem;
        color: #1e293b;
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    .record-value {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1rem;
        font-size: 0.95rem;
        color: #374151;
        line-height: 1.6;
        border: 1px solid #e2e8f0;
    }
    .warning-box {
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        color: #92400e;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }
    .warning-box i {
        flex-shrink: 0;
        margin-top: 0.15rem;
    }
</style>
@endpush

@section('content')

<div class="appointment-detail-container container">
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('doctor.dashboard') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
                    <i class="fa-solid fa-home"></i> لوحتي
                </a>
                <i class="fa-solid fa-chevron-left fa-xs" style="margin: 0 0.5rem; color: #94a3b8;"></i>
                <span style="color: #64748b;">تفاصيل الموعد</span>
            </div>
            <h1 class="page-title" style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0.5rem 0;">
                <i class="fa-solid fa-calendar-check" style="color: #667eea; margin-left: 0.5rem;"></i>
                تفاصيل الموعد
            </h1>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">

        {{-- APPOINTMENT INFO --}}
        <div>
            <div class="detail-card">
                <div class="detail-card-header">
                    <span>
                        <i class="fa-solid fa-calendar-check"></i>
                        معلومات الموعد
                    </span>
                    <span class="status-badge status-{{ $appointment->status }}">
                        {{ ['pending'=>'قيد الانتظار','confirmed'=>'مؤكد','completed'=>'مكتمل','cancelled'=>'ملغي'][$appointment->status] ?? $appointment->status }}
                    </span>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">
                        @foreach([['المريض',$appointment->patient->name??'-'],['التاريخ',$appointment->appointment_date->format('d/m/Y')],['الوقت',$appointment->appointment_time],['السبب',$appointment->reason??'—']] as [$lbl,$val])
                        <div class="info-item">
                            <div class="info-label">{{ $lbl }}</div>
                            <div class="info-value">{{ $val }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            @if($appointment->status === 'pending')
            <div class="detail-card">
                <div class="detail-card-body">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">إجراءات سريعة</h3>
                    <div style="display: flex; gap: 0.75rem;">
                        <form method="POST" action="{{ route('doctor.confirm-appointment',$appointment) }}" style="flex: 1;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn" style="width: 100%; justify-content: center; padding: 0.75rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                                <i class="fa-solid fa-check" style="margin-left: 0.5rem;"></i> تأكيد الموعد
                            </button>
                        </form>
                        <form method="POST" action="{{ route('doctor.cancel-appointment',$appointment) }}" style="flex: 1;" onsubmit="return confirm('إلغاء هذا الموعد؟')">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn" style="width: 100%; justify-content: center; padding: 0.75rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                                <i class="fa-solid fa-xmark" style="margin-left: 0.5rem;"></i> إلغاء
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- EXISTING RECORD --}}
            @if($appointment->medicalRecord)
            <div class="detail-card">
                <div class="detail-card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <span>
                        <i class="fa-solid fa-file-medical"></i>
                        السجل الطبي
                    </span>
                    <span class="status-badge status-completed">مُضاف</span>
                </div>
                <div class="detail-card-body">
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label class="form-label" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">التشخيص</label>
                        <div class="record-value">{{ $appointment->medicalRecord->diagnosis }}</div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label class="form-label" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">العلاج</label>
                        <div class="record-value">{{ $appointment->medicalRecord->treatment }}</div>
                    </div>
                    @if($appointment->medicalRecord->notes)
                    <div class="form-group">
                        <label class="form-label" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">ملاحظات</label>
                        <div class="record-value">{{ $appointment->medicalRecord->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

    {{-- ADD MEDICAL RECORD --}}
    @if($appointment->status !== 'cancelled' && !$appointment->medicalRecord)
    <div class="detail-card">
        <div class="detail-card-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <span>
                <i class="fa-solid fa-plus"></i>
                إضافة سجل طبي
            </span>
        </div>
        <div class="detail-card-body">
            <form method="POST" action="{{ route('doctor.add-medical-record',$appointment) }}">
            @csrf
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">التشخيص <span style="color: #ef4444;">*</span></label>
                <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror"
                    rows="3" required placeholder="اكتب التشخيص الطبي..." style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">{{ old('diagnosis') }}</textarea>
                @error('diagnosis')<div class="invalid-feedback" style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">العلاج الموصوف <span style="color: #ef4444;">*</span></label>
                <textarea name="treatment" class="form-control @error('treatment') is-invalid @enderror"
                    rows="3" required placeholder="اكتب العلاج الموصوف..." style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">{{ old('treatment') }}</textarea>
                @error('treatment')<div class="invalid-feedback" style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="background: #f0f9ff; padding: 1.5rem; border-radius: 12px; border: 2px solid #bae6fd; margin-bottom: 1.5rem;">
                <label class="form-label" style="font-size: 1.1rem; color: #0369a1; border-bottom: 2px solid #bae6fd; padding-bottom: 0.5rem; margin-bottom: 1rem; display: block; font-weight: 700;">
                    <i class="fa-solid fa-pills" style="margin-left: 0.5rem;"></i> الوصفة الطبية (الصيدلية)
                </label>
                <div id="medicines-container">
                    <!-- Medicines rows will be added here -->
                </div>
                <button type="button" onclick="addMedicineRow()" class="btn" style="margin-top: 1rem; font-size: 0.9rem; padding: 0.6rem 1.25rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                    <i class="fa-solid fa-plus" style="margin-left: 0.5rem;"></i> إضافة دواء للوصفة
                </button>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">ملاحظات إضافية</label>
                <textarea name="notes" class="form-control" rows="2"
                    placeholder="أي ملاحظات إضافية للتقرير..." style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;"></textarea>
            </div>
            <div class="warning-box">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>بإضافة السجل والوصفة سيتم تغيير حالة الموعد إلى <strong>مكتمل</strong> وتُرسل الوصفة للصيدلية.</span>
            </div>
            <button type="submit" class="btn" style="width: 100%; justify-content: center; padding: 0.85rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s;">
                <i class="fa-solid fa-floppy-disk" style="margin-left: 0.5rem;"></i> حفظ وإكمال الموعد
            </button>
            </form>

            <script>
                let medIndex = 0;
                const medicinesList = @json($medicines ?? []);

                function addMedicineRow() {
                    const container = document.getElementById('medicines-container');
                    let options = '<option value="">-- اختر الدواء --</option>';
                    medicinesList.forEach(med => {
                        options += `<option value="${med.id}">${med.name} (${med.stock > 0 ? 'متوفر' : 'نفد'})</option>`;
                    });

                    const row = document.createElement('div');
                    row.className = 'medicine-row';
                    row.style.cssText = 'display: grid; grid-template-columns: 2fr 1fr 1fr 2fr auto; gap: 0.75rem; margin-bottom: 1rem; align-items: end; background: #fff; padding: 1rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0;';
                    row.innerHTML = `
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem; display: block; font-weight: 600;">الدواء</label>
                            <select name="medicines[${medIndex}][id]" class="form-control" required style="padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem;">
                                ${options}
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem; display: block; font-weight: 600;">الجرعة</label>
                            <input type="text" name="medicines[${medIndex}][dosage]" class="form-control" required placeholder="مثال: حبة يومياً" style="padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem;">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem; display: block; font-weight: 600;">المدة (أيام)</label>
                            <input type="number" name="medicines[${medIndex}][days]" class="form-control" required min="1" value="7" style="padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem;">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem; display: block; font-weight: 600;">ملاحظات للصيدلي/المريض</label>
                            <input type="text" name="medicines[${medIndex}][notes]" class="form-control" placeholder="اختياري" style="padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem;">
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="btn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; padding: 0.6rem 1rem; height: 100%; border: none; border-radius: 6px; cursor: pointer; transition: all 0.3s;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    `;
                    container.appendChild(row);
                    medIndex++;
                }
            </script>
        </div>
    </div>
    @elseif($appointment->status === 'cancelled')
    <div style="text-align: center; padding: 3rem; color: #94a3b8; background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;">
        <i class="fa-solid fa-ban" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
        <p style="font-size: 1.1rem; font-weight: 600;">الموعد ملغي — لا يمكن إضافة سجل طبي.</p>
    </div>
    @endif

</div>
@endsection
