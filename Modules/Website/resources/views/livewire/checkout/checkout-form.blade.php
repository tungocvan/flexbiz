<form wire:submit="placeOrder" class="space-y-6">

    @if($errors->has('system'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ $errors->first('system') }}
        </div>
    @endif

    @guest
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Bạn đã có tài khoản?
                        <a href="{{ route('login') }}?redirect=checkout" class="font-bold underline hover:text-blue-800">Đăng nhập ngay</a>
                        để lưu đơn hàng vào tài khoản của bạn.
                    </p>
                </div>
            </div>
        </div>
    @endguest

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

        <div class="space-y-4">
            <label class="flex items-center p-3 border border-gray-200 rounded cursor-pointer hover:bg-gray-50 transition">
                <input wire:model="payment_method" value="cod" type="radio" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <span class="ml-3 block text-sm font-medium text-gray-700">
                    Thanh toán khi nhận hàng (COD)
                </span>
            </label>

            <label class="flex items-center p-3 border border-gray-200 rounded cursor-pointer hover:bg-gray-50 transition">
                <input wire:model="payment_method" value="momo" type="radio" class="h-4 w-4 text-pink-600 border-gray-300 focus:ring-pink-500">
                <div class="ml-3 flex items-center gap-2">
                    <span class="block text-sm font-medium text-gray-700">Ví điện tử MoMo</span>
                    <img src="https://developers.momo.vn/v3/img/logo.svg" class="h-5 w-auto" alt="Momo">
                </div>
            </label>
        </div>

        @error('payment_method')
            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit"
            wire:loading.attr="disabled"
            class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition shadow-lg text-lg uppercase">
        <span wire:loading.remove>Đặt hàng ngay</span>
        <span wire:loading>Đang xử lý...</span>
    </button>
</form>
