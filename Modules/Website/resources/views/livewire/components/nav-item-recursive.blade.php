@if($category->childrenRecursive->count() > 0)
    <div class="dropdown-submenu">
        <a class="dropdown-item dropdown-toggle" href="#">{{ $category->name }}</a>
        <div class="dropdown-menu">
            @foreach($category->childrenRecursive as $child)
                @include('Website::livewire.components.nav-item-recursive', ['category' => $child])
            @endforeach
        </div>
    </div>
@else
    <a class="dropdown-item" href="{{ $category->url ?? route('website.products.category', $category->slug) }}">
        {{ $category->name }}
    </a>
@endif
