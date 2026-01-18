<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        use Modules\Website\Models\Setting;
        $favicon = Setting::getValue('site_favicon');
    @endphp
    @if($favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $favicon) }}">
    @endif
    <title>@yield('title','HOMEPAGE')</title>
    {!! Setting::getValue('header_script') !!}
    @yield('css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    {{-- @vite(['resources/css/tailwind.css', 'resources/js/tailwind.js']) --}}

    @livewireStyles
</head>

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        <body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true }">

            <div class="flex h-screen overflow-hidden">

                <livewire:admin.partials.sidebar />

                <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                     </div>
            </div>

       </body>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            {{-- <header class="bg-white shadow h-16 flex justify-between items-center px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="font-semibold text-gray-700">Admin User</div>
            </header> --}}
            <livewire:admin.partials.header />
            <main class="flex-1 overflow-auto p-6">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
