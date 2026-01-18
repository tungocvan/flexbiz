<?php

namespace Modules\Admin\Livewire\Menus;

use Livewire\Component;
use Modules\Website\Models\Category;
use Illuminate\Support\Str;

class MenuForm extends Component
{
    public $menuId = null;
    public $name, $url, $icon, $sort_order = 0;
    public $parent_id = null;
    public $is_active = true;

    // Load danh sách Parent cho dropdown
    public function getParentsProperty()
    {
        $query = Category::where('type', 'menu')->whereNull('parent_id');

        // Nếu đang edit, không cho chọn chính mình làm cha
        if ($this->menuId) {
            $query->where('id', '!=', $this->menuId);
        }

        return $query->orderBy('name')->get();
    }

    public function mount($id = null)
    {
        if ($id) {
            $menu = Category::findOrFail($id);
            $this->menuId = $menu->id;
            $this->name = $menu->name;
            $this->url = $menu->url;
            $this->icon = $menu->icon;
            $this->sort_order = $menu->sort_order;
            $this->parent_id = $menu->parent_id;
            $this->is_active = (bool) $menu->is_active;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'url' => 'required',
            'icon' => 'nullable|string', // SVG code
            'sort_order' => 'integer',
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name), // Slug tự động
            'url' => $this->url,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
            'parent_id' => $this->parent_id ?: null, // Chuyển chuỗi rỗng thành null
            'is_active' => $this->is_active,
            'type' => 'menu', // Cố định type
        ];

        if ($this->menuId) {
            Category::where('id', $this->menuId)->update($data);
        } else {
            Category::create($data);
        }

        return redirect()->route('admin.menus.index');
    }

    public function increaseOrder()
    {
        $this->sort_order++;
    }

    public function decreaseOrder()
    {
        // Kiểm tra để không bị âm (nếu muốn)
        if ($this->sort_order > 0) {
            $this->sort_order--;
        }
    }
    public function render()
    {
        return view('Admin::livewire.menus.menu-form');
    }
}
