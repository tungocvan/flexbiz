@extends('Website::layouts.website')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-3">🎉 Đặt hàng thành công</h2>

    <p>Mã đơn hàng: <strong>{{ $order->order_code }}</strong></p>
    <p>Tổng tiền: <strong>{{ number_format($order->total) }} ₫</strong></p>
    <p>Trạng thái: <span class="badge badge-warning">{{ $order->status }}</span></p>
</div>
@endsection
