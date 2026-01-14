<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Admin Login</h2>
        <p class="text-gray-500 text-sm">Đăng nhập để quản trị hệ thống</p>
    </div>

    <form wire:submit="login">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input wire:model="email" type="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu</label>
            <input wire:model="password" type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input wire:model="remember" type="checkbox" class="form-checkbox text-slate-800">
                <span class="ml-2 text-sm text-gray-600">Ghi nhớ</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-2 px-4 rounded-lg hover:bg-slate-700 transition duration-300 disabled:opacity-50">
            <span wire:loading.remove>Đăng nhập</span>
            <span wire:loading>Đang xử lý...</span>
        </button>
    </form>
</div>