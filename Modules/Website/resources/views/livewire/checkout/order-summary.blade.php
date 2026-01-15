<div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Đơn hàng của bạn</h3>

    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto">
        @foreach($items as $item)
            <div class="flex gap-3">
                <div class="w-16 h-16 bg-white rounded border overflow-hidden shrink-0">
                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-800 line-clamp-2">{{ $item->product->title }}</h4>
                    <div class="flex justify-between mt-1 text-sm">
                        <span class="text-gray-500">x{{ $item->quantity }}</span>
                        <span class="font-bold text-gray-900">{{ number_format($item->total) }}đ</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="border-t border-gray-200 pt-4 space-y-2">
        <div class="flex justify-between text-sm">
            <span class="text-gray-600">Tạm tính</span>
            <span class="font-medium">{{ number_format($total) }}đ</span>
        </div>
        <div class="flex justify-between text-sm">
            <span class="text-gray-600">Phí vận chuyển</span>
            <span class="font-medium text-green-600">Miễn phí</span>
        </div>
        <div class="border-t border-gray-200 pt-2 flex justify-between text-lg font-bold">
            <span>Tổng cộng</span>
            <span class="text-blue-600">{{ number_format($total) }}đ</span>
        </div>
    </div>
</div>
