@extends('layouts.app')
@section('title', 'تفاصيل الوصفة الطبية')

@push('styles')
<style>
    .pharmacist-container { padding: 2rem 0; max-width: 900px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; }
    
    .prescription-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 2.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px dashed #e2e8f0;
    }

    .info-item label { color: #64748b; font-size: 0.9rem; font-weight: 700; display: block; margin-bottom: 0.25rem; }
    .info-item div { font-size: 1.1rem; font-weight: 800; color: #1e293b; }

    .medicines-list { margin-top: 2rem; }
    .medicine-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1rem;
        align-items: center;
    }
    .med-name { font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; }
    .med-details { display: flex; gap: 1.5rem; color: #475569; font-size: 0.95rem; }
    .med-details span { display: inline-flex; align-items: center; gap: 0.4rem; font-weight: 600; }
    
    .stock-info { text-align: left; }
    .stock-badge { padding: 0.35rem 0.75rem; border-radius: 50px; font-size: 0.85rem; font-weight: 700; display: inline-block; }
    .stock-good { background: #dcfce7; color: #166534; }
    .stock-low { background: #fef3c7; color: #92400e; }
    .stock-out { background: #fee2e2; color: #991b1b; }

    .btn-deliver {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }
    .btn-deliver:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
    .btn-deliver:disabled { background: #94a3b8; cursor: not-allowed; transform: none; box-shadow: none; }
</style>
@endpush

@section('content')
<div class="pharmacist-container">
    <div class="page-header">
        <h1 class="page-title">تفاصيل الوصفة #{{ $prescription->id }}</h1>
        <a href="{{ route('pharmacist.prescriptions.index') }}" style="color:#64748b;text-decoration:none;font-weight:700">
            <i class="fa-solid fa-arrow-right"></i> عودة للقائمة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background:#dcfce7;color:#166534;border:none;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;font-weight:600;">
            <i class="fa-solid fa-check-circle" style="margin-left:0.5rem"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;border:none;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;font-weight:600;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-left:0.5rem"></i> {{ session('error') }}
        </div>
    @endif

    <div class="prescription-card">
        <div class="info-grid">
            <div class="info-item">
                <label>اسم المريض</label>
                <div><i class="fa-solid fa-user-injured" style="color:#3b82f6;margin-left:0.4rem"></i> {{ $prescription->patient->user->name ?? 'غير معروف' }}</div>
            </div>
            <div class="info-item">
                <label>الطبيب المعالج</label>
                <div><i class="fa-solid fa-user-doctor" style="color:#10b981;margin-left:0.4rem"></i> د. {{ $prescription->doctor->user->name ?? 'غير معروف' }}</div>
            </div>
            <div class="info-item">
                <label>تاريخ الوصفة</label>
                <div dir="ltr" style="text-align:right"><i class="fa-regular fa-calendar" style="color:#8b5cf6;margin-left:0.4rem"></i> {{ $prescription->created_at->format('Y-m-d h:i A') }}</div>
            </div>
            <div class="info-item">
                <label>الحالة</label>
                <div>
                    @if($prescription->status === 'delivered')
                        <span style="color:#10b981"><i class="fa-solid fa-check-circle"></i> تم تسليم الأدوية للمريض</span>
                    @else
                        <span style="color:#f59e0b"><i class="fa-solid fa-clock"></i> قيد الانتظار (لم يتم التسليم)</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="medicines-list">
            <h3 style="font-size:1.3rem;font-weight:800;color:#1e293b;margin-bottom:1rem">الأدوية الموصوفة</h3>
            
            @php $canDeliver = true; @endphp
            
            @forelse($prescription->medicines as $medicine)
                <div class="medicine-item">
                    <div>
                        <div class="med-name">{{ $medicine->name }}</div>
                        <div class="med-details">
                            <span><i class="fa-solid fa-syringe" style="color:#3b82f6"></i> الجرعة: {{ $medicine->pivot->dosage ?? 'غير محدد' }}</span>
                            <span><i class="fa-solid fa-calendar-days" style="color:#8b5cf6"></i> المدة: {{ $medicine->pivot->days ?? 'غير محدد' }} أيام</span>
                        </div>
                        @if(!empty($medicine->pivot->notes))
                            <div style="margin-top:0.5rem;font-size:0.9rem;color:#64748b;background:#fff;padding:0.5rem;border-radius:8px">
                                <strong>ملاحظات:</strong> {{ $medicine->pivot->notes }}
                            </div>
                        @endif
                    </div>
                    <div class="stock-info">
                        @if($medicine->stock <= 0)
                            <span class="stock-badge stock-out">نفد المخزون (0)</span>
                            @php $canDeliver = false; @endphp
                        @elseif($medicine->stock <= $medicine->low_stock_threshold)
                            <span class="stock-badge stock-low">مخزون منخفض ({{ $medicine->stock }})</span>
                        @else
                            <span class="stock-badge stock-good">متوفر ({{ $medicine->stock }})</span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:2rem;color:#64748b;font-weight:600">لا توجد أدوية مدرجة في هذه الوصفة.</div>
            @endforelse
        </div>

        @if($prescription->status !== 'delivered')
            <form action="{{ route('pharmacist.prescriptions.deliver', $prescription->id) }}" method="POST">
                @csrf
                @if(!$canDeliver)
                    <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;border:none;border-radius:12px;padding:1rem;margin-top:1.5rem;font-weight:600;font-size:0.9rem">
                        <i class="fa-solid fa-circle-exclamation"></i> لا يمكن تسليم الوصفة لوجود أدوية نافدة المخزون. يرجى تحديث المخزون أولاً.
                    </div>
                @endif
                <button type="submit" class="btn-deliver" {{ !$canDeliver ? 'disabled' : '' }} onclick="return confirm('هل أنت متأكد من تسليم الأدوية؟ سيتم خصم الكميات من المخزون تلقائياً.')">
                    <i class="fa-solid fa-hand-holding-medical"></i> 
                    {{ !$canDeliver ? 'غير قادر على التسليم' : 'تم تسليم الأدوية' }}
                </button>
            </form>
        @else
            <div style="margin-top:2rem;text-align:center;padding:1rem;background:#f8fafc;border-radius:12px;color:#64748b;font-weight:700">
                <i class="fa-solid fa-check-double" style="color:#10b981"></i> هذه الوصفة مغلقة ومسلمة مسبقاً.
            </div>
        @endif
    </div>
</div>
@endsection
