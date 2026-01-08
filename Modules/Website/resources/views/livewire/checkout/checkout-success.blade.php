<div class="container my-5 text-center">
    <h3 class="text-success">Order placed successfully 🎉</h3>

    <p class="mt-3">
        Order code:
        <strong>{{ $order->code }}</strong>
    </p>

    <p>Total:
        <strong>{{ number_format($order->total) }}₫</strong>
    </p>

    <a href="{{ route('website.products.index') }}"
       class="btn btn-primary mt-3">
        Continue Shopping
    </a>
</div>
