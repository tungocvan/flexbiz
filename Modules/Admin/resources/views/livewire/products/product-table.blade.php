<div class="space-y-6">

    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-4 md:p-5">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">

            <div class="flex flex-col md:flex-row w-full xl:w-auto gap-3">

                <div class="relative w-full md:w-24">
                    <select wire:model.live="perPage" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 cursor-pointer bg-gray-50 hover:bg-white transition">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">Tất cả</option>
                    </select>
                </div>

                <div class="relative w-full md:w-56">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>

                    <select wire:model.live="category_id"
                            class="block w-full rounded-lg border-0 py-2 pl-10 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 cursor-pointer bg-gray-50 hover:bg-white transition">

                        <option value="">Tất cả danh mục</option>

                        @foreach($this->categories as $cat)
                            <option value="{{ $cat->id }}" class="{{ $cat->parent_id == null ? 'font-bold text-gray-900' : 'text-gray-600' }}">
                                {{ $cat->view_name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="relative w-full md:w-80 group">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="block w-full rounded-lg border-0 py-2 pl-10 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                        placeholder="Tìm tên, mã sản phẩm...">

                    @if($search)
                        <button wire:click="clearSearch" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 cursor-pointer transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 w-full xl:w-auto justify-end border-t xl:border-t-0 pt-4 xl:pt-0 border-gray-100">
                <button wire:click="export" wire:loading.attr="disabled" class="inline-flex items-center gap-x-1.5 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                    Export
                </button>

                <button wire:click="$set('showImportModal', true)" class="inline-flex items-center gap-x-1.5 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    Import
                </button>

                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-x-1.5 rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                    <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    Thêm mới
                </a>
            </div>
        </div>

        @if($category_id)
            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center animate-fade-in-down">
                <span class="text-xs font-medium text-gray-500 mr-2">Đang lọc theo:</span>
                @php $activeCat = $this->categories->firstWhere('id', $category_id); @endphp
                @if($activeCat)
                    <span class="inline-flex items-center gap-x-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                        {{ $activeCat->name }}
                        <button wire:click="clearCategory" type="button" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-indigo-600/20">
                            <span class="sr-only">Xóa lọc</span>
                            <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-indigo-700/50 group-hover:stroke-indigo-700/75"><path d="M4 4l6 6m0-6l-6 6" /></svg>
                        </button>
                    </span>
                @endif
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden relative">

        <div wire:loading.flex wire:target="search, category_id, perPage, delete, duplicate, import, export, deleteSelected, applyCategories"
             class="absolute inset-0 bg-white/60 z-20 items-center justify-center backdrop-blur-[1px]">
            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>

        @if(count($selected) > 0)
            <div class="bg-indigo-50 border-b border-indigo-100 px-4 py-3 flex items-center justify-between animate-fade-in-down">
                <div class="flex items-center">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white mr-3">
                        {{ count($selected) }}
                    </span>
                    <p class="text-sm font-medium text-indigo-900">sản phẩm đang chọn</p>
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="openCategoryModal" class="text-sm font-medium text-indigo-700 hover:text-indigo-900 bg-white px-3 py-1.5 rounded shadow-sm border border-indigo-200 flex items-center transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Gán danh mục
                    </button>

                    <button wire:confirm="Xóa {{ count($selected) }} sản phẩm?" wire:click="deleteSelected" class="text-sm font-medium text-red-700 hover:text-red-900 bg-white px-3 py-1.5 rounded shadow-sm border border-red-200 flex items-center transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Xóa tất cả
                    </button>

                    <button wire:click="$set('selected', [])" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="relative px-6 py-3 w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        </th>

                        @foreach(['title' => 'Sản phẩm', 'regular_price' => 'Giá bán', 'is_active' => 'Trạng thái'] as $field => $label)
                            <th scope="col" wire:click="sortBy('{{ $field }}')"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide cursor-pointer group hover:bg-gray-100 transition select-none {{ $sortColumn === $field ? 'text-indigo-600 font-bold bg-indigo-50' : 'text-gray-500' }} {{ $field === 'is_active' ? 'text-center' : '' }}">
                                <div class="flex items-center gap-1 {{ $field === 'is_active' ? 'justify-center' : '' }}">
                                    {{ $label }}
                                    @if($sortColumn === $field)
                                        <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                    @endif
                                </div>
                            </th>
                        @endforeach

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Danh mục</th>
                        <th scope="col" class="relative px-6 py-3 text-right"><span class="sr-only">Hành động</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($products as $item)
                        <tr class="hover:bg-gray-50/50 transition duration-150 {{ in_array($item->id, $selected) ? 'bg-indigo-50/30' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" wire:model.live="selected" value="{{ $item->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-11 w-11 flex-shrink-0">
                                        <img class="h-11 w-11 rounded-lg object-cover border border-gray-200"
                                             src="{{ $item->image ? (Illuminate\Support\Str::startsWith($item->image, ['http']) ? $item->image : asset('storage/'.$item->image)) : 'https://placehold.co/100' }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 line-clamp-1 max-w-[200px]" title="{{ $item->title }}">{{ $item->title }}</div>
                                        <div class="text-xs text-gray-500 font-mono mt-0.5">ID: {{ $item->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->sale_price > 0 && $item->sale_price < $item->regular_price)
                                    <div class="text-sm font-bold text-red-600">{{ number_format($item->sale_price) }} ₫</div>
                                    <div class="text-xs text-gray-400 line-through">{{ number_format($item->regular_price) }} ₫</div>
                                @else
                                    <div class="text-sm font-semibold text-gray-900">{{ number_format($item->regular_price) }} ₫</div>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button wire:click="toggleStatus({{ $item->id }})"
                                    class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $item->is_active ? 'bg-green-500' : 'bg-gray-200' }}">
                                    <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $item->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                </button>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($item->categories as $cat)
                                        <span class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 group hover:bg-blue-100 transition-colors">

                                            {{ $cat->name }}

                                            <button type="button"
                                                    wire:click="removeCategory({{ $item->id }}, {{ $cat->id }})"
                                                    wire:confirm="Gỡ danh mục '{{ $cat->name }}' khỏi sản phẩm này?"
                                                    class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20 flex items-center justify-center transition-colors">
                                                <span class="sr-only">Remove</span>
                                                <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75"><path d="M4 4l6 6m0-6l-6 6" /></svg>
                                            </button>
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Chưa phân loại</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="duplicate({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded bg-transparent hover:bg-indigo-50 transition" title="Nhân bản">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <a href="{{ route('admin.products.edit', $item->id) }}" class="p-1.5 text-gray-400 hover:text-blue-600 rounded bg-transparent hover:bg-blue-50 transition" title="Sửa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button wire:confirm="Xóa sản phẩm này?" wire:click="delete({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-red-600 rounded bg-transparent hover:bg-red-50 transition" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="mt-2 text-sm font-medium text-gray-900">Không tìm thấy sản phẩm nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6">
            {{ $products->links() }}
        </div>
    </div>

    <div x-data="{ show: @entangle('showImportModal') }" x-show="show" style="display: none;" class="relative z-50">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div @click.away="show = false" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Import Sản phẩm từ Excel</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">Chọn file Excel (.xlsx) theo mẫu.</p>
                                    <label class="block w-full rounded-lg border border-dashed border-gray-300 p-6 text-center hover:bg-gray-50 cursor-pointer transition">
                                        <span class="text-sm text-gray-600" x-text="$wire.importFile ? 'Đã chọn file' : 'Click để chọn file'"></span>
                                        <input type="file" wire:model="importFile" class="hidden">
                                    </label>
                                    @error('importFile') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" wire:click="import" wire:loading.attr="disabled" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                            <span wire:loading.remove wire:target="import">Upload & Import</span>
                            <span wire:loading wire:target="import">Đang xử lý...</span>
                        </button>
                        <button type="button" @click="show = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ show: @entangle('showCategoryModal') }" x-show="show" style="display: none;" class="relative z-50">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div @click.away="show = false" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Gán danh mục hàng loạt</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">Thêm danh mục cho <strong>{{ count($selected) }}</strong> sản phẩm đã chọn.</p>
                                    <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-2 bg-gray-50 custom-scrollbar">
                                        @foreach($this->categories as $cat)
                                            <label class="flex items-center space-x-3 p-2 hover:bg-white hover:shadow-sm rounded cursor-pointer transition">
                                                <input type="checkbox" wire:model="bulkCategoryIds" value="{{ $cat->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                <span class="text-sm text-gray-700 font-medium">{{ $cat->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('bulkCategoryIds') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" wire:click="applyCategories" wire:loading.attr="disabled" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">
                            <span wire:loading.remove wire:target="applyCategories">Áp dụng</span>
                            <span wire:loading wire:target="applyCategories">Đang xử lý...</span>
                        </button>
                        <button type="button" @click="show = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
