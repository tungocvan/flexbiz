<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    
    <form wire:submit="save">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    {{ $isEdit ? 'Chỉnh sửa bài viết' : 'Thêm bài viết mới' }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">Điền đầy đủ thông tin để bài viết chuẩn SEO.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all">
                    Hủy bỏ
                </a>
                <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all disabled:opacity-70">
                    <span wire:loading.remove>
                        {{ $isEdit ? 'Cập nhật' : 'Đăng bài viết' }}
                    </span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Đang xử lý...
                    </span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 space-y-8">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                            <input type="text" wire:model.live="name" id="name" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg py-2.5 px-4" placeholder="Nhập tiêu đề hấp dẫn...">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700">Đường dẫn (URL)</label>
                            <div class="mt-2 flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    {{ url('/') }}/blog/
                                </span>
                                <input type="text" wire:model="slug" id="slug" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-600">
                            </div>
                            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="summary" class="block text-sm font-medium text-gray-700">Mô tả ngắn (Sapo)</label>
                            <div class="mt-2 relative">
                                <textarea wire:model="summary" id="summary" rows="3" class="block w-full p-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Tóm tắt nội dung chính để hiển thị trên Google và danh sách bài viết..."></textarea>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Nội dung chi tiết</label>
                            <div class="rounded-lg border border-gray-300 overflow-hidden shadow-sm" wire:ignore>
                                <x-ckeditor wire:model="content" id="post-content" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Tối ưu hóa SEO
                        </h3>
                        
                        <button type="button" wire:click="$set('meta_title', $name); $set('meta_description', $summary)" class="text-xs text-indigo-600 hover:underline cursor-pointer">
                            Tự động điền từ nội dung
                        </button>
                    </div>
                
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Thẻ tiêu đề (Meta Title)
                                <span class="text-xs text-gray-400 font-normal ml-1">(Khuyên dùng: 50-60 ký tự)</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" wire:model="meta_title" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="{{ $name ? $name : 'Mặc định lấy theo tiêu đề bài viết' }}">
                                
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-xs {{ Str::length($meta_title) > 60 ? 'text-red-500' : 'text-gray-400' }}">
                                        {{ Str::length($meta_title) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Thẻ mô tả (Meta Description)
                                <span class="text-xs text-gray-400 font-normal ml-1">(Khuyên dùng: 150-160 ký tự)</span>
                            </label>
                            <div class="mt-1 relative">
                                <textarea wire:model="meta_description" rows="3" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="{{ $summary ? $summary : 'Mặc định lấy theo tóm tắt bài viết' }}"></textarea>
                                
                                <div class="absolute bottom-2 right-2 pointer-events-none">
                                    <span class="text-xs {{ Str::length($meta_description) > 160 ? 'text-red-500' : 'text-gray-400' }}">
                                        {{ Str::length($meta_description) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-4 space-y-8">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Trạng thái hiển thị</h3>
                    <div class="space-y-4">
                        <div>
                            <select wire:model="status" class="block w-full rounded-lg border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option value="published">🟢 Công khai (Published)</option>
                                <option value="draft">⚪ Bản nháp (Draft)</option>
                                <option value="hidden">🔴 Ẩn (Hidden)</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center justify-between py-2 border-t border-gray-100">
                            <span class="flex-grow flex flex-col">
                                <span class="text-sm font-medium text-gray-900">Bài viết nổi bật</span>
                                <span class="text-xs text-gray-500">Ghim lên đầu trang chủ</span>
                            </span>
                            <button type="button" wire:click="$toggle('is_featured')" class="{{ $is_featured ? 'bg-indigo-600' : 'bg-gray-200' }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span aria-hidden="true" class="{{ $is_featured ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Chuyên mục</h3>
                    <div class="max-h-60 overflow-y-auto pr-2 space-y-2 custom-scrollbar">
                        @forelse($categories as $cat)
                            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="checkbox" wire:model="selectedCategories" value="{{ $cat->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-3 text-sm text-gray-700 font-medium">{{ $cat->name }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 italic">Chưa có chuyên mục nào.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.product-categories.index') }}" target="_blank" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Quản lý chuyên mục
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-2">Thẻ (Tags)</h3>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <input type="text" wire:model="inputTags" class="block w-full pl-10 sm:text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2" placeholder="VD: Khuyến mãi, Laptop...">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Phân cách các thẻ bằng dấu phẩy (,)</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Ảnh đại diện</h3>
                    <div class="w-full">
                        <label class="block w-full aspect-[16/9] relative border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 hover:border-indigo-400 transition-all group overflow-hidden bg-gray-50">
                            @if ($new_thumbnail)
                                <img src="{{ $new_thumbnail->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center text-white text-sm font-medium">Thay đổi</div>
                            @elseif($thumbnail)
                                <img src="{{ asset('storage/'.$thumbnail) }}" class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center text-white text-sm font-medium">Thay đổi</div>
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-indigo-600">Tải ảnh lên</span> hoặc kéo thả</p>
                                    <p class="text-xs text-gray-400">PNG, JPG, WEBP (Max 2MB)</p>
                                </div>
                            @endif
                            <input type="file" wire:model="new_thumbnail" class="hidden">
                            
                            <div wire:loading wire:target="new_thumbnail" class="absolute inset-0 bg-white/90 flex flex-col items-center justify-center z-10">
                                <svg class="animate-spin h-8 w-8 text-indigo-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span class="text-xs font-semibold text-indigo-600">Đang xử lý ảnh...</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>