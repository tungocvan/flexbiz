<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;

class CategoryHighlight extends Component
{
    public Collection $categories;

    public function mount(CategoryService $service)
    {
        // Lấy 8 danh mục cha, sắp xếp theo sort_order
        $this->categories = $service->getHomeCategories(8);
    }

    public function render()
    {
        return view('Website::livewire.home.category-highlight');
    }
}
