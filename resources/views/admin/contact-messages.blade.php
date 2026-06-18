@extends('layouts.dashboard')

@section('title', __('messages.contact_messages_title'))

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">رسائل التواصل</h1>
        <p class="page-subtitle">إدارة الرسائل الواردة من الأطباء والمرضى</p>
    </div>
    <div>
        <span class="badge" style="background-color: var(--red); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.95rem;">
            <i class="fa-solid fa-envelope"></i> {{ $unreadCount ?? 0 }} جديد
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي الرسائل</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--primary);">{{ $messages->total() }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(0, 102, 204, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem;">
                <i class="fa-solid fa-envelope"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">رسائل جديدة</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--red);">{{ $unreadCount ?? 0 }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 1.5rem;">
                <i class="fa-solid fa-bell"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">رسائل مقروءة</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--success);">{{ \App\Models\ContactMessage::where('status', 'read')->count() }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: var(--success); font-size: 1.5rem;">
                <i class="fa-solid fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">تم الرد عليها</p>
                <h3 style="font-size: 2rem; font-weight: 900; color: var(--purple);">{{ \App\Models\ContactMessage::where('status', 'replied')->count() }}</h3>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; color: var(--purple); font-size: 1.5rem;">
                <i class="fa-solid fa-reply"></i>
            </div>
        </div>
    </div>
</div>

<!-- Messages Table -->
<div class="card">
    @if($messages->count())
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border); background-color: var(--light-bg);">
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--muted);">الاسم</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--muted);">البريد الإلكتروني</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--muted);">الموضوع</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--muted);">التاريخ</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--muted);">الحالة</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--muted);">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                <tr style="border-bottom: 1px solid var(--border); background-color: {{ $message->status === 'new' ? 'rgba(239, 68, 68, 0.05)' : 'white' }}; transition: background-color 0.2s;">
                    <td style="padding: 1rem; text-align: right;">
                        <strong>{{ $message->name }}</strong>
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <a href="mailto:{{ $message->email }}" style="color: var(--primary); text-decoration: none;">{{ $message->email }}</a>
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        {{ Str::limit($message->subject, 40) }}
                    </td>
                    <td style="padding: 1rem; text-align: right; color: var(--muted); font-size: 0.9rem;">
                        {{ $message->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        @if($message->status === 'new')
                            <span style="display: inline-block; background-color: var(--red); color: white; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">جديد</span>
                        @elseif($message->status === 'read')
                            <span style="display: inline-block; background-color: var(--warning); color: white; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">مقروء</span>
                        @else
                            <span style="display: inline-block; background-color: var(--success); color: white; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">تم الرد</span>
                        @endif
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <button 
                            class="btn btn-primary" 
                            style="padding: 0.5rem 1rem; font-size: 0.9rem; border: none; background-color: var(--primary); color: white; border-radius: 6px; cursor: pointer; transition: background-color 0.2s;"
                            data-bs-toggle="modal" 
                            data-bs-target="#messageModal{{ $message->id }}">
                            <i class="fa-solid fa-eye"></i> عرض
                        </button>
                    </td>
                </tr>

                <!-- Modal for Message Details -->
                <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                            <div class="modal-header" style="border-bottom: 1px solid var(--border); padding: 1.5rem;">
                                <h5 class="modal-title" style="font-weight: 700; font-size: 1.2rem;">{{ $message->subject }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="padding: 1.5rem;">
                                <!-- Sender Info -->
                                <div style="background-color: var(--light-bg); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                        <div>
                                            <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.3rem;">الاسم</p>
                                            <p style="font-weight: 600;">{{ $message->name }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.3rem;">البريد الإلكتروني</p>
                                            <p style="font-weight: 600;">{{ $message->email }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.3rem;">التاريخ</p>
                                            <p style="font-weight: 600;">{{ $message->created_at->format('d/m/Y H:i:s') }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.3rem;">الحالة</p>
                                            <p style="font-weight: 600;">
                                                @if($message->status === 'new')
                                                    <span style="color: var(--red);">جديد</span>
                                                @elseif($message->status === 'read')
                                                    <span style="color: var(--warning);">مقروء</span>
                                                @else
                                                    <span style="color: var(--success);">تم الرد</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Content -->
                                <div style="margin-bottom: 1.5rem;">
                                    <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--text);">محتوى الرسالة</h6>
                                    <div style="background-color: #f9fafb; padding: 1rem; border-radius: 8px; border-right: 4px solid var(--primary); line-height: 1.6;">
                                        {{ $message->message }}
                                    </div>
                                </div>

                                <!-- Admin Reply (if exists) -->
                                @if($message->admin_reply)
                                <div style="margin-bottom: 1.5rem;">
                                    <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--success);">الرد من الإدارة</h6>
                                    <div style="background-color: rgba(16, 185, 129, 0.05); padding: 1rem; border-radius: 8px; border-right: 4px solid var(--success); line-height: 1.6;">
                                        {{ $message->admin_reply }}
                                    </div>
                                    <p style="color: var(--muted); font-size: 0.85rem; margin-top: 0.5rem;">
                                        <i class="fa-solid fa-clock"></i> تم الرد في: {{ $message->replied_at?->format('d/m/Y H:i:s') }}
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid var(--border); padding: 1rem;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 0.5rem 1.5rem; border-radius: 6px;">إغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
        {{ $messages->links() }}
    </div>
    @else
    <div style="text-align: center; padding: 3rem 1rem;">
        <div style="font-size: 3rem; color: var(--muted); margin-bottom: 1rem;">
            <i class="fa-solid fa-inbox"></i>
        </div>
        <h3 style="color: var(--muted); margin-bottom: 0.5rem;">لا توجد رسائل حالياً</h3>
        <p style="color: var(--muted); font-size: 0.95rem;">ستظهر الرسائل الواردة من الأطباء والمرضى هنا</p>
    </div>
    @endif
</div>

<style>
    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    table tbody tr:hover {
        background-color: rgba(0, 102, 204, 0.02) !important;
    }

    .modal-content {
        border-radius: 12px;
    }

    .badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
</style>
@endsection
