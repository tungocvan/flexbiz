<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Giỏ hàng của bạn</h1>

    @if($items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($items as $item)
                    <div class="flex items-center gap-4 bg-white p-4 rounded-lg shadow">

                        <img src="{{ $item->product->image_url ?? asset('images/placeholder.jpg') }}"
                                             alt="{{ $item->product->title }}" class="w-20 h-20 object-cover rounded">`
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800">{{ $item->product->title }}</h3>
                            <p class="text-gray-500 text-sm">{{ number_format($item->price) }}đ</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="decrement({{ $item->id }})" class="p-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                            <span class="w-8 text-center font-bold">{{ $item->quantity }}</span>
                            <button wire:click="increment({{ $item->id }})" class="p-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                        </div>

                        <div class="text-right w-24">
                            <p class="font-bold text-blue-600">{{ number_format($item->total) }}đ</p>
                            <button wire:click="remove({{ $item->id }})" class="text-xs text-red-500 hover:underline mt-1">Xóa</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-6 rounded-lg shadow h-fit">
                <h3 class="text-xl font-bold mb-4">Tổng cộng</h3>
                <div class="flex justify-between mb-2">
                    <span>Tạm tính:</span>
                    <span class="font-bold">{{ number_format($total) }}đ</span>
                </div>
                <div class="border-t my-4"></div>
                <div class="flex justify-between mb-6 text-lg font-bold">
                    <span>Thành tiền:</span>
                    <span class="text-blue-600">{{ number_format($total) }}đ</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 text-white text-center font-bold py-3 rounded hover:bg-blue-700 transition">
                    Tiến hành đặt hàng
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <p class="text-gray-500 mb-4">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('home') }}" class="text-blue-600 font-bold hover:underline">Tiếp tục mua sắm</a>
        </div>
    @endif
</div>
