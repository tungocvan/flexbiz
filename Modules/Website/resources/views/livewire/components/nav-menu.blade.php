<ul class="navbar-nav mr-auto">
    @foreach($categories as $category)
        @include('Website::livewire.components.menu-item', ['category' => $category])
    @endforeach
</ul>
