<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="/">ECOMMERCE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- Gọi Livewire Component NavMenu --}}
            {{-- @livewire('website.components.nav-menu') --}}

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    {{-- <a href="/cart" class="nav-link">
                        Giỏ hàng <span class="badge badge-primary">0</span>
                    </a> --}}
                    @livewire('website.cart.cart-icon')
                </li>
            </ul>
        </div>
    </div>
</nav>
