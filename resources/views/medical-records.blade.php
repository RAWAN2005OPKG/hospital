{{-- patient/medical-records.blade.php --}}
@extends('layouts.app')
@section('title','سجلاتي الطبية')
@section('content')
<div class="page-header">
    <div class="container"><h1>سجلاتي الطبية</h1><p>جميع سجلاتك الطبية في مكان واحد</p></div>
</div>
<section class="section-sm"><div class="container">
@if($records->count())
<div style="display:flex;flex-direction:column;gap:1rem">
    @foreach($records as $rec)
    <div class="card">
        <div style="padding:1.25rem;display:flex;align-items:flex-start;gap:1.25rem;flex-wrap:wrap">
            <div style="width:52px;height:52px;border-radius:14px;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">
                <i class="fa-solid fa-file-medical"></i>
            </div>
            <div style="flex:1">
                <div style="font-weight:800;margin-bottom:.25rem">التشخيص: {{ $rec->diagnosis }}</div>
                <div style="font-size:.86rem;color:var(--muted);margin-bottom:.25rem">
                    <i class="fa-solid fa-user-doctor" style="margin-left:.3rem"></i>
                    {{ $rec->doctor->user->name ?? '-' }}
                    <span style="margin-right:.75rem"><i class="fa-solid fa-calendar" style="margin-left:.3rem"></i>{{ $rec->created_at->format('d/m/Y') }}</span>
                </div>
                <div style="font-size:.86rem;margin-top:.5rem">
                    <strong>العلاج:</strong> {{ $rec->treatment }}
                </div>
                @if($rec->notes)<div style="font-size:.83rem;color:var(--muted);margin-top:.3rem">{{ $rec->notes }}</div>@endif
            </div>
            <a href="{{ route('medical-records.show',$rec) }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-eye"></i> تفاصيل
            </a>
        </div>
    </div>
    @endforeach
</div>
<div>{{ $records->links() }}</div>
@else
<div style="text-align:center;padding:5rem;color:var(--muted)">
    <i class="fa-solid fa-file-medical" style="font-size:3rem;margin-bottom:1rem;display:block;opacity:.2"></i>
    لا توجد سجلات طبية بعد.
</div>
@endif
</div></section>
@endsection