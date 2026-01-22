<div class="mb-16 group relative w-full aspect-[21/9] md:aspect-[3/1] rounded-2xl overflow-hidden shadow-2xl">

    {{-- 1. ẢNH NỀN (Vẫn cho phép click vào ảnh nền để đi tới trang Shop cho tiện) --}}
    <a href="{{ $banner['link'] ?? '#' }}" class="absolute inset-0 z-0">
        <img src="{{ asset($banner['image']) }}"
             alt="{{ $banner['title'] ?? 'Promotion' }}"
             class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
    </a>

    {{-- 2. NỘI DUNG (Đặt z-index cao hơn để nổi lên trên) --}}
    <div class="absolute inset-0 flex items-center px-8 md:px-16 pointer-events-none"> {{-- pointer-events-none để click xuyên qua vào ảnh nền --}}
        <div class="max-w-2xl relative z-10 pointer-events-auto"> {{-- pointer-events-auto để click được vào nút --}}

            <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold tracking-wider mb-4 uppercase animate-fade-in-down">
                Limited Offer
            </span>

            <h2 class="text-3xl md:text-5xl font-black text-white leading-tight mb-4 drop-shadow-lg tracking-tight">
                {{ $banner['title'] ?? '' }}
            </h2>

            @if(!empty($banner['sub_title']))
                <p class="text-lg text-gray-200 mb-8 font-light max-w-lg">
                    {{ $banner['sub_title'] }}
                </p>
            @endif

            <div class="flex items-center gap-6">
                {{-- LINK 1: Nút Action -> Trỏ về Shop --}}
                <a href="{{ $banner['link'] ?? '#' }}" class="px-8 py-3 bg-white text-gray-900 font-bold rounded-lg hover:bg-green-400 hover:text-white transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                    {{ $banner['btn_text'] ?? 'Mua Ngay' }}
                </a>

                {{-- LINK 2: Text Link -> Trỏ về Blog/Chi tiết (Dùng details_link) --}}
                @if(!empty($banner['details_link']))
                    <a href="{{ $banner['details_link'] }}" class="text-white/80 text-sm font-medium hover:text-white hover:underline transition-all flex items-center gap-1 group/link">
                        Chi tiết chương trình
                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
