<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">{{ $categoryName }}</h2>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <a href="{{ route('website.products.show', $product->slug) }}">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->title }}" 
                             style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title h6 text-truncate" title="{{ $product->title }}">
                            <a href="{{ route('website.products.show', $product->slug) }}" class="text-dark decoration-none">
                                {{ $product->title }}
                            </a>
                        </h5>
                        
                        <div class="mt-auto">
                            @if($product->sale_price > 0)
                                <div class="text-danger font-weight-bold">{{ number_format($product->sale_price) }}đ</div>
                                <small class="text-muted"><del>{{ number_format($product->regular_price) }}đ</del></small>
                            @else
                                <div class="text-dark font-weight-bold">{{ number_format($product->regular_price) }}đ</div>
                            @endif
                            
                            <a href="{{ route('website.products.show', $product->slug) }}" 
                               class="btn btn-outline-primary btn-sm btn-block mt-3">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Không tìm thấy sản phẩm nào trong danh mục này.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>