<div>
    {{-- ==========================================
         STYLE 1: CIRCLE ORANGE (Dùng cho BestSellers, Grid)
         ========================================== --}}
    @if($style === 'circle-orange')
        <button wire:click.prevent.stop="addToCart"
                wire:loading.attr="disabled"
                class="w-10 h-10 md:w-12 md:h-12 bg-orange-600 hover:bg-orange-700 text-white rounded-full shadow-lg flex items-center justify-center transform hover:scale-110 transition-transform focus:outline-none ring-2 ring-white ring-offset-2 ring-offset-orange-100 cursor-pointer"
                title="Thêm vào giỏ hàng">

            {{-- Icon Giỏ hàng (Hiện khi bình thường) --}}
            <svg wire:loading.remove wire:target="addToCart" class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>

            {{-- Icon Loading (Hiện khi đang xử lý) --}}
            <svg wire:loading wire:target="addToCart" class="animate-spin w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>


    {{-- ==========================================
         STYLE 2: DEFAULT (Code cũ của bạn - Trang chi tiết)
         ========================================== --}}
    @else
        <div class="mt-6">
            {{-- Thông báo thành công (Flash Message cũ) --}}
            @if (session()->has('success'))
                <div class="mb-3 text-sm text-green-600 font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center gap-4">
                {{-- Input số lượng --}}
                <div class="w-20">
                    <input type="number" wire:model="quantity" min="1"
                           class="w-full border border-gray-300 rounded p-3 text-center focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Button Thêm --}}
                <button wire:click="addToCart"
                        wire:loading.attr="disabled"
                        class="flex-1 bg-blue-600 text-white font-bold py-3 px-8 rounded hover:bg-blue-700 transition cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed flex items-center justify-center gap-2">

                    <span wire:loading.remove wire:target="addToCart">Thêm vào giỏ hàng</span>

                    <span wire:loading wire:target="addToCart" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Đang xử lý...
                    </span>
                </button>
            </div>
        </div>
    @endif
</div>
