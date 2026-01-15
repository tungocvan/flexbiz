<div class="py-12 bg-gray-50" x-data="{ activeImg: '{{ $product->image_url }}', activeTab: 'description' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col lg:flex-row gap-12 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">

            <div class="w-full lg:w-1/2 space-y-6">
                <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 flex items-center justify-center p-4">
                    <img :src="activeImg" class="max-w-full max-h-full object-contain transition-all duration-500 ease-in-out">
                </div>

                @if(count($product->gallery_urls) > 0)
                <div class="grid grid-cols-5 gap-4">
                    <div @click="activeImg = '{{ $product->image_url }}'"
                         :class="activeImg === '{{ $product->image_url }}' ? 'ring-2 ring-blue-600' : 'opacity-60'"
                         class="aspect-square rounded-xl border cursor-pointer overflow-hidden transition-all">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                    </div>
                    @foreach($product->gallery_urls as $url)
                    <div @click="activeImg = '{{ $url }}'"
                         :class="activeImg === '{{ $url }}' ? 'ring-2 ring-blue-600' : 'opacity-60'"
                         class="aspect-square rounded-xl border cursor-pointer overflow-hidden transition-all">
                        <img src="{{ $url }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="w-full lg:w-1/2 flex flex-col">
                <div class="mb-6 pb-6 border-b border-gray-100">
                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full mb-3 uppercase tracking-wider">
                        {{ $product->categories->first()->name ?? 'Sản phẩm' }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $product->title }}</h1>

                    <div class="flex items-center gap-4 mt-4">
                        @if($product->sale_price)
                            <span class="text-3xl font-black text-blue-600">{{ number_format($product->sale_price) }}đ</span>
                            <span class="text-lg text-gray-400 line-through">{{ number_format($product->regular_price) }}đ</span>
                        @else
                            <span class="text-3xl font-black text-gray-900">{{ number_format($product->regular_price) }}đ</span>
                        @endif
                    </div>
                </div>

                <div class="text-gray-600 text-sm leading-relaxed mb-8">
                    {!! $product->short_description !!}
                </div>

                <div class="mt-auto space-y-6">
                    <div class="flex items-center gap-6">
                        <span class="text-sm font-bold text-gray-700">Số lượng:</span>
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                            <button wire:click="decrement" class="px-4 py-2 hover:bg-gray-200 transition text-gray-600">-</button>
                            <span class="px-6 font-bold text-gray-900">{{ $quantity }}</span>
                            <button wire:click="increment" class="px-4 py-2 hover:bg-gray-200 transition text-gray-600">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button wire:click="addToCart" class="flex-1 bg-gray-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-black transform active:scale-95 transition-all flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Thêm vào giỏ hàng
                        </button>
                        <button class="px-8 py-4 bg-blue-50 text-blue-600 rounded-2xl font-bold hover:bg-blue-100 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex border-b border-gray-100 bg-gray-50/50">
                <button @click="activeTab = 'description'" :class="activeTab === 'description' ? 'border-blue-600 text-blue-600 bg-white' : 'border-transparent text-gray-500'" class="px-8 py-4 font-bold text-sm border-b-2 transition-all">
                    Mô tả sản phẩm
                </button>
                <button @click="activeTab = 'reviews'" :class="activeTab === 'reviews' ? 'border-blue-600 text-blue-600 bg-white' : 'border-transparent text-gray-500'" class="px-8 py-4 font-bold text-sm border-b-2 transition-all">
                    Đánh giá khách hàng
                </button>
            </div>
            <div class="p-8">
                <div x-show="activeTab === 'description'" x-transition class="prose max-w-none text-gray-600">
                    {!! $product->description !!}
                </div>
                <div x-show="activeTab === 'reviews'" x-transition class="text-gray-500 italic">
                    Chưa có đánh giá nào cho sản phẩm này.
                </div>
            </div>
        </div>
    </div>
</div>
