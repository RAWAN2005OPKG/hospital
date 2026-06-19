@extends('layouts.app')

@section('title', 'إدارة الاستشارات')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" style="margin-top: 80px;">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-10">استشارات المرضى</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="md:col-span-1 bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($chats ?? [] as $chat)
                        @php $otherUser = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender; @endphp
                        <a href="{{ route('doctor.chat.show', $otherUser->id) }}" class="flex items-center gap-4 p-6 hover:bg-blue-50 dark:hover:bg-gray-700 transition-all">
                            <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                                {{ mb_substr($otherUser->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-gray-900 dark:text-white truncate">{{ $otherUser->name }}</div>
                                <div class="text-sm text-gray-500 truncate">{{ $chat->message }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="p-10 text-center text-gray-500">لا توجد استشارات</div>
                    @endforelse
                </div>
            </div>
            <!-- Chat Area -->
            <div class="md:col-span-2">
                @if(isset($messages))
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl flex flex-col h-[600px] border border-gray-100 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 font-bold text-gray-900 dark:text-white">{{ $otherUser->name }}</div>
                        <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50 dark:bg-gray-900">
                            @foreach($messages as $msg)
                                <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[70%] p-4 rounded-2xl {{ $msg->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white' }} shadow-md">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                            <form action="{{ route('chat.store', $otherUser->id) }}" method="POST" class="flex gap-4">
                                @csrf
                                <input type="text" name="message" required placeholder="اكتب ردك الطبي هنا..." class="flex-1 px-6 py-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl outline-none dark:text-white">
                                <button type="submit" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl">إرسال</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl h-[600px] flex items-center justify-center text-gray-500">اختر محادثة للبدء</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
