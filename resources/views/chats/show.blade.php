@extends('layouts.app')
@section('title', 'محادثة مع ' . $otherUser->name)

@push('styles')
<style>
.chat-page { background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); min-height: 80vh; padding: 2rem 0 4rem; }
.chat-box { background: #fff; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; display: flex; flex-direction: column; height: 70vh; max-height: 650px; }
.chat-header { padding: 1.25rem 1.5rem; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; border-radius: 1.25rem 1.25rem 0 0; font-weight: 700; }
.chat-messages { flex: 1; overflow-y: auto; padding: 1.5rem; background: #f9fafb; display: flex; flex-direction: column; gap: 0.75rem; }
.chat-bubble { max-width: 75%; padding: 0.85rem 1.1rem; border-radius: 1rem; line-height: 1.6; }
.chat-bubble.sent { align-self: flex-end; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; }
.chat-bubble.received { align-self: flex-start; background: #fff; border: 1px solid #e5e7eb; color: #111827; }
.chat-form { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; gap: 0.75rem; }
.chat-form input { flex: 1; padding: 0.85rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.85rem; }
</style>
@endpush

@section('content')
<div class="chat-page">
    <div class="container" style="max-width:900px;">
        <a href="{{ route('patient.consultations') }}" class="btn btn-outline-primary mb-3"><i class="fas fa-arrow-right"></i> العودة للاستشارات</a>
        <div class="chat-box">
            <div class="chat-header"><i class="fas fa-user-md"></i> د. {{ $otherUser->name }}</div>
            <div class="chat-messages" id="chatMessages">
                @foreach($messages as $msg)
                <div class="chat-bubble {{ $msg->sender_id === auth()->id() ? 'sent' : 'received' }}">
                    {{ $msg->message }}
                </div>
                @endforeach
            </div>
            <form action="{{ route('chat.store', $otherUser->id) }}" method="POST" class="chat-form">
                @csrf
                <input type="text" name="message" required placeholder="اكتب رسالتك هنا..." autocomplete="off">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> إرسال</button>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('chatMessages')?.scrollTo(0, 99999);
</script>
@endsection
