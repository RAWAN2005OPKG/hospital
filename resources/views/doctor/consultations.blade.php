@extends('layouts.app')

@section('title', 'إدارة الاستشارات')

@push('styles')
<style>
.doc-consult { background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 50%, #ecfeff 100%); padding: 2rem 0 4rem; min-height: 80vh; }
.doc-consult h1 { font-size: 2.25rem; font-weight: 900; color: #111827; }
.consult-layout { display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-top: 1.5rem; }
.consult-sidebar { background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; max-height: 600px; overflow-y: auto; }
.consult-chat { background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; min-height: 550px; display: flex; flex-direction: column; }
.chat-list-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem; border-radius: 0.75rem; border: 1px solid #e5e7eb; text-decoration: none; color: inherit; margin-bottom: 0.5rem; transition: background 0.2s; }
.chat-list-item:hover { background: #ecfeff; border-color: #06b6d4; }
.chat-avatar { width: 44px; height: 44px; border-radius: 10px; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }
.chat-header-bar { padding: 1rem 1.25rem; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; border-radius: 1rem 1rem 0 0; font-weight: 700; }
.chat-messages-area { flex: 1; padding: 1.25rem; overflow-y: auto; background: #f9fafb; }
.chat-msg { max-width: 75%; padding: 0.75rem 1rem; border-radius: 1rem; margin-bottom: 0.75rem; line-height: 1.6; }
.chat-msg.sent { margin-right: 0; margin-left: auto; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; }
.chat-msg.received { background: #fff; border: 1px solid #e5e7eb; }
.chat-input-area { padding: 1rem; border-top: 1px solid #e5e7eb; display: flex; gap: 0.75rem; }
@media (max-width: 768px) { .consult-layout { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="doc-consult">
    <div class="container">
        <h1>استشارات المرضى</h1>
        <p class="text-muted">إدارة الردود على استفسارات المرضى</p>

        <div class="consult-layout">
            <div class="consult-sidebar">
                <h5 class="fw-bold mb-3"><i class="fas fa-inbox text-info"></i> المحادثات</h5>
                @forelse($chats ?? [] as $chat)
                    @php $otherUser = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender; @endphp
                    <a href="{{ route('doctor.chat.show', $otherUser->id) }}" class="chat-list-item">
                        <div class="chat-avatar">{{ mb_substr($otherUser->name, 0, 1) }}</div>
                        <div style="min-width:0;">
                            <div class="fw-bold">{{ $otherUser->name }}</div>
                            <div class="small text-muted text-truncate">{{ $chat->message }}</div>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-muted py-4">لا توجد استشارات</p>
                @endforelse
            </div>

            <div class="consult-chat">
                @if(isset($messages))
                    <div class="chat-header-bar"><i class="fas fa-user-circle"></i> {{ $otherUser->name }}</div>
                    <div class="chat-messages-area">
                        @foreach($messages as $msg)
                        <div class="chat-msg {{ $msg->sender_id === auth()->id() ? 'sent' : 'received' }}">{{ $msg->message }}</div>
                        @endforeach
                    </div>
                    <form action="{{ route('chat.store', $otherUser->id) }}" method="POST" class="chat-input-area">
                        @csrf
                        <input type="text" name="message" required class="form-control" placeholder="اكتب ردك الطبي هنا...">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> إرسال</button>
                    </form>
                @else
                    <div class="d-flex align-items-center justify-content-center flex-grow-1 text-muted">
                        <div class="text-center">
                            <i class="fas fa-comments fa-3x mb-3 opacity-25"></i>
                            <p class="fw-semibold">اختر محادثة للبدء</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
