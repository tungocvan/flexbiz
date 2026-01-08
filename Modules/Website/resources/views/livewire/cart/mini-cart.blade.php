<div class="dropdown-menu dropdown-menu-right p-3" style="min-width: 320px;">
    @if(count($items) === 0)
        <p class="mb-0 text-muted text-center">
            Cart is empty
        </p>
    @else
        <ul class="list-unstyled mb-2">
            @foreach($items as $item)
                <li class="media mb-2">
                    @if($item['image'])
                        <img
                            src="{{ $item['image'] }}"
                            class="mr-2"
                            style="width:40px; height:40px; object-fit:cover;"
                        >
                    @endif

                    <div class="media-body">
                        <div class="font-weight-bold">
                            {{ $item['name'] }}
                        </div>
                        <small class="text-muted">
                            {{ $item['qty'] }} × {{ number_format($item['price']) }}₫
                        </small>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="border-top pt-2 mb-2">
            <strong>Total:</strong>
            {{ number_format($total) }}₫
        </div>

        <a href="{{ route('website.cart') }}" class="btn btn-primary btn-block btn-sm">
            View Cart
        </a>
    @endif
</div>
