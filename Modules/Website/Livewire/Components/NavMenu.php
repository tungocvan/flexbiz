<?php

namespace Modules\Website\Livewire\Components;

use Livewire\Component;
use Modules\Website\Models\Category;

class NavMenu extends Component
{
    public function render()
    {
        // Lấy danh mục gốc, chỉ lấy loại 'product' và đang hoạt động
        $categories = Category::root()
            ->active()
            ->ofType('product')
            ->with('childrenRecursive')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('Website::livewire.components.nav-menu', [
            'categories' => $categories
        ]);
    }
}
