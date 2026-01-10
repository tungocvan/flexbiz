@extends('Website::layouts.website')

@section('content')
<h3 class="mb-4">Danh sách sản phẩm</h3>
<hr>
<div class="row">
    <div class="col-2">
        @livewire('website.components.nav-menu')
    </div>
    <div class="col-10">
        @livewire('website.products.product-list', [
                'categorySlug' => $categorySlug ?? null
            ])
    </div>
</div>



@endsection
