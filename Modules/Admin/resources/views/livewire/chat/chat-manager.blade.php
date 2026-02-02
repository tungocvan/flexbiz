<div class="flex h-[85vh] bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="w-1/3 border-r border-gray-100 flex flex-col bg-gray-50/50">
        <div class="p-5 border-b border-gray-100 bg-white">
            <h3 class="font-bold text-gray-800 text-lg">Hội thoại</h3>
        </div>
        <div class="overflow-y-auto flex-1 custom-scrollbar">
            @forelse($sessions as $session)
                <div wire:click="selectSession({{ $session->id }})"
                     wire:key="session-{{ $session->id }}"
                     class="p-4 cursor-pointer transition-all border-b border-gray-50 hover:bg-white {{ $activeSessionId == $session->id ? 'bg-white shadow-sm !border-l-4 !border-l-blue-600' : '' }}">
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700">Guest #{{ $session->id }}</span>
                        <span class="text-[10px] text-gray-400">{{ $session->updated_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-gray-500 truncate mt-1">
                        {{ $session->messages->last()?->message ?? 'Bắt đầu cuộc trò chuyện' }}
                    </p>
                </div>
            @empty
                <div class="p-10 text-center text-gray-400 text-sm">Chưa có khách nhắn tin</div>
            @endforelse
        </div>
    </div>

    <div class="w-2/3 flex flex-col bg-white">
        @if($activeSession)
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                        G
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">Guest #{{ $activeSession->id }}</p>
                        <p class="text-[10px] text-green-500 font-medium italic">Đang trực tuyến</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50/30 custom-scrollbar" id="chat-window">
                @foreach($activeSession->messages as $msg)
                    <div wire:key="msg-{{ $msg->id }}" class="flex {{ $msg->sender_type == 'admin' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] p-3.5 rounded-2xl shadow-sm text-sm leading-relaxed
                            {{ $msg->sender_type == 'admin'
                                ? 'bg-blue-600 text-white rounded-tr-none'
                                : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none' }}">
                            {{ $msg->message }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 border-t border-gray-100 bg-white">
                <form wire:submit.prevent="send" class="flex gap-3 items-center">
                    <input type="text" wire:model="message"
                           class="flex-1 bg-gray-50 border-gray-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none"
                           placeholder="Nhập nội dung phản hồi cho khách...">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all active:scale-95">
                        Gửi tin
                    </button>
                </form>
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-gray-300">
                <svg class="w-20 h-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p>Chọn một hội thoại để bắt đầu hỗ trợ</p>
            </div>
        @endif
    </div>
</div>
