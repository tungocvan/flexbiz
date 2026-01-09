@if($category->childrenRecursive->isNotEmpty())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
           href="{{ route('website.products.category', $category->slug) }}"
           id="menu-{{ $category->id }}"
           role="button"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            {{ $category->name }}
        </a>

        <div class="dropdown-menu">
            @foreach($category->childrenRecursive as $child)
                @include('Website::livewire.components.menu-item', ['category' => $child])
            @endforeach
        </div>
    </li>
@else
    <a class="dropdown-item nav-link"
       href="{{ route('website.products.category', $category->slug) }}">
        {{ $category->name }}
    </a>
@endif
