@extends('layouts.app')
@section('title','تفاصيل الموعد')
@section('content')

<div class="page-header">
    <div>
        <div class="breadcrumb"><a href="{{ route('doctor.dashboard') }}">لوحتي</a> <i class="fa-solid fa-chevron-left fa-xs"></i> تفاصيل الموعد</div>
        <h1 class="page-title">تفاصيل الموعد</h1>
    </div>
</div>

<section class="section-sm">
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

    {{-- APPOINTMENT INFO --}}
    <div>
        <div class="card">
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
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                        <i class="fa-solid fa-check"></i> تأكيد الموعد
                    </button>
                </form>
                <form method="POST" action="{{ route('doctor.cancel-appointment',$appointment) }}" style="flex:1" onsubmit="return confirm('إلغاء هذا الموعد؟')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn" style="width:100%;justify-content:center;background:var(--danger);color:#fff">
                        <i class="fa-solid fa-xmark"></i> إلغاء
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- EXISTING RECORD --}}
        @if($appointment->medicalRecord)
        <div class="card">
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
                    rows="3" required placeholder="اكتب العلاج الموصوف...">{{ old('treatment') }}</textarea>
                @error('treatment')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="form-group" style="background:#f8fafc;padding:1.5rem;border-radius:12px;border:1px solid #e2e8f0;margin-bottom:1.5rem">
                <label class="form-label" style="font-size:1.1rem;color:#1e293b;border-bottom:2px solid #e2e8f0;padding-bottom:0.5rem;margin-bottom:1rem">
                    <i class="fa-solid fa-pills" style="color:#3b82f6;margin-left:0.5rem"></i> الوصفة الطبية (الصيدلية)
                </label>
                <div id="medicines-container">
                    <!-- Medicines rows will be added here -->
                </div>
                <button type="button" onclick="addMedicineRow()" class="btn btn-outline" style="margin-top:1rem;font-size:0.9rem">
                    <i class="fa-solid fa-plus"></i> إضافة دواء للوصفة
                </button>
            </div>

            <div class="form-group">
                <label class="form-label">ملاحظات إضافية</label>
                <textarea name="notes" class="form-control" rows="2"
                    placeholder="أي ملاحظات إضافية للتقرير..."></textarea>
            </div>
            <div style="background:#fff3cd;border-radius:10px;padding:.8rem 1rem;margin-bottom:1.25rem;font-size:.83rem;color:#856404;display:flex;gap:.5rem">
                <i class="fa-solid fa-triangle-exclamation" style="flex-shrink:0;margin-top:.1rem"></i>
                <span>بإضافة السجل والوصفة سيتم تغيير حالة الموعد إلى <strong>مكتمل</strong> وتُرسل الوصفة للصيدلية.</span>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.8rem">
                <i class="fa-solid fa-floppy-disk"></i> حفظ وإكمال الموعد
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
                    row.style.cssText = 'display:grid;grid-template-columns:2fr 1fr 1fr 2fr auto;gap:0.75rem;margin-bottom:1rem;align-items:end;background:#fff;padding:1rem;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.02)';
                    row.innerHTML = `
                        <div>
                            <label style="font-size:0.8rem;color:#64748b;margin-bottom:0.25rem;display:block">الدواء</label>
                            <select name="medicines[${medIndex}][id]" class="form-control" required style="padding:0.6rem">
                                ${options}
                            </select>
                        </div>
                        <div>
                            <label style="font-size:0.8rem;color:#64748b;margin-bottom:0.25rem;display:block">الجرعة</label>
                            <input type="text" name="medicines[${medIndex}][dosage]" class="form-control" required placeholder="مثال: حبة يومياً" style="padding:0.6rem">
                        </div>
                        <div>
                            <label style="font-size:0.8rem;color:#64748b;margin-bottom:0.25rem;display:block">المدة (أيام)</label>
                            <input type="number" name="medicines[${medIndex}][days]" class="form-control" required min="1" value="7" style="padding:0.6rem">
                        </div>
                        <div>
                            <label style="font-size:0.8rem;color:#64748b;margin-bottom:0.25rem;display:block">ملاحظات للصيدلي/المريض</label>
                            <input type="text" name="medicines[${medIndex}][notes]" class="form-control" placeholder="اختياري" style="padding:0.6rem">
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="btn" style="background:#fee2e2;color:#ef4444;padding:0.6rem 1rem;height:100%">
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
    <div style="text-align:center;padding:3rem;color:var(--muted)">
        <i class="fa-solid fa-ban" style="font-size:3rem;margin-bottom:1rem;display:block;opacity:.2"></i>
        الموعد ملغي — لا يمكن إضافة سجل طبي.
    </div>
    @endif

</div>
</section>
@endsection
