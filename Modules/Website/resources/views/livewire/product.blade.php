<div>
    <h3 class="text-primary">DANH SÁCH SẢN PHẨM MỚI (Bootstrap 4.6.1)</h3>
    <hr>
    @section('content')
        @livewire('website.products.index')
    @endsection
</div>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        console.log("Website chuẩn Bootstrap 4.6.1 đã sẵn sàng");
    })
</script>
@endpush
