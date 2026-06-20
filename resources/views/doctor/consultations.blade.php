@extends('layouts.app')

@section('title', 'إدارة الاستشارات')

@section('content')
<div style="padding-top: 120px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2.5rem; font-weight: 900; color: #111827; margin: 0 0 0.5rem 0;">استشارات المرضى</h1>
            <p style="font-size: 1.1rem; color: #6b7280; margin: 0;">إدارة الردود على استفسارات المرضى</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
            <!-- Sidebar -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 1.5rem; border: 1px solid #e5e7eb; height: 700px; overflow-y: auto;">
                <h3 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-inbox" style="color: #06b6d4;"></i>
                    المحادثات
                </h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @forelse($chats ?? [] as $chat)
                        @php $otherUser = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender; @endphp
                        <a href="{{ route('doctor.chat.show', $otherUser->id) }}" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 1rem; border: 1px solid #e5e7eb; text-decoration: none; transition: all 0.3s ease; hover: background: #ecfeff; hover: border-color: #06b6d4;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">
                                {{ mb_substr($otherUser->name, 0, 1) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: bold; color: #111827; margin-bottom: 0.25rem;">{{ $otherUser->name }}</div>
                                <div style="font-size: 0.85rem; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $chat->message }}</div>
                            </div>
                        </a>
                    @empty
                        <div style="text-align: center; padding: 3rem; color: #9ca3af; background: #f9fafb; border-radius: 1rem; border: 2px dashed #e5e7eb;">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                            <p style="margin: 0; font-weight: 600;">لا توجد استشارات</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Chat Area -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; height: 700px; display: flex; flex-direction: column;">
                @if(isset($messages))
                    <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 1.5rem 1.5rem 0 0;">
                        <h3 style="font-size: 1.25rem; font-weight: bold; color: white; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-user-circle"></i>
                            {{ $otherUser->name }}
                        </h3>
                    </div>
                    <div style="flex: 1; padding: 1.5rem; overflow-y: auto; background: #f9fafb; display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($messages as $msg)
                            <div style="display: flex; {{ $msg->sender_id === auth()->id() ? 'justify-content: flex-end' : 'justify-content: flex-start' }};">
                                <div style="max-width: 70%; padding: 1rem 1.25rem; border-radius: 1rem; {{ $msg->sender_id === auth()->id() ? 'background: linear-gradient(135deg, #06b6d4, #0891b2); color: white;' : 'background: white; color: #111827; border: 1px solid #e5e7eb;' }} box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                    {{ $msg->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background: white; border-radius: 0 0 1.5rem 1.5rem;">
                        <form action="{{ route('chat.store', $otherUser->id) }}" method="POST" style="display: flex; gap: 1rem;">
                            @csrf
                            <input type="text" name="message" required placeholder="اكتب ردك الطبي هنا..." style="flex: 1; padding: 1rem 1.25rem; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 1rem; outline: none; color: #111827; font-size: 1rem;">
                            <button type="submit" style="padding: 1rem 2rem; background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; font-weight: bold; border-radius: 1rem; border: none; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-paper-plane"></i>
                                إرسال
                            </button>
                        </form>
                    </div>
                @else
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; color: #9ca3af; background: #f9fafb; border-radius: 0 0 1.5rem 1.5rem;">
                        <div style="text-align: center;">
                            <i class="fas fa-comments" style="font-size: 4rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                            <p style="font-size: 1.25rem; font-weight: 600;">اختر محادثة للبدء</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
