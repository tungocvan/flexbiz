@extends('Website::layouts.website')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-7">
            @livewire('website.checkout.checkout-form')
        </div>
        <div class="col-md-5">
            @livewire('website.checkout.order-summary')
        </div>
    </div>
</div>
@endsection
