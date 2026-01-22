<div class="mb-24 container mx-auto px-4">

    {{-- Header: Căn giữa cho khác biệt --}}
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 uppercase tracking-tight inline-flex items-center gap-3">
            <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            Bảng Xếp Hạng
            <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
        </h2>
        <p class="text-gray-500 mt-2">Top 5 sản phẩm được săn đón nhiều nhất tuần qua</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- COL LEFT: TOP 1 (Chiếm 5 cột) --}}
        @if($products->isNotEmpty())
            @php $top1 = $products->first(); @endphp
            <div class="lg:col-span-5 relative group">
                {{-- Ranking Badge --}}
                <div class="absolute -top-4 -left-4 z-20 w-16 h-16 md:w-20 md:h-20 bg-yellow-400 text-yellow-900 rounded-full flex flex-col items-center justify-center font-black shadow-lg border-4 border-white rotate-[-10deg]">
                    <span class="text-xs uppercase tracking-wider">TOP</span>
                    <span class="text-3xl md:text-4xl leading-none">1</span>
                </div>

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <a href="{{ route('product.list', ['categorySlug' => $top1->categories->first()->slug ?? null]) }}" class="block relative aspect-square mb-6">
                         {{-- Vòng nguyệt quế trang trí (Optional SVG) --}}
                         <div class="absolute inset-0 bg-yellow-50 rounded-full scale-90 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                         <img src="{{ $top1->image_url }}" alt="{{ $top1->title }}" class="relative z-10 w-full h-full object-contain drop-shadow-md group-hover:scale-110 transition-transform duration-500">
                    </a>

                    <div class="text-xs font-bold text-yellow-600 mb-2 uppercase tracking-wide">Best Seller of the Week</div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-2 hover:text-yellow-600 transition">
                        <a href="#">{{ $top1->title }}</a>
                    </h3>

                    <div class="flex justify-center items-center gap-3 mb-6">
                        <span class="text-3xl font-extrabold text-red-600">{{ number_format($top1->final_price) }}đ</span>
                        @if($top1->sale_price < $top1->regular_price)
                            <span class="text-gray-400 line-through text-lg">{{ number_format($top1->regular_price) }}đ</span>
                        @endif
                    </div>

                    {{-- Sold Progress --}}
                    <div class="w-full bg-gray-100 rounded-full h-3 mb-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-3 rounded-full" style="width: 90%"></div>
                    </div>
                    <div class="flex justify-between text-xs font-medium text-gray-500 mb-6">
                        <span>Đã bán: {{ rand(1000, 5000) }}</span>
                        <span class="text-orange-500">Sắp hết hàng</span>
                    </div>

                    <button wire:click="$dispatch('add-to-cart', {productId: {{ $top1->id }}})" class="w-full py-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-yellow-500 hover:text-black transition shadow-lg">
                        MUA NGAY
                    </button>
                </div>
            </div>
        @endif

        {{-- COL RIGHT: TOP 2-5 (Chiếm 7 cột) --}}
        <div class="lg:col-span-7 flex flex-col gap-4">
            @foreach($products->skip(1) as $index => $product)
                @php
                    $rank = $index + 2;
                    // Màu sắc Badge theo thứ hạng
                    $badgeColor = match($rank) {
                        2 => 'bg-gray-300 text-gray-800', // Bạc
                        3 => 'bg-orange-300 text-orange-900', // Đồng
                        default => 'bg-gray-100 text-gray-600' // Top 4, 5
                    };
                @endphp

                <div class="group flex items-center gap-4 md:gap-6 bg-white p-4 rounded-xl border border-gray-100 hover:shadow-lg hover:border-gray-200 transition-all duration-300">

                    {{-- Rank Number --}}
                    <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-lg {{ $badgeColor }} flex items-center justify-center font-black text-xl md:text-2xl">
                        {{ $rank }}
                    </div>

                    {{-- Image --}}
                    <a href="#" class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 bg-gray-50 rounded-lg overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                    </a>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0"> {{-- min-w-0 để text truncate hoạt động --}}
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-gray-900 truncate hover:text-blue-600 transition mb-1 text-sm md:text-base">
                                    <a href="#">{{ $product->title }}</a>
                                </h4>
                                {{-- Rating --}}
                                <div class="flex items-center gap-1 text-xs text-yellow-500 mb-1">
                                    ★★★★★ <span class="text-gray-400 text-[10px]">(120)</span>
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="text-right">
                                <div class="font-bold text-gray-900">{{ number_format($product->final_price) }}đ</div>
                                @if($product->sale_price < $product->regular_price)
                                    <div class="text-xs text-gray-400 line-through">{{ number_format($product->regular_price) }}đ</div>
                                @endif
                            </div>
                        </div>

                        {{-- Sold Bar Mini --}}
                        <div class="mt-2 flex items-center gap-3">
                            <div class="flex-1 bg-gray-100 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ rand(40, 80) }}%"></div>
                            </div>
                            <span class="text-[10px] text-gray-500 whitespace-nowrap">Đã bán {{ rand(100, 900) }}+</span>
                        </div>
                    </div>

                    {{-- Action Button (Chỉ hiện icon trên mobile, hiện chữ trên desktop) --}}
                    <button wire:click="$dispatch('add-to-cart', {productId: {{ $product->id }}})"
                            class="flex-shrink-0 p-3 rounded-lg bg-gray-50 text-gray-900 hover:bg-gray-900 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
