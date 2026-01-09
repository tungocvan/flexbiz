<div class="row">
    <div class="col-md-6">
        <img src="{{ $product->image }}" class="img-fluid mb-3" alt="{{ $product->title }}">

        @if($product->gallery)
            <div class="d-flex">
                @foreach($product->gallery as $img)
                    <img src="{{ $img }}" class="img-thumbnail mr-2" width="80">
                @endforeach
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <h3>{{ $product->title }}</h3>

        <div class="mb-3">
            @if($product->sale_price)
                <span class="h4 text-danger font-weight-bold">
                    {{ number_format($product->final_price) }} ₫
                </span>
                <del class="text-muted ml-2">
                    {{ number_format($product->regular_price) }} ₫
                </del>
                <span class="badge badge-success ml-2">
                    -{{ $product->discount_percent }}%
                </span>
            @else
                <span class="h4 font-weight-bold">
                    {{ number_format($product->regular_price) }} ₫
                </span>
            @endif
        </div>

        <p>{{ $product->short_description }}</p>

        <div class="mb-3">
            @livewire('website.cart.add-to-cart', ['productId' => $product->id], key('detail-'.$product->id))
        </div>
    </div>

    <div class="col-12 mt-4">
        <h5>Mô tả chi tiết</h5>
        <div>
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>
</div>
