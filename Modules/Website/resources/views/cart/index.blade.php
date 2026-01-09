@extends('Website::layouts.website')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Giỏ hàng</h3>

    @livewire('website.cart.cart-list')
</div>
@endsection
