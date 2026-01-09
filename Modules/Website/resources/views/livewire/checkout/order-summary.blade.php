<div class="card">
    <div class="card-header">
        <strong>Đơn hàng của bạn</strong>
    </div>

    <ul class="list-group list-group-flush">
        @foreach($cart?->items ?? [] as $item)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $item->product?->title }}</span>
                <span>{{ number_format($item->total) }} ₫</span>
            </li>
        @endforeach
    </ul>

    <div class="card-footer text-right">
        <strong>
            Tổng: {{ number_format($cart?->items->sum('total') ?? 0) }} ₫
        </strong>
    </div>
</div>
