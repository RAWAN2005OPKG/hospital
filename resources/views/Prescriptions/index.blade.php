@extends('layouts.app')
@section('title', __('messages.prescriptions_title'))

@push('styles')
<style>
.rx-page { background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 50%, #ecfeff 100%); padding: 2rem 0 4rem; min-height: 80vh; }
.rx-header { background: #fff; border-radius: 1rem; padding: 1.5rem 2rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 2rem; }
.rx-header h1 { font-size: 2rem; font-weight: 900; color: #111827; margin: 0; }
.pharmacy-banner { background: linear-gradient(135deg, #10b981, #059669); color: #fff; border-radius: 1rem; padding: 1.25rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; }
.rx-card { background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; margin-bottom: 2rem; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
.rx-card-head { padding: 1rem 1.5rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; }
.medicine-item { padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; gap: 1rem; align-items: flex-start; }
.medicine-item:last-child { border-bottom: none; }
.med-icon { width: 44px; height: 44px; background: #e0f4ff; color: #0077B6; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.status-pending { background: #fef3c7; color: #b45309; padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; }
.status-delivered, .status-confirmed { background: #d1fae5; color: #047857; padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="rx-page">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="rx-header">
            <div class="d-flex align-items-center gap-3">
                <div style="width:56px;height:56px;background:linear-gradient(135deg,#10b981,#059669);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;">
                    <i class="fas fa-prescription-bottle-medical"></i>
                </div>
                <div>
                    <h1>{{ __('messages.prescriptions_title') }}</h1>
                    <p class="text-muted mb-0">{{ __('messages.prescriptions_subtitle') }}</p>
                </div>
            </div>
        </div>

        <div class="pharmacy-banner">
            <i class="fas fa-pills fa-2x"></i>
            <div>
                <strong>صيدلية المستشفى</strong>
                <div style="font-size:0.9rem;opacity:0.9;">يتم تحضير وصرف الأدوية من قبل الصيدلي المختص بعد تأكيد الطلب</div>
            </div>
            <a href="{{ route('services.pharmacy') }}" class="btn btn-light btn-sm ms-auto">عن الصيدلية</a>
        </div>

        @forelse($prescriptions ?? [] as $presc)
        <div class="rx-card">
            <div class="rx-card-head">
                <div>
                    <strong>وصفة #{{ $presc->id }}</strong>
                    <span class="text-muted small ms-2">{{ $presc->created_at->format('d/m/Y h:i A') }}</span>
                    <div class="small text-muted mt-1">
                        <i class="fas fa-user-md"></i> د. {{ $presc->doctor->user->name ?? 'غير معروف' }}
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if($presc->status === 'delivered' || $presc->status === 'confirmed')
                        <span class="status-confirmed"><i class="fas fa-check-circle"></i> {{ $presc->status === 'confirmed' ? 'تم الاستلام' : 'تم التسليم' }}</span>
                    @else
                        <span class="status-pending"><i class="fas fa-clock"></i> قيد الانتظار</span>
                        <form action="{{ route('patient.prescriptions.confirm', $presc) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تأكدت من استلام الأدوية؟')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> تأكيد استلام الطلب</button>
                        </form>
                    @endif
                </div>
            </div>

            @forelse($presc->medicines as $medicine)
            <div class="medicine-item">
                <div class="med-icon"><i class="fas fa-capsules"></i></div>
                <div class="flex-grow-1">
                    <strong>{{ $medicine->name }}</strong>
                    <div class="row g-2 mt-1">
                        <div class="col-sm-4"><span class="badge bg-light text-dark border">الجرعة: {{ $medicine->pivot->dosage ?? '—' }}</span></div>
                        <div class="col-sm-4"><span class="badge bg-light text-dark border">المدة: {{ $medicine->pivot->days ?? '—' }} أيام</span></div>
                        @if($medicine->pivot->notes)
                        <div class="col-12"><small class="text-muted"><i class="fas fa-info-circle"></i> {{ $medicine->pivot->notes }}</small></div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-muted">لا توجد أدوية في هذه الوصفة.</div>
            @endforelse
        </div>
        @empty
        <div class="rx-card p-5 text-center">
            <i class="fas fa-capsules fa-3x text-muted mb-3"></i>
            <h4 class="fw-bold">{{ __('messages.no_prescriptions') }}</h4>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-calendar-plus"></i> {{ __('messages.book_new_appointment') }}
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
