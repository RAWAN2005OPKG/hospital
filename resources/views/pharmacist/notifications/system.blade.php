@extends('layouts.app')
@section('title', 'إشعارات النظام')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-bell"></i> إشعارات النظام</h1>
        <a href="{{ route('pharmacist.dashboard') }}" class="btn btn-secondary">عودة للوحة التحكم</a>
    </div>

    <div class="row">
        @foreach($notifications as $notification)
        <div class="col-md-6 mb-4">
            <div class="card border-{{ $notification['priority'] == 'high' ? 'danger' : ($notification['priority'] == 'medium' ? 'warning' : 'info') }}">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @if($notification['type'] == 'new_prescription')
                                <i class="fa-solid fa-file-prescription fa-2x text-primary"></i>
                            @elseif($notification['type'] == 'low_stock')
                                <i class="fa-solid fa-box-open fa-2x text-danger"></i>
                            @elseif($notification['type'] == 'expiring_soon')
                                <i class="fa-solid fa-clock fa-2x text-warning"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="card-title">{{ $notification['message'] }}</h5>
                            <span class="badge bg-{{ $notification['priority'] == 'high' ? 'danger' : ($notification['priority'] == 'medium' ? 'warning' : 'info') }}">
                                {{ $notification['priority'] == 'high' ? 'عالي' : ($notification['priority'] == 'medium' ? 'متوسط' : 'منخفض') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if(empty($notifications))
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-check-circle fa-3x text-success mb-3"></i>
                    <h4>كل شيء على ما يرام</h4>
                    <p class="text-muted">لا توجد إشعارات نظام حالياً</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
