<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10" x-data="{ activeImage: '{{ $product->image }}' }">

        <div class="space-y-4">
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200 relative group">
                <img :src="activeImage"
                     alt="{{ $product->title }}"
                     class="w-full h-full object-cover object-center transition-all duration-300"
                >

                @if($product->discount_percent > 0)
                    <span class="absolute top-4 right-4 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded shadow-md">
                        -{{ $product->discount_percent }}%
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-5 gap-4">

                <div @click="activeImage = '{{ $product->image }}'"
                     class="aspect-square rounded cursor-pointer border-2 overflow-hidden hover:opacity-80 transition"
                     :class="activeImage === '{{ $product->image }}' ? 'border-blue-600 ring-1 ring-blue-600' : 'border-transparent bg-gray-100'">
                    <img src="{{ $product->image }}" class="w-full h-full object-cover">
                </div>

                @if(!empty($product->gallery))
                    @foreach($product->gallery as $img)
                        <div @click="activeImage = '{{ $img }}'"
                             class="aspect-square rounded cursor-pointer border-2 overflow-hidden hover:opacity-80 transition"
                             :class="activeImage === '{{ $img }}' ? 'border-blue-600 ring-1 ring-blue-600' : 'border-transparent bg-gray-100'">
                            <img src="{{ $img }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

        <div class="space-y-6">
            <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $product->title }}</h1>

            <div class="flex items-end gap-3 pb-4 border-b border-gray-100">
                @if($product->sale_price && $product->sale_price < $product->regular_price)
                    <p class="text-3xl font-bold text-red-600">{{ number_format($product->sale_price) }}đ</p>
                    <p class="text-xl text-gray-400 line-through mb-1">{{ number_format($product->regular_price) }}đ</p>
                @else
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($product->regular_price) }}đ</p>
                @endif
            </div>

            <div class="prose prose-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                {!! $product->short_description !!}
            </div>

            <div class="pt-2">
                 @livewire('website.cart.add-to-cart', ['productId' => $product->id])
            </div>

            <div class="pt-8 border-t border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    Chi tiết sản phẩm
                </h3>
                <div class="prose max-w-none text-gray-600">
                    {!! $product->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
