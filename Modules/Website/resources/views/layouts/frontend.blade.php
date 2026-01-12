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
                <a href="{{ route('website.home') }}" class="text-2xl font-bold text-blue-600">STORE</a>

                <nav class="flex space-x-6 items-center">
                    <a href="{{ route('website.home') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Sản phẩm</a>

                    @if(class_exists(\Modules\Website\Livewire\Cart\CartIcon::class))
                        @livewire('website.cart.cart-icon')
                    @endif
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
