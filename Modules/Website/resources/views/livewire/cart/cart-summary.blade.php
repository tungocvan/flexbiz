<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Order Summary</h5>

        <hr>

        <p class="d-flex justify-content-between">
            <span>Total</span>
            <strong>{{ number_format($total) }}₫</strong>
        </p>

        <a href="{{ route('website.checkout') }}" class="btn btn-success btn-block">
            Proceed to Checkout
        </a>
    </div>
</div>
