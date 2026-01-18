<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                {{ $menuId ? 'Chỉnh sửa Menu' : 'Thêm Menu mới' }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Quản lý cấu trúc hiển thị trên thanh Sidebar.</p>
        </div>
        <a href="{{ route('admin.menus.index') }}"
           class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                <div class="p-6 space-y-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 border-b pb-2">Thông tin hiển thị</h3>

                    <div>
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Tên Menu <span class="text-red-500">*</span></label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                            </div>
                            <input type="text" wire:model="name" id="name"
                                class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder="Ví dụ: Sản phẩm">
                        </div>
                        @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="url" class="block text-sm font-medium leading-6 text-gray-900">Đường dẫn (URL) <span class="text-red-500">*</span></label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </span>
                            </div>
                            <input type="text" wire:model="url" id="url"
                                class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder="/admin/...">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Dùng <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600">#</code> nếu là menu cha không có link.</p>
                        @error('url') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-medium leading-6 text-gray-900">SVG Icon Code</label>
                        <a href="https://heroicons.com/" target="_blank" class="text-xs font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                            Lấy icon tại Heroicons
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-3">
                            <div class="relative rounded-md shadow-sm">
                                <textarea wire:model.live="icon" rows="6"
                                    class="block w-full rounded-md border-0 bg-slate-900 text-green-400 font-mono text-xs py-3 px-4 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:leading-6 custom-scrollbar"
                                    placeholder='<svg class="w-6 h-6" ...></svg>'></textarea>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Paste toàn bộ thẻ <code>&lt;svg&gt;...&lt;/svg&gt;</code> vào đây.</p>
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-xs font-medium text-gray-500 mb-2 text-center">Xem trước</label>
                            <div class="aspect-square rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center relative overflow-hidden">
                                @if($icon)
                                    <div class="text-gray-800 transform scale-150 transition-transform duration-300">
                                        {!! $icon !!}
                                    </div>
                                    <div class="absolute bottom-2 text-[10px] text-green-600 font-bold bg-green-100 px-2 rounded-full">Valid</div>
                                @else
                                    <span class="text-gray-400 text-xs text-center px-2">Chưa có icon</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 border-b pb-2">Cấu hình</h3>

                <div class="mb-5">
                    <label class="block text-sm font-medium leading-6 text-gray-900 mb-2">Vị trí (Menu Cha)</label>
                    <div class="relative">
                        <select wire:model="parent_id" class="block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="">-- Là Menu gốc (Root) --</option>
                            @foreach($this->parents as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium leading-6 text-gray-900 mb-2">Thứ tự hiển thị</label>
                    <div class="flex items-center">
                        <button type="button" wire:click="decreaseOrder"  class="p-2 border border-gray-300 rounded-l-md bg-gray-50 hover:bg-gray-100 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </button>
                        <input wire:model="sort_order" type="number" class="block w-full text-center border-y border-gray-300 py-2 text-gray-900 focus:ring-0 sm:text-sm font-bold border-x-0">
                        <button type="button" wire:click="increaseOrder"  class="p-2 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="mb-2 pt-2 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900">Hiển thị</span>
                            <span class="text-xs text-gray-500">Bật/Tắt trên Sidebar</span>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.menus.index') }}" class="flex-1 rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 text-center">
                    Hủy bỏ
                </a>
                <button type="submit" class="flex-1 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex justify-center items-center">
                    <span wire:loading.remove>Lưu Menu</span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Đang lưu...
                    </span>
                </button>
            </div>

        </div>
    </form>
</div>
