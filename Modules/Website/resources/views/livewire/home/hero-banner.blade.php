{{-- Quan trọng: Thêm style x-cloak để ẩn khối này đi cho đến khi Alpine tải xong --}}
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="w-full mb-8 rounded-xl overflow-hidden shadow-lg group relative"
     x-data="{
        activeSlide: 0,
        totalSlides: {{ count($slides) }},
        timer: null,
        startAutoSlide() {
            this.timer = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        stopAutoSlide() {
            clearInterval(this.timer);
        },
        nextSlide() {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
        },
        prevSlide() {
            this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
        }
     }"
     x-init="startAutoSlide()"
     @mouseenter="stopAutoSlide()"
     @mouseleave="startAutoSlide()"
>
    {{--
        CONTAINER CHÍNH:
        1. relative: Để làm mốc cho các ảnh con absolute.
        2. aspect-[...]: Giữ khung hình cố định (tránh sập chiều cao).
    --}}
    <div class="relative w-full aspect-[16/9] md:aspect-[21/9] bg-gray-200">

        @if(count($slides) > 0)
            @foreach($slides as $index => $slide)
                {{--
                    ITEM:
                    1. absolute inset-0: Buộc ảnh phải nằm đè lên khung container.
                    2. x-show: Chỉ hiện ảnh đang active.
                    3. x-transition: Hiệu ứng mờ dần (fade).
                --}}
                <div class="absolute inset-0 w-full h-full"
                     x-show="activeSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-1000"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     {{-- Fallback: Nếu JS không chạy, chỉ hiện slide đầu tiên --}}
                     style="{{ $index !== 0 ? 'display: none;' : '' }}"
                >
                    {{-- Ảnh --}}
                    <img src="{{ asset($slide['image']) }}"
                         class="w-full h-full object-cover"
                         alt="{{ $slide['title'] ?? 'Banner' }}">

                    {{-- Overlay & Text --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/20 to-transparent">
                        <div class="h-full flex items-center pl-8 md:pl-20">
                            <div class="max-w-xl text-white space-y-4">
                                <h2 class="text-3xl md:text-5xl font-bold leading-tight drop-shadow-lg">
                                    {{ $slide['title'] ?? '' }}
                                </h2>
                                <p class="text-lg md:text-xl text-gray-100 font-light drop-shadow-md">
                                    {{ $slide['sub_title'] ?? '' }}
                                </p>

                                @if(!empty($slide['link']))
                                    <a href="{{ $slide['link'] }}" class="inline-block px-8 py-3 bg-white text-gray-900 font-bold rounded-full hover:bg-green-500 hover:text-white transition shadow-lg">
                                        {{ $slide['btn_text'] ?? 'Xem ngay' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
             {{-- Fallback khi không có data --}}
             <div class="flex items-center justify-center h-full text-gray-500">
                Chưa có banner nào được cấu hình.
             </div>
        @endif
    </div>

    {{-- Nút điều hướng (Chỉ hiện khi JS chạy và có > 1 slide) --}}
    @if(count($slides) > 1)
        <button @click="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-white/20 hover:bg-white text-white hover:text-black rounded-full backdrop-blur-sm transition" x-cloak>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-white/20 hover:bg-white text-white hover:text-black rounded-full backdrop-blur-sm transition" x-cloak>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-4 left-0 right-0 z-20 flex justify-center gap-2" x-cloak>
            <template x-for="i in totalSlides">
                <button @click="activeSlide = i - 1"
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === (i - 1) ? 'bg-white w-8' : 'bg-white/50 hover:bg-white'">
                </button>
            </template>
        </div>
    @endif
</div>
