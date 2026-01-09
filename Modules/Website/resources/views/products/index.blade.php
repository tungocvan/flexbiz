@extends('Website::layouts.website')

@section('content')
<h3 class="mb-4">Danh sách sản phẩm</h3>
<hr>
@livewire('website.products.product-list', [
    'categorySlug' => $categorySlug ?? null
])


@endsection
