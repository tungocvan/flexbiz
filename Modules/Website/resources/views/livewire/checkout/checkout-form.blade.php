<form wire:submit="placeOrder" class="space-y-6">

    @if($errors->has('system'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ $errors->first('system') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold mb-4">Thông tin giao hàng</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-2 md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                <input type="text" wire:model="customer_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border">
                @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
                <input type="text" wire:model="customer_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border">
                @error('customer_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Email (Tùy chọn)</label>
                <input type="email" wire:model="customer_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border">
                @error('customer_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Địa chỉ nhận hàng <span class="text-red-500">*</span></label>
                <input type="text" wire:model="customer_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border">
                @error('customer_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Ghi chú đơn hàng</label>
                <textarea wire:model="note" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"></textarea>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold mb-4">Phương thức thanh toán</h2>
        <div class="flex items-center">
            <input id="cod" name="payment_method" type="radio" checked class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
            <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                Thanh toán khi nhận hàng (COD)
            </label>
        </div>
    </div>

    <button type="submit"
            wire:loading.attr="disabled"
            class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition shadow-lg text-lg uppercase">
        <span wire:loading.remove>Đặt hàng ngay</span>
        <span wire:loading>Đang xử lý...</span>
    </button>
</form>
