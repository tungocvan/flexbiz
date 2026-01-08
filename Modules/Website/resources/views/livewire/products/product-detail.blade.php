<div class="container my-5">

    <div class="row">
        {{-- IMAGE --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <img
                    src="{{ $product->image }}"
                    class="card-img-top"
                    style="max-height:420px; object-fit:cover;"
                    alt="{{ $product->title }}"
                >
            </div>
        </div>

        {{-- INFO --}}
        <div class="col-md-6">
            <h2 class="font-weight-bold mb-3">
                {{ $product->title }}
            </h2>

            {{-- PRICE --}}
            <div class="mb-3">
                @if($product->sale_price)
                    <h4 class="text-danger font-weight-bold d-inline">
                        {{ number_format($product->sale_price) }}₫
                    </h4>
                    <span class="text-muted ml-2">
                        <del>{{ number_format($product->regular_price) }}₫</del>
                    </span>
                @else
                    <h4 class="font-weight-bold">
                        {{ number_format($product->regular_price) }}₫
                    </h4>
                @endif
            </div>

            {{-- SHORT DESC --}}
            @if($product->excerpt)
                <p class="text-muted">
                    {{ $product->excerpt }}
                </p>
            @endif

            {{-- ADD TO CART --}}
            <div class="mt-4">
                @livewire('website.cart.add-to-cart-button', [
                    'productId' => $product->id,
                    'name' => $product->title,
                    'price' => $product->sale_price ?: $product->regular_price,
                    'image' => $product->image,
                ])
            </div>

            {{-- META --}}
            <ul class="list-unstyled mt-4">
                <li><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</li>
                <li>
                    <strong>Status:</strong>
                    @if($product->is_active)
                        <span class="badge badge-success">In stock</span>
                    @else
                        <span class="badge badge-danger">Out of stock</span>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    {{-- DESCRIPTION --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <strong>Description</strong>
                </div>
                <div class="card-body">
                    {!! $product->description !!}
                </div>
            </div>
        </div>
    </div>

</div>
