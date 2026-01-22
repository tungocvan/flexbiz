<div class="mb-20">
    {{-- Header Section: Tiêu đề + Tabs/Link --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <span class="bg-black text-white w-8 h-8 flex items-center justify-center rounded-lg text-lg">★</span>
                Sản Phẩm Nổi Bật
            </h2>
            <p class="text-gray-500 text-sm mt-2">Những lựa chọn tốt nhất được khách hàng yêu thích tuần qua</p>
        </div>

        {{-- Link Xem tất cả --}}
        <a href="{{ route('product.list') }}" class="group flex items-center gap-2 text-sm font-semibold text-gray-900 hover:text-green-600 transition-colors">
            Xem toàn bộ shop
            <span class="bg-gray-100 group-hover:bg-green-100 text-gray-600 group-hover:text-green-600 w-6 h-6 flex items-center justify-center rounded-full transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </span>
        </a>
    </div>

    {{-- Product Grid: 2 cột mobile, 4 cột tablet, 5 cột desktop (Chuẩn Ecommerce) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-8 md:gap-x-6">

        @foreach($products as $product)
            <div class="group relative">
                {{-- 1. IMAGE CONTAINER --}}
                <div class="relative w-full aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-4 border border-gray-100">

                    {{-- Ảnh sản phẩm (Zoom nhẹ khi hover) --}}
                    <a href="{{ route('product.list', ['categorySlug' => $product->categories->first()->slug ?? null]) }}" class="block w-full h-full">
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->title }}"
                             class="w-full h-full object-cover object-center transition-transform duration-700 ease-in-out group-hover:scale-105"
                             loading="lazy">
                    </a>

                    {{-- Badges (Absolute Top Left) --}}
                    <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                        @if($product->sale_price < $product->regular_price)
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-red-500 text-white text-[10px] font-bold shadow-sm">
                                -{{ $product->discount_percent }}%
                            </span>
                        @endif
                        @if(collect($product->tags)->contains('new'))
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-blue-500 text-white text-[10px] font-bold shadow-sm">
                                NEW
                            </span>
                        @endif
                    </div>

                    {{-- Wishlist Button (Absolute Top Right - Hiện sẵn hoặc hiện khi hover) --}}
                    <button class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>

                    {{-- Quick Action Bar (Bay từ dưới lên khi hover) --}}
                    <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out z-10">
                        <button wire:click="addToCart({{ $product->id }})"
                                class="w-full bg-black/90 backdrop-blur text-white text-sm font-semibold py-3 rounded-lg shadow-lg hover:bg-green-600 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Thêm vào giỏ
                        </button>
                    </div>
                </div>

                {{-- 2. PRODUCT INFO --}}
                <div>
                    {{-- Category --}}
                    <div class="text-[11px] text-gray-400 uppercase tracking-wider mb-1 font-medium">
                        {{ $product->categories->first()->name ?? 'Uncategorized' }}
                    </div>

                    {{-- Title --}}
                    <h3 class="text-sm font-bold text-gray-900 leading-snug mb-1.5 min-h-[40px] line-clamp-2 group-hover:text-green-600 transition-colors">
                        <a href="{{ route('product.list', ['categorySlug' => $product->categories->first()->slug ?? null]) }}">
                            {{ $product->title }}
                        </a>
                    </h3>

                    {{-- Rating Stars (Static Mockup) --}}
                    <div class="flex items-center gap-1 mb-2">
                        <div class="flex text-yellow-400 text-xs">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <span class="text-[10px] text-gray-400">(4.8)</span>
                    </div>

                    {{-- Price --}}
                    <div class="flex items-center gap-2">
                        @if($product->sale_price > 0 && $product->sale_price < $product->regular_price)
                            <span class="font-extrabold text-gray-900">{{ number_format($product->sale_price) }}đ</span>
                            <span class="text-xs text-gray-400 line-through">{{ number_format($product->regular_price) }}đ</span>
                        @else
                            <span class="font-extrabold text-gray-900">{{ number_format($product->regular_price) }}đ</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Nút tải thêm (Optional) --}}
    <div class="mt-12 text-center">
        <a href="{{ route('product.list') }}" class="inline-block px-8 py-3 border border-gray-200 bg-white text-gray-900 font-semibold rounded-full hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-300">
            Xem tất cả sản phẩm
        </a>
    </div>
</div>
