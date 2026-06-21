@extends('layouts.app')
@section('title', 'الإشعارات')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-bell"></i> الإشعارات</h1>
        <div>
            @if($unreadCount > 0)
            <a href="{{ route('pharmacist.notifications.mark-all-read') }}" class="btn btn-warning">
                <i class="fa-solid fa-check-double"></i> تحديد الكل كمقروء ({{ $unreadCount }})
            </a>
            @endif
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pharmacist.notifications.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>النوع</label>
                        <select name="type" class="form-control">
                            <option value="">الكل</option>
                            <option value="new_prescription" {{ request('type') == 'new_prescription' ? 'selected' : '' }}>وصفة جديدة</option>
                            <option value="low_stock" {{ request('type') == 'low_stock' ? 'selected' : '' }}>انخفاض المخزون</option>
                            <option value="expiring_soon" {{ request('type') == 'expiring_soon' ? 'selected' : '' }}>قرب الانتهاء</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>الحالة</label>
                        <select name="read" class="form-control">
                            <option value="">الكل</option>
                            <option value="unread" {{ request('read') == 'unread' ? 'selected' : '' }}>غير مقروء</option>
                            <option value="read" {{ request('read') == 'read' ? 'selected' : '' }}>مقروء</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">تصفية</button>
                        <a href="{{ route('pharmacist.notifications.index') }}" class="btn btn-secondary ms-2">إعادة تعيين</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="card">
        <div class="card-body">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                <div class="card mb-3 {{ $notification->read_at ? 'bg-light' : 'border-primary' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                @if(!$notification->read_at)
                                    <span class="badge bg-primary">جديد</span>
                                @endif
                                <h5 class="card-title">{{ $notification->data['title'] ?? 'إشعار' }}</h5>
                                <p class="card-text">{{ $notification->data['message'] ?? $notification->data }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if(!$notification->read_at)
                            <a href="{{ route('pharmacist.notifications.mark-read', $notification) }}" class="btn btn-sm btn-outline-primary">
                                تحديد كمقروء
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $notifications->links() }}
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-bell-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">لا توجد إشعارات</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
