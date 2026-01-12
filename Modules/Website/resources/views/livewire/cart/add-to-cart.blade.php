<div class="mt-6">
    @if (session()->has('success'))
        <div class="mb-3 text-sm text-green-600 font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center gap-4">
        <div class="w-20">
            <input type="number" wire:model="quantity" min="1" class="w-full border border-gray-300 rounded p-2 text-center">
        </div>
        <button wire:click="addToCart"
                class="flex-1 bg-blue-600 text-white font-bold py-3 px-8 rounded hover:bg-blue-700 transition cursor-pointer">
            Thêm vào giỏ hàng
        </button>
    </div>
</div>
