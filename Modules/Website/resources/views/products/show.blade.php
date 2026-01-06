@extends('Website::layouts.website')

@section('content')
<div class="container py-4">
    @livewire('website.products.product-detail', ['slug' => $slug])
</div>
@endsection
