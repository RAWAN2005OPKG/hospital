{{-- patient/medical-records.blade.php --}}
@extends('layouts.app')
@section('title','سجلاتي الطبية')

@push('styles')
<style>
.mr-page { background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #dcfce7 100%); padding: 2rem 0 4rem; min-height: 80vh; }
.mr-header h1 { font-size: 2.25rem; font-weight: 900; color: #111827; }
.mr-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin: 2rem 0; }
.mr-stat { color: #fff; padding: 1.5rem; border-radius: 1rem; text-align: center; }
.mr-stat.green { background: linear-gradient(135deg, #10b981, #059669); }
.mr-stat.blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.mr-stat-num { font-size: 2rem; font-weight: 900; }
.mr-card { background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 1.25rem; overflow: hidden; }
.mr-card-head { padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
.mr-card-body { padding: 1.5rem; }
.mr-block { background: #f9fafb; border-radius: 0.75rem; padding: 1rem; margin-bottom: 1rem; border: 1px solid #e5e7eb; }
.mr-block h5 { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.5rem; color: #374151; }
.mr-empty { text-align: center; padding: 4rem 2rem; background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; }
</style>
@endpush

@section('content')
<div class="mr-page">
    <div class="container">
        <div class="mr-header">
            <h1><i class="fas fa-file-medical text-success"></i> سجلاتي الطبية</h1>
            <p class="text-muted mt-1">جميع سجلاتك الطبية في مكان واحد</p>
        </div>

        <div class="mr-stats">
            <div class="mr-stat green">
                <div class="mr-stat-num">{{ $records ? $records->count() : 0 }}</div>
                <div>السجلات الكلية</div>
            </div>
            <div class="mr-stat blue">
                <div class="mr-stat-num">{{ $recentRecords ?? 0 }}</div>
                <div>السجلات الأخيرة</div>
            </div>
        </div>

        @forelse($records ?? collect() as $record)
        <div class="mr-card">
            <div class="mr-card-head">
                <div>
                    <h4 class="fw-bold mb-1">{{ $record->doctor->user->name ?? 'غير محدد' }}</h4>
                    <small class="text-muted"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($record->created_at)->format('d/m/Y H:i') }}</small>
                    <span class="badge bg-primary ms-2">{{ $record->appointment->reason ?? 'فحص روتيني' }}</span>
                </div>
                <a href="{{ route('medical-records.show', $record) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye"></i> عرض التفاصيل
                </a>
            </div>
            <div class="mr-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mr-block">
                            <h5><i class="fas fa-stethoscope text-danger"></i> التشخيص</h5>
                            <p class="mb-0 small">{{ Str::limit($record->diagnosis, 300) }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mr-block">
                            <h5><i class="fas fa-pills text-warning"></i> خطة العلاج</h5>
                            <p class="mb-0 small">{{ Str::limit($record->treatment, 300) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="mr-empty">
            <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
            <h4 class="fw-bold">لا توجد سجلات طبية بعد</h4>
            <p class="text-muted mb-4">سجلاتك الطبية ستظهر هنا بعد إتمام أول زيارة للطبيب</p>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-calendar-plus"></i> احجز موعداً الآن
            </a>
        </div>
        @endforelse

        @if(isset($records) && $records->hasPages())
        <div class="d-flex justify-content-center mt-4">{{ $records->links() }}</div>
        @endif
    </div>
</div>
@endsection