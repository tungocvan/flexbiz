<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="/">Trang chủ</a>
    </li>

    @foreach($categories as $category)
        @if($category->childrenRecursive->count() > 0)
            {{-- Menu có cấp con --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $category->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $category->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $category->id }}">
                    @foreach($category->childrenRecursive as $child)
                        @include('website::livewire.components.nav-item-recursive', ['category' => $child])
                    @endforeach
                </div>
            </li>
        @else
            {{-- Menu đơn cấp --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ $category->url ?? route('website.products.category', $category->slug) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endif
    @endforeach
</ul>
