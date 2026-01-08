<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>Product</th>
            <th width="120">Price</th>
            <th width="140">Quantity</th>
            <th width="120">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>
                    <div class="media">
                        @if($item['image'])
                            <img
                                src="{{ $item['image'] }}"
                                class="mr-3"
                                style="width:60px; height:60px; object-fit:cover;"
                            >
                        @endif
                        <div class="media-body">
                            <strong>{{ $item['name'] }}</strong>
                        </div>
                    </div>
                </td>

                <td>{{ number_format($item['price']) }}₫</td>

                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary"
                                wire:click="decrease({{ $item['id'] }})">−</button>

                        <button class="btn btn-light" disabled>
                            {{ $item['qty'] }}
                        </button>

                        <button class="btn btn-outline-secondary"
                                wire:click="increase({{ $item['id'] }})">+</button>
                    </div>
                </td>

                <td>
                    <strong>
                        {{ number_format($item['price'] * $item['qty']) }}₫
                    </strong>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
