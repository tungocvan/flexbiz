<div x-data="{ open: @entangle('isOpen') }" class="fixed bottom-24 right-8 z-[9999]">
    <button @click="open = !open; if(open) $dispatch('chat-opened')"
            class="group relative flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 shadow-[0_10px_25px_rgba(37,99,235,0.4)] transition-all duration-300 hover:bg-blue-700 hover:scale-110 active:scale-95 focus:outline-none">
        <span class="absolute -top-1 -right-1 flex h-5 w-5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-5 w-5 bg-green-500 border-4 border-white"></span>
        </span>
        <svg x-show="!open" class="h-8 w-8 text-white transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <svg x-show="open" x-cloak class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-12 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         class="absolute bottom-20 right-0 w-[380px] sm:w-[420px] max-h-[600px] overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-[0_20px_60px_rgba(0,0,0,0.2)] flex flex-col">

        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-5 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=fff&color=2563eb" class="h-12 w-12 rounded-2xl border-2 border-white/20 shadow-md">
                    <div>
                        <h3 class="text-base font-bold tracking-tight">Hỗ trợ trực tuyến</h3>
                        <p class="text-[11px] font-medium text-blue-100">Sẵn sàng hỗ trợ bạn</p>
                    </div>
                </div>
            </div>
        </div>

        @if($step == 'auth')
            <div class="p-8 bg-white">
                <button wire:click="startChat" class="w-full rounded-2xl bg-blue-600 py-4 font-bold text-white shadow-xl shadow-blue-500/20 hover:bg-blue-700 transition-all">Bắt đầu trò chuyện</button>
            </div>
        @else
            <div class="flex h-[450px] flex-col bg-gray-50/50">
                <div id="chat-content" class="flex-1 overflow-y-auto p-5 space-y-6 custom-scrollbar">
                    {{-- Loop tin nhắn realtime --}}
                    @php
                        $session = \Modules\Admin\Models\ChatSession::where('session_token', $sessionToken)->first();
                        $messages = $session ? $session->messages : [];
                    @endphp

                    @foreach($messages as $msg)
                        <div class="flex {{ $msg->sender_type == (Auth::check() ? 'user' : 'guest') ? 'justify-end' : 'justify-start' }} items-end gap-2">
                            <div class="max-w-[85%] p-4 text-sm leading-relaxed shadow-sm
                                {{ $msg->sender_type == (Auth::check() ? 'user' : 'guest')
                                    ? 'bg-blue-600 text-white rounded-2xl rounded-tr-none'
                                    : 'bg-white text-gray-700 rounded-2xl rounded-tl-none border border-gray-100' }}">
                                {{ $msg->message }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 bg-white border-t border-gray-100">
                    <form wire:submit.prevent="send" class="relative flex items-center group">
                        <input wire:model="message" type="text" class="w-full rounded-2xl border-none bg-gray-100 py-4 pl-5 pr-14 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Viết tin nhắn...">
                        <button type="submit" class="absolute right-2 h-10 w-10 flex items-center justify-center bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700">
                            <svg class="h-5 w-5 rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        const scrollToBottom = () => {
            const el = document.getElementById('chat-content') || document.getElementById('chat-window');
            if (el) {
                el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
            }
        };

        // 1. Lắng nghe Echo (Kết nối trực tiếp từ NodeJS)
        window.Echo.channel('chat')
            .listen('.MessageSent', (data) => {
                console.log('📡 Socket Data Received:', data); // Kiểm tra data đổ về

                // Gọi refresh-chat để Livewire fetch dữ liệu mới nhất
                // Thêm delay 100ms để đảm bảo DB đã ghi xong dữ liệu (Race condition fix)
                setTimeout(() => {
                    Livewire.dispatch('refresh-chat');
                    console.log('🔄 Livewire Refreshed');
                }, 100);

                setTimeout(scrollToBottom, 300);
            });

        // 2. Lắng nghe sự kiện scroll nội bộ
        window.addEventListener('scroll-bottom', scrollToBottom);
        window.addEventListener('scroll-chat-to-bottom', scrollToBottom);

        // 3. Cuộn khi mở widget
        window.addEventListener('chat-opened', () => {
            setTimeout(scrollToBottom, 200);
        });
    });
</script>
@endpush
