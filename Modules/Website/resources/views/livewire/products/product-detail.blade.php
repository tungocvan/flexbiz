<div class="row">
    <div class="col-md-6">
        <img src="{{ $product->thumbnail }}"
             class="img-fluid rounded"
             alt="{{ $product->name }}">
    </div>

    <div class="col-md-6">
        <h2 class="mb-3">{{ $product->name }}</h2>

        <p class="text-danger h4 font-weight-bold">
            {{ number_format($product->price) }} đ
        </p>

        <div class="mb-3">
            {!! $product->description !!}
        </div>

        @if($product->categories->isNotEmpty())
            <div class="mb-3">
                <strong>Danh mục:</strong>
                @foreach($product->categories as $category)
                    <span class="badge badge-secondary">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- AddToCart sẽ gắn ở giai đoạn sau --}}
        <div class="mt-4">
            <button class="btn btn-primary btn-lg" disabled>
                Thêm vào giỏ hàng
            </button>
        </div>
    </div>
</div>
