<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Cấu hình Menu Sidebar</h2>
        <a href="{{ route('admin.menus.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm Menu
        </a>
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
