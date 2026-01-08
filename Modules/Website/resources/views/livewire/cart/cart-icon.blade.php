<div class="dropdown">
    <a
        href="#"
        class="btn btn-outline-secondary dropdown-toggle position-relative"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="fa fa-shopping-cart"></i>

        @if($count > 0)
            <span
                class="badge badge-danger position-absolute"
                style="top:-6px; right:-6px;"
            >
                {{ $count }}
            </span>
        @endif
    </a>

    @livewire('website.cart.mini-cart')
</div>
