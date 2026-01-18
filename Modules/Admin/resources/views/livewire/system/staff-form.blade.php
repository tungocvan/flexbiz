<div class="max-w-4xl mx-auto px-4 sm:px-6 md:px-8 pb-10">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $isEdit ? 'Cập nhật Nhân viên' : 'Thêm Nhân viên mới' }}</h1>
        <a href="{{ route('admin.staff.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Quay lại</a>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Thông tin tài khoản</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Họ tên</label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500" placeholder="Nguyễn Văn A">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500" placeholder="staff@example.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Mật khẩu</label>
                        <input type="password" wire:model="password" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500" placeholder="{{ $isEdit ? 'Để trống nếu không đổi' : 'Nhập mật khẩu...' }}">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center pt-2">
                        <input type="checkbox" wire:model="is_active" id="active" class="h-4 w-4 text-indigo-600 rounded border-gray-300">
                        <label for="active" class="ml-2 text-sm text-gray-700">Kích hoạt tài khoản này</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Vai trò & Quyền hạn</h3>
                <p class="text-xs text-gray-500 mb-4">Chọn ít nhất một vai trò cho nhân viên này.</p>
                
                <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($roles as $role)
                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition {{ in_array($role->name, $selectedRoles) ? 'bg-indigo-50 border-indigo-200 ring-1 ring-indigo-200' : '' }}">
                            <div class="flex items-center h-5">
                                <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <span class="font-bold text-gray-900 block">{{ $role->name }}</span>
                                <span class="text-xs text-gray-500">Guard: {{ $role->guard_name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('selectedRoles') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold shadow hover:bg-indigo-700 transition">
                        {{ $isEdit ? 'Lưu cập nhật' : 'Tạo nhân viên' }}
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>