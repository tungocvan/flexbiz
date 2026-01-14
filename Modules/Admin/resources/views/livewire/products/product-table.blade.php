<div>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="relative w-full md:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text"
                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Tìm kiếm sản phẩm...">
        </div>

        <a href="{{ route('admin.products.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-800 transition flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm sản phẩm
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá bán</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $item)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    @php
                                        // Logic xử lý ảnh: Nếu bắt đầu bằng http -> dùng luôn, ngược lại -> asset storage
                                        $imgSrc = $item->image
                                            ? (Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://'])
                                                ? $item->image
                                                : asset('storage/' . $item->image))
                                            : 'https://placehold.co/100';
                                    @endphp
                                    <img class="h-12 w-12 rounded-md object-cover border" src="{{ $imgSrc }}" alt="{{ $item->title }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 line-clamp-1 max-w-xs" title="{{ $item->title }}">{{ $item->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->slug }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($item->categories as $cat)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $cat->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Chưa phân loại</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->sale_price > 0 && $item->sale_price < $item->regular_price)
                                <div class="text-sm font-bold text-red-600">{{ number_format($item->sale_price) }} đ</div>
                                <div class="text-xs text-gray-400 line-through">{{ number_format($item->regular_price) }} đ</div>
                            @else
                                <div class="text-sm font-bold text-gray-900">{{ number_format($item->regular_price) }} đ</div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button wire:click="toggleStatus({{ $item->id }})"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $item->is_active ? 'bg-green-500' : 'bg-gray-200' }}">
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $item->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.products.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                            <button wire:confirm="Bạn chắc chắn muốn xóa sản phẩm này?"
                                    wire:click="delete({{ $item->id }})"
                                    class="text-red-600 hover:text-red-900">Xóa</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Chưa có sản phẩm nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
