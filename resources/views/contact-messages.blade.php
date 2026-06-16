@extends('layouts.dashboard')
@section('title', 'رسائل التواصل')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>رسائل التواصل</h2>
                <span class="badge bg-danger">{{ $unreadCount ?? 0 }} جديد</span>
            </div>
        </div>
    </div>

    @if($messages->count())
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الموضوع</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                <tr class="{{ $message->status === 'new' ? 'table-light' : '' }}">
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ Str::limit($message->subject, 50) }}</td>
                    <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        @if($message->status === 'new')
                            <span class="badge bg-danger">جديد</span>
                        @elseif($message->status === 'read')
                            <span class="badge bg-warning">مقروء</span>
                        @else
                            <span class="badge bg-success">تم الرد</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#messageModal{{ $message->id }}">عرض</a>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $message->subject }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>الاسم:</strong> {{ $message->name }}</p>
                                <p><strong>البريد:</strong> {{ $message->email }}</p>
                                <p><strong>التاريخ:</strong> {{ $message->created_at->format('Y-m-d H:i:s') }}</p>
                                <hr>
                                <p><strong>الرسالة:</strong></p>
                                <p>{{ $message->message }}</p>
                                @if($message->admin_reply)
                                <hr>
                                <p><strong>الرد:</strong></p>
                                <p>{{ $message->admin_reply }}</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $messages->links() }}
    </div>
    @else
    <div class="alert alert-info text-center">
        <i class="fas fa-inbox"></i> لا توجد رسائل حالياً
    </div>
    @endif
</div>
@endsection
