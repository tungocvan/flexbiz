<div class="row">
    @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ $product->thumbnail }}"
                     class="card-img-top"
                     alt="{{ $product->name }}">

                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">{{ $product->name }}</h6>

                    <p class="text-danger font-weight-bold">
                        {{ number_format($product->price) }} đ
                    </p>

                    <a href="{{ route('website.products.show', $product->slug) }}"
                       class="btn btn-sm btn-outline-primary mt-auto">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted">
            Không có sản phẩm
        </div>
    @endforelse

    <div class="col-12 mt-4">
        {{ $products->links() }}
    </div>
</div>
