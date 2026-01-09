<div>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->title }}">

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">
                            <a href="{{ route('website.products.show', $product->slug) }}">
                                {{ $product->title }}
                            </a>
                        </h6>

                        <div class="mb-2">
                            @if($product->sale_price)
                                <span class="text-danger font-weight-bold">
                                    {{ number_format($product->final_price) }} ₫
                                </span>
                                <del class="text-muted">
                                    {{ number_format($product->regular_price) }} ₫
                                </del>
                            @else
                                <span class="font-weight-bold">
                                    {{ number_format($product->regular_price) }} ₫
                                </span>
                            @endif
                        </div>

                        <div class="mt-auto">
                            @livewire('website.cart.add-to-cart', ['productId' => $product->id], key($product->id))
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

</div>
