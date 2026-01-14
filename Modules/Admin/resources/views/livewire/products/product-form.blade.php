<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                {{ $productId ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Điền đầy đủ thông tin để hiển thị sản phẩm trên website.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition-all">
                Hủy bỏ
            </a>
            <button wire:click="save"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition-all">
                <span wire:loading.remove>Lưu Sản Phẩm</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Đang xử lý...
                </span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                <div class="p-6 space-y-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 border-b pb-2">Thông tin chung</h3>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Tên sản phẩm <span class="text-red-500">*</span></label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <input type="text" wire:model.live="title"
                                class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder="Nhập tên sản phẩm...">
                        </div>
                        @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Đường dẫn (Slug)</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <input type="text" wire:model="slug"
                                class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-50">
                        </div>
                        @error('slug') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Mô tả ngắn</label>
                        <div class="mt-2">
                            <textarea wire:model="short_description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>

                    <div>
                        <x-ckeditor
                            label="Chi tiết sản phẩm"
                            wire:model="description"
                        />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 border-b pb-2 mb-4">Thư viện ảnh (Gallery)</h3>

                    <div class="flex items-center justify-center w-full mb-6">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm text-gray-500 font-medium">Bấm để tải nhiều ảnh lên</p>
                                <p class="text-xs text-gray-400">SVG, PNG, JPG (Max. 5MB)</p>
                            </div>
                            <input wire:model="newGallery" type="file" multiple class="hidden" />
                        </label>
                    </div>

                    @if(count($gallery) > 0 || count($newGallery) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($gallery as $index => $img)
                                <div class="relative group aspect-square bg-gray-100 rounded-lg overflow-hidden border">
                                    <img src="{{ Illuminate\Support\Str::startsWith($img, ['http']) ? $img : asset('storage/'.$img) }}" class="w-full h-full object-cover">
                                    <button type="button" wire:click="removeOldGallery({{ $index }})"
                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @endforeach

                            @foreach($newGallery as $index => $img)
                                <div class="relative group aspect-square bg-gray-100 rounded-lg overflow-hidden border border-indigo-500 ring-2 ring-indigo-500/20">
                                    <img src="{{ $img->temporaryUrl() }}" class="w-full h-full object-cover">
                                    <button type="button" wire:click="removeNewGallery({{ $index }})"
                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <div class="absolute bottom-0 inset-x-0 bg-indigo-600/80 text-white text-[10px] text-center font-bold py-0.5">MỚI</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                         <div class="text-center py-4 text-sm text-gray-400 italic bg-gray-50 rounded-lg">Chưa có ảnh nào trong thư viện.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 border-b pb-2">Thiết lập bán hàng</h3>

                <div class="flex items-center justify-between mb-6">
                    <span class="flex-grow flex flex-col">
                        <span class="text-sm font-medium text-gray-900">Hiển thị</span>
                        <span class="text-xs text-gray-500">Bật để khách hàng thấy sản phẩm</span>
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium leading-6 text-gray-900">Giá bán thường <span class="text-red-500">*</span></label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm font-bold">₫</span>
                        </div>
                        <input type="number" wire:model="regular_price"
                            class="block w-full rounded-md border-0 py-2 pl-8 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-semibold"
                            placeholder="0">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 sm:text-xs">VNĐ</span>
                        </div>
                    </div>
                    @error('regular_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-900">Giá khuyến mãi</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                             <span class="text-red-500 sm:text-sm font-bold">₫</span>
                        </div>
                        <input type="number" wire:model="sale_price"
                            class="block w-full rounded-md border-0 py-2 pl-8 pr-12 text-red-600 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-semibold"
                            placeholder="0">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 sm:text-xs">VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 border-b pb-2">Phân loại</h3>

                <div class="mb-5">
                    <label class="block text-sm font-medium leading-6 text-gray-900 mb-2">Danh mục sản phẩm</label>
                    <div class="max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50 custom-scrollbar shadow-inner">
                        @forelse($this->categories as $cat)
                            <label class="flex items-center space-x-3 p-1.5 hover:bg-gray-100 rounded cursor-pointer transition">
                                <input type="checkbox" wire:model="category_ids" value="{{ $cat->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 transition">
                                <span class="text-sm text-gray-700 font-medium">{{ $cat->name }}</span>
                            </label>
                        @empty
                            <p class="text-xs text-gray-400 italic text-center">Chưa có danh mục nào.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-900 mb-2">Tags / Từ khóa</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </div>
                        <input type="text"
                            wire:model="tagInput"
                            wire:keydown.enter.prevent="addTag"
                            placeholder="Nhập rồi Enter..."
                            class="block w-full rounded-md border-0 py-2 pl-9 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>

                    @if(count($tags) > 0)
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($tags as $index => $tag)
                                <span class="inline-flex items-center gap-x-1 rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                    {{ $tag }}
                                    <button type="button" wire:click="removeTag({{ $index }})" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-indigo-600/20">
                                        <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-indigo-700/50 group-hover:stroke-indigo-700/75"><path d="M4 4l6 6m0-6l-6 6" /></svg>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 border-b pb-2">Ảnh đại diện</h3>

                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 relative bg-gray-50 hover:bg-gray-100 transition cursor-pointer group"
                        onclick="document.getElementById('main-image-upload').click()">

                    @if ($newImage)
                        <img src="{{ $newImage->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-contain rounded-lg p-2 z-10">
                        <button type="button" wire:click.stop="$set('newImage', null)" class="absolute top-2 right-2 bg-white text-red-500 rounded-full p-1 shadow hover:bg-red-50 z-20">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    @elseif ($oldImage)
                        <img src="{{ Illuminate\Support\Str::startsWith($oldImage, ['http']) ? $oldImage : asset('storage/'.$oldImage) }}" class="absolute inset-0 w-full h-full object-contain rounded-lg p-2 z-10">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition z-20 rounded-lg">
                            <span class="text-white font-medium text-sm">Thay đổi ảnh</span>
                        </div>
                    @else
                        <div class="text-center z-0">
                            <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                <span class="relative rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                    <span>Tải ảnh lên</span>
                                </span>
                            </div>
                        </div>
                    @endif
                    <input id="main-image-upload" wire:model="newImage" type="file" class="hidden">
                </div>
                <div wire:loading wire:target="newImage" class="text-xs text-blue-500 mt-2 text-center w-full">Đang tải ảnh lên...</div>
                @error('newImage') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

        </div>
    </div>
</div>
