@php
    $currentSlug = request()->route('slug');

    // Active chính nó
    $isSelfActive = $currentSlug === $category->slug;

    // Active nếu slug nằm trong children
    $isChildActive = $category->childrenRecursive
        ->pluck('slug')
        ->contains($currentSlug);

    // Active tổng
    $isActive = $isSelfActive || $isChildActive;
@endphp

@if($category->childrenRecursive->isNotEmpty())
    <li class="nav-item dropdown {{ $isActive ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle {{ $isActive ? 'active' : '' }}"
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
                @include('Website::livewire.components.menu-item', [
                    'category' => $child
                ])
            @endforeach
        </div>
    </li>
@else
    <a class="dropdown-item {{ $isActive ? 'active' : '' }}"
       href="{{ route('website.products.category', $category->slug) }}">
        {{ $category->name }}
    </a>
@endif
