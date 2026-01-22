<div class="bg-white rounded-xl shadow-sm border border-red-100 p-6 mb-8 relative overflow-hidden">
    {{-- Hiệu ứng tia sét trang trí --}}
    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 bg-yellow-300 rounded-full blur-3xl opacity-20"></div>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 relative z-10">
        <div class="flex items-center gap-4">
            <h3 class="text-2xl font-black text-red-600 italic uppercase flex items-center gap-2">
                <svg class="w-8 h-8 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Flash Sale
            </h3>

            {{--
                FIX: Logic đếm ngược được viết trực tiếp trong x-data
                để tránh lỗi 'timer is not defined'
            --}}
            <div x-data="{
                    expiry: {{ $config['end_time_js'] ?? 0 }},
                    hours: '00',
                    minutes: '00',
                    seconds: '00',
                    interval: null,
                    init() {
                        if(this.expiry > 0) {
                            this.updateTimer();
                            this.interval = setInterval(() => {
                                this.updateTimer();
                            }, 1000);
                        }
                    },
                    updateTimer() {
                        const now = new Date().getTime();
                        const distance = this.expiry - now;

                        if (distance < 0) {
                            clearInterval(this.interval);
                            this.hours = '00';
                            this.minutes = '00';
                            this.seconds = '00';
                            return;
                        }

                        const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const s = Math.floor((distance % (1000 * 60)) / 1000);

                        this.hours = h.toString().padStart(2, '0');
                        this.minutes = m.toString().padStart(2, '0');
                        this.seconds = s.toString().padStart(2, '0');
                    }
                }"
                class="flex gap-2 text-sm font-bold text-white">

                <div class="bg-gray-900 p-1.5 rounded min-w-[36px] text-center">
                    <span x-text="hours">00</span>
                </div>
                <span class="text-gray-900 font-bold self-center">:</span>
                <div class="bg-gray-900 p-1.5 rounded min-w-[36px] text-center">
                    <span x-text="minutes">00</span>
                </div>
                <span class="text-gray-900 font-bold self-center">:</span>
                <div class="bg-red-600 p-1.5 rounded min-w-[36px] text-center">
                    <span x-text="seconds">00</span>
                </div>
            </div>
        </div>

        <a href="{{ route('product.list') }}" class="text-gray-500 hover:text-red-600 text-sm font-medium flex items-center gap-1">
            Xem tất cả
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($products as $product)
            <div class="group relative bg-white border border-gray-100 hover:border-red-200 hover:shadow-lg rounded-lg transition p-3 h-full flex flex-col">
                <div class="relative aspect-[4/5] mb-3 overflow-hidden rounded bg-gray-100">
                    {{-- Sửa link trỏ về đúng route shop --}}
                    <a href="{{ route('product.list', ['categorySlug' => $product->categories->first()->slug ?? null]) }}">
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->title }}"
                             class="object-cover w-full h-full group-hover:scale-110 transition duration-500">
                    </a>

                    @if($product->discount_percent > 0)
                        <span class="absolute top-0 left-0 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-br-lg shadow-md">
                            -{{ $product->discount_percent }}%
                        </span>
                    @endif

                    <div class="absolute bottom-2 right-2 text-red-600 bg-white/90 p-1 rounded-full shadow-sm text-xs font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>

                <h4 class="text-xs md:text-sm font-medium text-gray-800 line-clamp-2 mb-2 flex-1">
                    <a href="{{ route('product.list', ['categorySlug' => $product->categories->first()->slug ?? null]) }}" class="hover:text-red-600 transition">{{ $product->title }}</a>
                </h4>

                <div class="flex flex-col mt-auto">
                    <div class="flex items-center gap-2">
                        <span class="text-red-600 font-bold text-sm md:text-base">{{ number_format($product->final_price) }}đ</span>
                        @if($product->sale_price < $product->regular_price)
                            <span class="text-gray-400 text-xs line-through">{{ number_format($product->regular_price) }}đ</span>
                        @endif
                    </div>

                    <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ rand(30, 90) }}%"></div>
                    </div>
                    <div class="text-[10px] text-gray-500 mt-1">Đã bán {{ rand(10, 50) }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
