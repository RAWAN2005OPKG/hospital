@extends('layouts.app')

@section('title', __('mediflow.ai_triage_note'))

@section('content')
<div class="container section" style="max-width: 720px;">
    <div class="card" style="padding: 2rem;">
        <h1 class="text-2xl font-bold mb-2">{{ __('mediflow.general_medicine') }} — AI Triage</h1>
        <p style="color: var(--muted); margin-bottom: 1.5rem;">{{ __('mediflow.ai_triage_note') }}</p>

        <form method="POST" action="{{ route('patient.ai.symptoms.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Symptoms / الأعراض</label>
                <textarea name="symptoms" class="form-control" rows="5" required placeholder="e.g. chest pain / ألم في الصدر...">{{ old('symptoms') }}</textarea>
                @error('symptoms')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ app()->getLocale() === 'ar' ? 'تحليل' : 'Analyze' }}</button>
        </form>

        @isset($result)
            <div class="mt-8 p-4 rounded-xl" style="background: rgba(0, 180, 216, 0.08); border: 1px solid rgba(0, 119, 182, 0.2);">
                <p class="font-bold text-lg mb-2">{{ $result['suggested_department_name'] }}</p>
                <p><span class="badge badge-yellow">{{ $result['urgency_label'] }}</span></p>
                <p class="mt-3 text-sm" style="color: var(--muted);">{{ $result['note'] }}</p>
            </div>
        @endisset
    </div>

    <div class="card mt-6" style="padding: 1.5rem;">
        <h2 class="font-bold mb-2">{{ __('mediflow.ai_slots_message') }}</h2>
        <p class="text-sm" style="color: var(--muted);">GET {{ url('/patient/ai/slot-suggestions') }}?doctor_id=1&date={{ now()->toDateString() }}</p>
    </div>
</div>
@endsection
