<div>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-800">Cấu hình Menu Sidebar</h2>
        
        <div class="flex items-center gap-2">
            <button wire:click="export" wire:loading.attr="disabled" class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 text-sm font-medium flex items-center transition shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export JSON
            </button>

            <button wire:click="$toggle('isImporting')" class="bg-yellow-500 text-white px-3 py-2 rounded-lg hover:bg-yellow-600 text-sm font-medium flex items-center transition shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import JSON
            </button>

            <a href="{{ route('admin.menus.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium flex items-center shadow-sm text-sm">
                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Thêm Menu
            </a>
        </div>
        @if($isImporting)
        <div class="mb-6 p-5 bg-yellow-50 border border-yellow-200 rounded-xl animate-fade-in-down relative"> <button 
                wire:click="$set('isImporting', false)" 
                class="absolute top-2 right-2 text-yellow-500 hover:text-red-500 hover:bg-yellow-100 p-1.5 rounded-full transition duration-200"
                title="Đóng khung nhập liệu">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h3 class="font-bold text-yellow-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Nhập dữ liệu Menu (File .json)
            </h3>

            <div class="flex items-center gap-4">
                <input type="file" wire:model="importFile" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-100 file:text-yellow-700 hover:file:bg-yellow-200 cursor-pointer">
                
                <button wire:click="import" wire:loading.attr="disabled" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 font-medium text-sm whitespace-nowrap disabled:opacity-50 shadow-sm transition">
                    <span wire:loading.remove wire:target="import">Tiến hành Import</span>
                    <span wire:loading wire:target="import">Đang xử lý...</span>
                </button>
            </div>
            
            @error('importFile') <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span> @enderror
            
            <p class="text-xs text-yellow-600 mt-3 italic flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Hệ thống sẽ tự động kiểm tra trùng lặp (Tên + URL). Nếu đã tồn tại sẽ bỏ qua để tránh trùng dữ liệu.
            </p>
        </div>
    @endif

         @if (session()->has('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Thành công!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Menu / Icon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thứ tự</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($menus as $parent)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 text-gray-500 bg-gray-100 rounded flex items-center justify-center">
                                    @if($parent->icon) {!! $parent->icon !!} @else <span class="font-bold text-xs">IMG</span> @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $parent->name }}</div>
                                    <div class="text-xs text-gray-500">Menu Cha</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono bg-gray-50 rounded mx-2">
                            {{ $parent->url }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-bold">
                            {{ $parent->sort_order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button wire:click="toggleStatus({{ $parent->id }})" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $parent->is_active ? 'bg-green-500' : 'bg-gray-200' }}">
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $parent->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.menus.edit', $parent->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Sửa</a>
                            <button wire:confirm="Xóa menu này?" wire:click="delete({{ $parent->id }})" class="text-red-600 hover:text-red-900 font-semibold">Xóa</button>
                        </td>
                    </tr>

                    @foreach($parent->children as $child)
                        <tr class="bg-slate-50 hover:bg-slate-100">
                            <td class="px-6 py-3 whitespace-nowrap pl-12"> <div class="flex items-center relative">
                                    <span class="absolute -left-6 top-1/2 w-4 h-px bg-gray-300"></span>
                                    <span class="absolute -left-6 bottom-1/2 w-px h-full bg-gray-300"></span>

                                    <div class="text-sm font-medium text-gray-700">{{ $child->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $child->url }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-600">
                                {{ $child->sort_order }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                <button wire:click="toggleStatus({{ $child->id }})" class="text-xs font-semibold {{ $child->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $child->is_active ? 'Hiển thị' : 'Đang ẩn' }}
                                </button>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.menus.edit', $child->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                <button wire:confirm="Xóa menu con này?" wire:click="delete({{ $child->id }})" class="text-red-600 hover:text-red-900">Xóa</button>
                            </td>
                        </tr>
                    @endforeach

                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Chưa có menu nào. Hãy thêm menu đầu tiên!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
