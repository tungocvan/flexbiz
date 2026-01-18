<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Danh sách Nhân sự</h1>
            <p class="mt-1 text-sm text-gray-500">Quản lý tài khoản và phân quyền truy cập hệ thống.</p>
        </div>
        
        <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Thêm nhân viên
        </a>
    </div>

    <div class="mb-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 relative">
            
            <div wire:loading.flex wire:target="search, filterRole" class="absolute inset-0 bg-white/60 z-20 items-center justify-center backdrop-blur-[1px]">
                <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>

            @if(count($selected) > 0)
                <div class="p-3 bg-indigo-50 flex items-center justify-between animate-fade-in">
                    <div class="flex items-center gap-3">
                        <button wire:click="resetSelection" class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-100"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        <span class="text-sm font-semibold text-indigo-900">Đã chọn <span class="font-bold text-indigo-700 text-base mx-1">{{ count($selected) }}</span> nhân viên</span>
                    </div>
                    <button wire:click="deleteSelected" wire:confirm="Xóa các tài khoản này?" class="px-4 py-2 bg-white border border-red-200 text-red-600 rounded-lg text-sm font-bold shadow-sm hover:bg-red-50">Xóa</button>
                </div>
            @else
                <div class="p-2 flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tìm tên, email..." class="block w-full pl-10 pr-3 py-2 border-transparent bg-transparent focus:border-transparent focus:ring-0 text-gray-900 placeholder-gray-400 sm:text-sm h-10">
                    </div>
                    
                    <div class="hidden md:block w-px bg-gray-200 my-1"></div>

                    <div class="relative min-w-[150px]">
                        <select wire:model.live="filterRole" class="block w-full pl-3 pr-8 py-2 text-sm text-gray-600 bg-gray-50 border-0 rounded-lg hover:bg-gray-100 cursor-pointer h-10 font-medium">
                            <option value="">Tất cả vai trò</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-4 py-4 w-10 text-center"><input type="checkbox" wire:model.live="selectAll" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"></th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nhân viên</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vai trò (Role)</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Trạng thái</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Ngày tạo</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition {{ in_array($user->id, $selected) ? 'bg-indigo-50/40' : '' }}">
                        <td class="px-4 py-4 text-center"><input type="checkbox" value="{{ $user->id }}" wire:model.live="selected" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"></td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        {{ $role->name === 'Super Admin' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hoạt động</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Đã khóa</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.staff.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Sửa</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">Chưa có nhân viên nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6">{{ $users->links() }}</div>
</div>