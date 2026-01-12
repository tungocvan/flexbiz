@extends('Website::layouts.frontend')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Thanh toán</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            @livewire('website.checkout.checkout-form')
        </div>

        <div class="lg:col-span-1">
            @livewire('website.checkout.order-summary')
        </div>
    </div>
</div>
@endsection
