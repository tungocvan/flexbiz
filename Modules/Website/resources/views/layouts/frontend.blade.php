<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce Website</title>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex flex-col min-h-screen">

    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">STORE</a>

                <nav class="flex space-x-6 items-center">
                    <a href="{{ route('website.home') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Sản phẩm</a>

                    @if(class_exists(\Modules\Website\Livewire\Cart\CartIcon::class))
                        @livewire('website.cart.cart-icon')
                    @endif
                    <div class="relative ml-3" x-data="{ open: false }">
                        @auth
                            <button @click="open = !open"
                                    class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 focus:outline-none transition-colors">
                                <span class="font-bold">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{'rotate-180': open}"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50"
                                 style="display: none;">

                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Xin chào,</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                                    Bảng điều khiển
                                </a>

                                <a href="{{ route('account.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                                    Đơn hàng của tôi
                                </a>

                                <div class="border-t border-gray-100"></div>

                                <form method="POST" action="{{ route('website.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 font-medium">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-3 text-sm font-medium">
                                <a href="{{ route('website.login') }}" class="text-gray-600 hover:text-blue-600 transition">Đăng nhập</a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('website.register') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow-sm">Đăng ký</a>
                            </div>
                        @endauth
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-8 w-full flex-grow">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Ecommerce System. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
