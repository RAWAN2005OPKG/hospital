@extends('layouts.app')

@section('title', 'حجز موعد - صحتي')

@section('content')
<div class="section">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">حجز موعد طبي</h1>
                <p style="color: var(--muted);">اختر الطبيب والتاريخ والوقت المناسب لك</p>
            </div>
            
            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                <form method="POST" action="{{ route('appointments.store') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @csrf
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--gray-700);">اختر التخصص</label>
                        <select id="specialization" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem;" class="@error('specialization_id') border-red-500 @enderror">
                            <option value="">-- اختر التخصص --</option>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--gray-700);">اختر الطبيب</label>
                        <select name="doctor_id" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem;" class="@error('doctor_id') border-red-500 @enderror">
                            <option value="">-- اختر الطبيب --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                                    د. {{ $doc->user->name }} - {{ $doc->specialization->name ?? 'تخصص' }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--gray-700);">تاريخ الموعد</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem;" class="@error('appointment_date') border-red-500 @enderror">
                        @error('appointment_date')
                            <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--gray-700);">وقت الموعد</label>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem;" class="@error('appointment_time') border-red-500 @enderror">
                        @error('appointment_time')
                            <p style="color: var(--red); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--gray-700);">ملاحظات (اختياري)</label>
                        <textarea name="notes" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 1rem; min-height: 120px; resize: vertical;" placeholder="أضف أي ملاحظات أو أعراض تود إخبار الطبيب بها">{{ old('notes') }}</textarea>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.85rem;">
                            <i class="fa-solid fa-check"></i> تأكيد الحجز
                        </button>
                        <a href="{{ route('patient.dashboard') }}" class="btn btn-outline" style="flex: 1; padding: 0.85rem; text-align: center;">
                            <i class="fa-solid fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection