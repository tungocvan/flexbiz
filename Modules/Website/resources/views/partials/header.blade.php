{{-- 1. TOP BAR (Giữ nguyên - Chỉ hiện Desktop) --}}
<div class="bg-gray-900 text-white text-xs py-2 hidden md:block">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                </svg>
                0903 971 949
            </span>
            <span class="text-gray-600">|</span>
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                tungocvan@gmail.com
            </span>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" class="hover:text-yellow-400 transition">Trợ giúp</a>
            <a href="{{ route('account.dashboard') }}" class="hover:text-yellow-400 transition">Theo dõi đơn hàng</a>
        </div>
    </div>
</div>

{{-- 2. MAIN HEADER --}}
{{-- Thêm state mobileMenuOpen và mobileSearchOpen --}}
<header
    class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300"
    x-data="{
        userDropdownOpen: false,
        scrolled: false,
        mobileMenuOpen: false,
        mobileSearchOpen: false
    }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20 gap-4">

            {{-- LEFT SECTION: HAMBURGER (MOBILE) & LOGO --}}
            <div class="flex items-center gap-3 md:gap-8">

                {{-- Hamburger Button (Mobile Only) --}}
                <button @click="mobileMenuOpen = true"
                    class="lg:hidden p-2 -ml-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- LOGO --}}
                <a href="/" class="flex-shrink-0 flex items-center gap-2 group">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 bg-black text-white rounded-lg flex items-center justify-center font-black text-lg md:text-xl group-hover:bg-blue-600 transition-colors">
                        F</div>
                    <span
                        class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight group-hover:text-blue-600 transition-colors">FlexBiz<span
                            class="text-blue-600 group-hover:text-black">.</span></span>
                </a>
            </div>

            {{-- CENTER SECTION: SEARCH BAR (DESKTOP ONLY) --}}
            <div class="hidden lg:flex flex-1 max-w-xl relative">
                <form action="{{ route('product.list') }}" method="GET" class="w-full">
                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm, thương hiệu..."
                        class="w-full bg-gray-100 border-none rounded-full py-2.5 pl-5 pr-12 text-sm text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all placeholder-gray-500">
                    <button type="submit"
                        class="absolute right-1 top-1/2 -translate-y-1/2 p-1.5 bg-white rounded-full text-gray-500 hover:text-blue-600 shadow-sm hover:shadow transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- RIGHT SECTION: ICONS --}}
            <div class="flex items-center gap-1 md:gap-6">

                {{-- Mobile Search Icon Toggle --}}
                <button @click="mobileSearchOpen = !mobileSearchOpen"
                    class="lg:hidden p-2 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                {{-- Desktop Menu Links --}}
                <nav class="hidden xl:flex items-center gap-6 text-sm font-bold text-gray-700">
                    <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
                    <a href="{{ route('product.list') }}" class="hover:text-blue-600 transition">Cửa hàng</a>
                    <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition">Blog</a>
                </nav>

                {{-- Icons Wrapper --}}
                <div class="flex items-center gap-2 md:border-l md:border-gray-200 md:pl-6">

                    {{-- Wishlist (Desktop) --}}
                    <a href="#" class="hidden sm:block p-2 text-gray-600 hover:text-red-500 transition relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </a>

                    {{-- Cart Icon --}}
                    @if (class_exists(\Modules\Website\Livewire\Cart\CartIcon::class))
                        @livewire('website.cart.cart-icon')
                    @endif

                    {{-- User Dropdown (Desktop) --}}
                    <div class="hidden lg:block relative">
                        @auth
                            <button @click="userDropdownOpen = !userDropdownOpen"
                                class="flex items-center gap-2 hover:bg-gray-50 p-1.5 rounded-full border border-transparent hover:border-gray-200 transition">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                    class="w-8 h-8 rounded-full border border-gray-200" alt="Avatar">
                                <span
                                    class="hidden md:block text-sm font-bold text-gray-700 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Desktop User Menu --}}
                            <div x-show="userDropdownOpen" @click.outside="userDropdownOpen = false"
                                x-transition.origin.top.right
                                class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl py-2 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
                                style="display: none;">
                                {{-- Nội dung dropdown user desktop giữ nguyên --}}
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Tài khoản</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('account.profile') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">Hồ
                                        sơ cá nhân</a>
                                    <a href="{{ route('account.orders') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">Đơn
                                        hàng của tôi</a>
                                </div>
                                <div class="border-t border-gray-100 py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Đăng
                                            xuất</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}"
                                    class="hidden md:inline-block text-sm font-bold text-gray-700 hover:text-blue-600">Đăng
                                    nhập</a>
                                <a href="{{ route('register') }}"
                                    class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-full hover:bg-blue-600 hover:shadow-lg transition">Đăng
                                    ký</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. MOBILE SEARCH BAR (Slide Down) --}}
        <div x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden pb-4" style="display: none;">
            <form action="{{ route('product.list') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..."
                    class="w-full bg-gray-100 border-none rounded-xl py-3 pl-12 pr-4 text-gray-900 focus:ring-2 focus:ring-blue-500">
                <svg class="w-5 h-5 text-gray-500 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>
    </div>

    {{-- 4. MOBILE OFF-CANVAS MENU (Slide Over) --}}
    {{-- Sử dụng template x-teleport="body" để đưa menu ra khỏi Header, tránh bị che bởi Slider --}}

    <template x-teleport="body">
        <div x-show="mobileMenuOpen" class="fixed inset-0 z-[9999]" style="display: none;">

            {{-- Backdrop (Lớp nền tối) --}}
            <div x-show="mobileMenuOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click="mobileMenuOpen = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            {{-- Sidebar Panel (Nội dung Menu) --}}
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="absolute left-0 top-0 bottom-0 bg-white w-[85%] max-w-sm h-full shadow-2xl overflow-y-auto z-10">

                {{-- Mobile Menu Header --}}
                <div class="p-6 bg-gray-900 text-white">
                    <div class="flex justify-between items-start mb-6">
                        <span class="text-xl font-bold">Menu</span>
                        <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-white p-1">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    @auth
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                class="w-12 h-12 rounded-full border-2 border-white/20">
                            <div>
                                <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate max-w-[180px]">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            <p class="text-gray-400 text-sm mb-2">Chào mừng đến với FlexBiz!</p>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('login') }}"
                                    class="text-center py-2 bg-white/10 rounded-lg hover:bg-white/20 transition text-sm font-bold">Đăng
                                    nhập</a>
                                <a href="{{ route('register') }}"
                                    class="text-center py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition text-sm font-bold">Đăng
                                    ký</a>
                            </div>
                        </div>
                    @endauth
                </div>

                {{-- Mobile Menu Links --}}
                <div class="p-4 space-y-1">
                    <a href="/"
                        class="block px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-xl hover:text-blue-600 transition flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Trang chủ
                    </a>
                    <a href="{{ route('product.list') }}"
                        class="block px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-xl hover:text-blue-600 transition flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Cửa hàng
                    </a>
                    <a href="{{ route('blog.index') }}"
                        class="block px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-xl hover:text-blue-600 transition flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                        Blog & Tin tức
                    </a>

                    @auth
                        <div class="border-t border-gray-100 my-2 pt-2">
                            <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Cá nhân</p>
                            <a href="#"
                                class="block px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-xl hover:text-blue-600 transition">Hồ
                                sơ cá nhân</a>
                            <a href="{{ route('account.orders') }}"
                                class="block px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-xl hover:text-blue-600 transition">Đơn
                                hàng của tôi</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-red-600 font-medium hover:bg-red-50 rounded-xl transition flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

                {{-- Contact Info Footer --}}
                <div class="p-6 bg-gray-50 mt-auto border-t border-gray-100 pb-20"> {{-- Thêm pb-20 để tránh bị browser bar che --}}
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Liên hệ</p>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <span class="text-blue-600 font-bold">Hotline:</span> 1900 123 456
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-blue-600 font-bold">Email:</span> support@flexbiz.com
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</header>
