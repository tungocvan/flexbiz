<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="text-gray-500 text-sm font-medium">Tổng đơn hàng</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalOrders }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium">Doanh thu</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($revenue) }} VNĐ</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="text-gray-500 text-sm font-medium">Sản phẩm</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">45</div>
    </div>
</div>
