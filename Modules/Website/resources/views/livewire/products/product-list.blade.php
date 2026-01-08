<div class="product-list">
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4" wire:key="product-{{ $product->id }}">
                <div class="card h-100 shadow-sm">

                    {{-- IMAGE → LINK DETAIL --}}
                    <a href="{{ route('website.products.show', $product->slug) }}">
                        @if($product->image)
                            <img
                                src="{{ $product->image }}"
                                class="card-img-top"
                                style="height:180px; object-fit:cover;"
                                alt="{{ $product->title }}"
                            >
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">

                        {{-- TITLE → LINK DETAIL --}}
                        <h6 class="card-title font-weight-bold">
                            <a
                                href="{{ route('website.products.show', $product->slug) }}"
                                class="text-dark text-decoration-none"
                            >
                                {{ $product->title }}
                            </a>
                        </h6>

                        {{-- PRICE --}}
                        <div class="mb-2">
                            @if($product->sale_price)
                                <span class="text-danger font-weight-bold">
                                    {{ number_format($product->sale_price) }}₫
                                </span>
                                <small class="text-muted">
                                    <del>{{ number_format($product->regular_price) }}₫</del>
                                </small>
                            @else
                                <span class="font-weight-bold">
                                    {{ number_format($product->regular_price) }}₫
                                </span>
                            @endif
                        </div>

                        {{-- ADD TO CART --}}
                        <div class="mt-auto">
                            @livewire('website.cart.add-to-cart-button', [
                                'productId' => $product->id,
                                'name' => $product->title,
                                'price' => $product->sale_price ?: $product->regular_price,
                                'image' => $product->image,
                            ])
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
