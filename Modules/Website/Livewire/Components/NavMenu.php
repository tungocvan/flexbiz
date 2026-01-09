<?php

namespace Modules\Website\Livewire\Components;

use Livewire\Component;
use Modules\Website\Models\Category;

class NavMenu extends Component
{
    public $categories;

    public function mount()
    {
        $this->categories = Category::active()
            ->ofType('product')
            ->root()
            ->with('childrenRecursive')
            ->orderBy('sort_order')
            ->get();
    }

    public function render()
    {
        return view('Website::livewire.components.nav-menu');
    }
}
