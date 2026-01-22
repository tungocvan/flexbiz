{{-- 1. TOP BAR (Thông báo / Tiện ích phụ) --}}
<div class="bg-gray-900 text-white text-xs py-2 hidden md:block">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                1900 123 456
            </span>
            <span class="text-gray-600">|</span>
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                support@flexbiz.com
            </span>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" class="hover:text-yellow-400 transition">Trợ giúp</a>
            <a href="{{ route('account.dashboard') }}" class="hover:text-yellow-400 transition">Theo dõi đơn hàng</a>
        </div>
    </div>
</div>

{{-- 2. MAIN HEADER --}}
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300"
        x-data="{ searchOpen: false, scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-8">

            {{-- LOGO --}}
            <a href="/" class="flex-shrink-0 flex items-center gap-2 group">
                <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center font-black text-xl group-hover:bg-blue-600 transition-colors">F</div>
                <span class="text-2xl font-bold text-gray-900 tracking-tight group-hover:text-blue-600 transition-colors">FlexBiz<span class="text-blue-600 group-hover:text-black">.</span></span>
            </a>

            {{-- SEARCH BAR (CENTER) - Chuẩn E-commerce --}}
            <div class="hidden lg:flex flex-1 max-w-xl relative">
                <form action="{{ route('product.list') }}" method="GET" class="w-full">
                    <input type="text"
                           name="search"
                           placeholder="Tìm kiếm sản phẩm, thương hiệu..."
                           class="w-full bg-gray-100 border-none rounded-full py-2.5 pl-5 pr-12 text-sm text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all placeholder-gray-500">
                    <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 p-1.5 bg-white rounded-full text-gray-500 hover:text-blue-600 shadow-sm hover:shadow transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            {{-- RIGHT ACTIONS --}}
            <div class="flex items-center space-x-2 md:space-x-6">

                {{-- DESKTOP MENU (Chỉ hiện text link ở đây hoặc dùng Mega Menu bên dưới) --}}
                <nav class="hidden xl:flex items-center gap-6 text-sm font-bold text-gray-700">
                    <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
                    <a href="{{ route('product.list') }}" class="hover:text-blue-600 transition">Cửa hàng</a>
                    <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition">Blog</a>
                </nav>

                {{-- ICONS --}}
                <div class="flex items-center gap-3 border-l border-gray-200 pl-6">

                    {{-- Wishlist (Optional) --}}
                    <a href="#" class="relative p-2 text-gray-600 hover:text-red-500 transition hidden sm:block">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </a>

                    {{-- Cart Icon (Livewire) --}}
                    @if(class_exists(\Modules\Website\Livewire\Cart\CartIcon::class))
                        @livewire('website.cart.cart-icon')
                    @endif

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        @auth
                            <button @click="open = !open" class="flex items-center gap-2 hover:bg-gray-50 p-1.5 rounded-full border border-transparent hover:border-gray-200 transition">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                     class="w-8 h-8 rounded-full border border-gray-200" alt="Avatar">
                                <span class="hidden md:block text-sm font-bold text-gray-700 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open"
                                 @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl py-2 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
                                 style="display: none;">

                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Tài khoản</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    <a href="#" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Hồ sơ cá nhân
                                    </a>
                                    <a href="{{ route('account.orders') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        Đơn hàng của tôi
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}" class="hidden md:inline-block text-sm font-bold text-gray-700 hover:text-blue-600">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-full hover:bg-blue-600 hover:shadow-lg transition-all transform hover:-translate-y-0.5">Đăng ký</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
