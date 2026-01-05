<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta_title ?? config('app.name', 'Laravel Ecommerce') }}</title>
    <meta name="description" content="{{ $meta_description ?? '' }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn"
          crossorigin="anonymous">

    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .main-content { min-height: 60vh; }
        /* Giữ cho footer luôn ở dưới cùng */
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; }
        .main-content { flex: 1; }
    </style>

    @stack('styles')
</head>
<body>

    @include('Website::components.header')

    <main class="main-content py-4">
        <div class="container">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    @include('Website::components.footer')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
            crossorigin="anonymous"></script>

    @livewireScripts

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('notify', (event) => {
                // Logic hiển thị thông báo (Toastr, SweetAlert hoặc Alert Bootstrap)
                alert(event.message);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
