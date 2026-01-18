<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 pb-10">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            {{ $isEdit ? 'Chỉnh sửa Vai trò' : 'Tạo Vai trò mới' }}
        </h1>
        <a href="{{ route('admin.roles.index') }}" class="text-gray-500 hover:text-gray-700">Quay lại</a>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Thông tin Vai trò</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tên Vai trò <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500" placeholder="VD: Nhân viên kho">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 text-sm text-blue-800">
                        <p><strong>Lưu ý:</strong> "Super Admin" có toàn quyền truy cập hệ thống.</p>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold shadow hover:bg-indigo-700 transition">
                        Lưu Vai trò
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 9.636a1.038 1.038 0 111.95-1.038 6 6 0 11-7.743 5.743 6 6 0 017.743-5.743z"/></svg>
                    Phân quyền chi tiết (Permissions)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($permissionGroups as $module => $permissions)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                                <span class="font-bold text-gray-800 uppercase text-xs tracking-wider">
                                    Module: {{ $module }}
                                </span>
                                </div>
                            
                            <div class="p-4 space-y-3 bg-white">
                                @foreach($permissions as $perm)
                                    <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 -mx-2 p-2 rounded transition">
                                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700 select-none">
                                            {{-- Làm đẹp tên quyền: view_product -> View Product --}}
                                            {{ ucwords(str_replace('_', ' ', str_replace('_'.$module, '', $perm->name))) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </form>
</div>