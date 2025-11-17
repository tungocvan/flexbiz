@extends('layouts.page')

@section('title', 'DASHBOARD')

@section('content')
<div class="container">
    <h2>DASHBOARD</h2>
</div>

@endsection

@section('css')
@stack('styles')
    {{-- Sử dụng ở component @push(css)<style>...</style>@endpush ở cuối file --}}
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

@stop

@section('js')
@stack('scripts')
     <script>
        document.addEventListener("DOMContentLoaded", () => {
            console.log("Lắng nghe sự kiện DOMContentLoaded được gọi trước jquery");
        })
     </script>
@stop
