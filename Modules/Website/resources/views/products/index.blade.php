@extends('Website::layouts.website')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Danh sách sản phẩm</h3>

    @livewire('website.products.product-list')
</div>
@endsection
