@extends('Website::layouts.frontend')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 text-center">
    <div class="mb-6 flex justify-center">
        <div class="h-24 w-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
    </div>

    <h1 class="text-4xl font-bold text-gray-900 mb-4">Đặt hàng thành công!</h1>
    <p class="text-lg text-gray-600 mb-8">
        Cảm ơn bạn đã mua sắm. Mã đơn hàng của bạn là:
        <span class="font-bold text-blue-600">{{ session('order_code') }}</span>
    </p>

    <div class="flex justify-center gap-4">
        <a href="{{ route('website.home') }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition">
            Tiếp tục mua sắm
        </a>
    </div>
</div>
@endsection
