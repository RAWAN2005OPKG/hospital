@extends('layouts.app')
@section('title', 'استشاراتي الطبية')

@push('styles')
<style>
.consult-page { background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); min-height: 80vh; padding: 2rem 0 4rem; }
.consult-hero { text-align: center; margin-bottom: 2.5rem; }
.consult-hero h1 { font-size: 2.5rem; font-weight: 900; color: #111827; margin: 0.5rem 0; }
.consult-hero p { color: #6b7280; font-size: 1.1rem; max-width: 600px; margin: 0 auto; }
.consult-tag { display: inline-block; padding: 0.4rem 1.2rem; background: #e0f4ff; color: #0077B6; border-radius: 50px; font-weight: 700; font-size: 0.85rem; }
.consult-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; }
.consult-sidebar, .consult-main { background: #fff; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; }
.consult-sidebar { padding: 1.5rem; max-height: 600px; overflow-y: auto; }
.consult-main { min-height: 500px; display: flex; align-items: center; justify-content: center; color: #9ca3af; padding: 2rem; }
.chat-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem; border-radius: 0.85rem; border: 1px solid #e5e7eb; text-decoration: none; color: inherit; margin-bottom: 0.5rem; transition: all 0.2s; }
.chat-item:hover { background: #ecfeff; border-color: #06b6d4; }
.chat-avatar { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }
.doctor-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem; margin-top: 1.5rem; }
.doctor-card { background: #fff; border-radius: 1rem; padding: 1.25rem; border: 1px solid #e5e7eb; text-align: center; }
@media (max-width: 768px) { .consult-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="consult-page">
    <div class="container">
        <div class="consult-hero">
            <span class="consult-tag">الاستشارات الطبية</span>
            <h1>محادثاتي مع الأطباء</h1>
            <p>اختر طبيباً للتواصل أو تابع محادثاتك السابقة</p>
        </div>

        <div class="consult-grid">
            <div class="consult-sidebar">
                <h3 style="font-weight: 800; margin-bottom: 1rem;"><i class="fas fa-inbox" style="color:#06b6d4;"></i> المحادثات</h3>
                @forelse($chats ?? [] as $chat)
                    @php $otherUser = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender; @endphp
                    <a href="{{ route('patient.chat.show', $otherUser->id) }}" class="chat-item">
                        <div class="chat-avatar">{{ mb_substr($otherUser->name, 0, 1) }}</div>
                        <div style="min-width:0;">
                            <div style="font-weight:700;">{{ $otherUser->name }}</div>
                            <div style="font-size:0.85rem;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $chat->message }}</div>
                        </div>
                    </a>
                @empty
                    <p style="text-align:center;color:#9ca3af;padding:2rem 0;">لا توجد محادثات بعد</p>
                @endforelse
            </div>
            <div class="consult-main">
                <div style="text-align:center;">
                    <i class="fas fa-comments" style="font-size:3rem;opacity:0.3;display:block;margin-bottom:1rem;"></i>
                    <p style="font-weight:600;">اختر محادثة أو ابدأ مع طبيب جديد</p>
                </div>
            </div>
        </div>

        <div style="margin-top:3rem;">
            <h3 style="font-weight:800;margin-bottom:0.5rem;"><i class="fas fa-user-doctor" style="color:#06b6d4;"></i> أطباء متاحون للاستشارة</h3>
            <div class="doctor-list">
                @foreach(\App\Models\Doctor::with('user','specialization')->limit(8)->get() as $doc)
                <div class="doctor-card">
                    <div class="chat-avatar" style="margin:0 auto 0.75rem;">{{ mb_substr($doc->user->name, 0, 1) }}</div>
                    <div style="font-weight:700;">د. {{ $doc->user->name }}</div>
                    <div style="font-size:0.85rem;color:#06b6d4;margin:0.25rem 0 1rem;">{{ $doc->specialization->name ?? 'طبيب عام' }}</div>
                    <a href="{{ route('patient.chat.show', $doc->user_id) }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-comment-medical"></i> بدء استشارة
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
