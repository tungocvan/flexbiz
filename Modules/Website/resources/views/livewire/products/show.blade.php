<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row bg-white py-4 border rounded">
        <div class="col-md-6">
            <div class="main-image mb-3">
                <img src="{{ $product->image }}" class="img-fluid rounded border w-100" alt="{{ $product->title }}">
            </div>
            
            @if($product->gallery && count($product->gallery) > 0)
                <div class="row mx-n1">
                    @foreach($product->gallery as $img)
                        <div class="col-3 px-1">
                            <img src="{{ $img }}" class="img-fluid rounded border shadow-sm" style="cursor: pointer;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h1 class="h3 font-weight-bold">{{ $product->title }}</h1>
            <hr>
            
            <div class="price-box mb-4">
                @if($product->sale_price > 0)
                    <h2 class="text-danger font-weight-bold mb-0">{{ number_format($product->sale_price) }}đ</h2>
                    <p class="text-muted small"><del>{{ number_format($product->regular_price) }}đ</del> <span class="badge badge-danger">-{{ $product->discount_percent }}%</span></p>
                @else
                    <h2 class="text-dark font-weight-bold">{{ number_format($product->regular_price) }}đ</h2>
                @endif
            </div>

            <div class="short-description mb-4">
                <p class="text-secondary">{{ $product->short_description }}</p>
            </div>

            <div class="cart-actions p-3 bg-light rounded">
                <div class="form-group">
                    <label for="qty" class="font-weight-bold">Số lượng:</label>
                    <div class="input-group mb-3" style="width: 140px;">
                        <input type="number" id="qty" wire:model="quantity" class="form-control" min="1">
                    </div>
                </div>
                
                <button wire:click="addToCart" wire:loading.attr="disabled" class="btn btn-primary btn-lg btn-block">
                    <span wire:loading.remove wire:target="addToCart">THÊM VÀO GIỎ HÀNG</span>
                    <span wire:loading wire:target="addToCart">Đang xử lý...</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 p-4 bg-white border rounded">
            <h4 class="border-bottom pb-2 mb-3">Mô tả sản phẩm</h4>
            <div class="product-content">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    </div>
</div>