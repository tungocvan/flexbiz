<div class="row">
    @if(!$cart || $cart->items->isEmpty())
    <div class="alert alert-info">
        Giỏ hàng của bạn đang trống.
    </div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th width="120">Giá</th>
            <th width="120">Số lượng</th>
            <th width="120">Tổng</th>
            <th width="80"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($cart->items as $item)
            <tr>
                <td>{{ $item->product?->title }}</td>
                <td>{{ number_format($item->price) }} ₫</td>
                <td>
                    <input type="number"
                           min="1"
                           class="form-control"
                           value="{{ $item->quantity }}"
                           wire:change="updateQuantity({{ $item->id }}, $event.target.value)">
                </td>
                <td>{{ number_format($item->total) }} ₫</td>
                <td>
                    <button class="btn btn-danger btn-sm"
                            wire:click="removeItem({{ $item->id }})">
                        ✕
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="text-right">
    <a href="{{ route('website.checkout.index') }}" class="btn btn-success">
        Thanh toán
    </a>
</div>
@endif

</div>
