<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Sản phẩm nổi bật</h2>

    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded shadow-lg z-50 animate-bounce">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 overflow-hidden group flex flex-col h-full">
                <div class="relative aspect-square overflow-hidden bg-gray-200">
                    <a href="{{ route('website.product.detail', $product->slug) }}" class="block w-full h-full">
                        <img src="{{ $product->image }}"
                             alt="{{ $product->title }}"
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-300">
                    </a>

                    @if($product->discount_percent > 0)
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            -{{ $product->discount_percent }}%
                        </span>
                    @endif

                    <button wire:click="addToCart({{ $product->id }})"
                            wire:loading.attr="disabled"
                            class="absolute bottom-2 right-2 bg-blue-600 text-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-blue-700 translate-y-2 group-hover:translate-y-0 cursor-pointer hidden md:block"
                            title="Thêm vào giỏ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 flex flex-col flex-1">
                    <h3 class="text-sm font-medium text-gray-900 line-clamp-2 mb-2">
                        <a href="{{ route('website.product.detail', $product->slug) }}">
                            {{ $product->title }}
                        </a>
                    </h3>

                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-3">
                            @if($product->sale_price && $product->sale_price < $product->regular_price)
                                <span class="text-lg font-bold text-red-600">
                                    {{ number_format($product->sale_price) }}đ
                                </span>
                                <span class="text-sm text-gray-500 line-through">
                                    {{ number_format($product->regular_price) }}đ
                                </span>
                            @else
                                <span class="text-lg font-bold text-gray-900">
                                    {{ number_format($product->regular_price) }}đ
                                </span>
                            @endif
                        </div>

                        <button wire:click="addToCart({{ $product->id }})"
                                wire:loading.attr="disabled"
                                class="w-full block text-center bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-800 font-medium py-2 rounded transition-colors duration-200 cursor-pointer">
                            <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Thêm vào giỏ</span>
                            <span wire:loading wire:target="addToCart({{ $product->id }})">Đang xử lý...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
