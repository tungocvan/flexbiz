@props(['product'])

<div class="group relative flex flex-col h-full">
    {{-- 1. IMAGE CONTAINER --}}
    <div class="relative w-full aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-4 border border-gray-100">
        {{-- Ảnh sản phẩm --}}
        <a href="{{ Route::has('product.detail') ? route('product.detail', ['slug' => $product->slug]) : '#' }}" class="block w-full h-full">
            {{-- Xử lý link ảnh (Online hoặc Storage) --}}
            @php
                $imgUrl = $product->image ? (\Illuminate\Support\Str::startsWith($product->image, ['http', 'https']) ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/400x600';
            @endphp
            <img src="{{ $imgUrl }}"
                 alt="{{ $product->title }}"
                 loading="lazy"
                 class="w-full h-full object-cover object-center transition-transform duration-700 ease-in-out group-hover:scale-105">
        </a>

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
            @if($product->sale_price < $product->regular_price && $product->regular_price > 0)
                @php $percent = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100); @endphp
                <span class="inline-flex items-center px-2 py-1 rounded-md bg-red-500 text-white text-[10px] font-bold shadow-sm">
                    -{{ $percent }}%
                </span>
            @endif
            @if($product->created_at > now()->subDays(7))
                <span class="inline-flex items-center px-2 py-1 rounded-md bg-blue-500 text-white text-[10px] font-bold shadow-sm">
                    NEW
                </span>
            @endif
        </div>

        {{-- Wishlist Button --}}
        <button class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 duration-300 z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </button>

        {{-- Quick Add Cart (Livewire Component) --}}
        {{-- Đã đổi vị trí sang góc phải dưới để hợp với style nút tròn 'circle-orange' --}}
        <div class="absolute bottom-3 right-3 z-30 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
            @livewire(
                'website.cart.add-to-cart',
                [
                    'productId' => $product->id,
                    'style' => 'circle-orange',
                ],
                key('p-card-add-' . $product->id)
            )
        </div>
    </div>

    {{-- 2. PRODUCT INFO --}}
    <div class="flex-1 flex flex-col">
        {{-- Category (Nếu có relation) --}}
        <div class="text-[11px] text-gray-400 uppercase tracking-wider mb-1 font-medium">
             {{-- Giả sử quan hệ categories đã được load --}}
             {{ $product->categories->first()->name ?? 'Sản phẩm' }}
        </div>

        {{-- Title --}}
        <h3 class="text-sm font-bold text-gray-900 leading-snug mb-1.5 line-clamp-2 group-hover:text-green-600 transition-colors min-h-[40px]">
            <a href="{{ Route::has('product.detail') ? route('product.detail', ['slug' => $product->slug]) : '#' }}">
                {{ $product->title }}
            </a>
        </h3>

        {{-- Rating (Mockup) --}}
        <div class="flex items-center gap-1 mb-2">
            <div class="flex text-yellow-400 text-xs">
                @for($i=0; $i<5; $i++) <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> @endfor
            </div>
            <span class="text-[10px] text-gray-400">(5.0)</span>
        </div>

        {{-- Price --}}
        <div class="mt-auto flex items-center gap-2">
            <span class="font-extrabold text-gray-900">{{ number_format($product->sale_price ?? $product->regular_price, 0, ',', '.') }}đ</span>
            @if($product->sale_price < $product->regular_price)
                <span class="text-xs text-gray-400 line-through">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
            @endif
        </div>
    </div>
</div>
