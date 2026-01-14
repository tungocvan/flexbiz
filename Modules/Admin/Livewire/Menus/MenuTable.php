<?php

namespace Modules\Admin\Livewire\Menus;

use Livewire\Component;
use Modules\Website\Models\Category;

class MenuTable extends Component
{
    public function delete($id)
    {
        // Xóa menu, nếu có con thì con sẽ set parent_id = null (do database config)
        Category::destroy($id);
    }

    public function toggleStatus($id)
    {
        $menu = Category::find($id);
        $menu->is_active = !$menu->is_active;
        $menu->save();
    }

    public function render()
    {
        // Lấy menu Cha, kèm theo con, sắp xếp theo sort_order
        $menus = Category::where('type', 'menu')
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->orderBy('sort_order', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('Admin::livewire.menus.menu-table', [
            'menus' => $menus
        ]);
    }
}
