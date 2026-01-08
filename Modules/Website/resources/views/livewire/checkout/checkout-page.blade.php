<div class="container my-5">

    <h3 class="mb-4">Checkout</h3>

    @if(empty($cart))
        <div class="alert alert-warning">
            Your cart is empty.
        </div>
        <a href="{{ route('website.products.index') }}" class="btn btn-primary">
            Back to shop
        </a>
    @else
        <div class="row">
            {{-- FORM --}}
            <div class="col-md-7">
                <div class="card mb-4">
                    <form wire:submit.prevent="placeOrder">

                        <div class="form-group">
                            <label>Full name</label>
                            <input type="text" class="form-control" wire:model.defer="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" wire:model.defer="phone">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" wire:model.defer="address"></textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button class="btn btn-success btn-block">
                            Place Order (COD)
                        </button>

                    </form>

                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5>Order Summary</h5>

                        <ul class="list-group list-group-flush mb-3">
                            @foreach($cart as $item)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>
                                        {{ $item['name'] }} × {{ $item['qty'] }}
                                    </span>
                                    <strong>
                                        {{ number_format($item['price'] * $item['qty']) }}₫
                                    </strong>
                                </li>
                            @endforeach
                        </ul>

                        <p class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong>{{ number_format($this->total) }}₫</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
