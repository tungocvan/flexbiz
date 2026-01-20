<?php

namespace Modules\Admin\Livewire\Menus;

use Livewire\Component;
use Modules\Website\Models\Category;

class MenuTable extends Component
{
    // Xóa Menu
    public function delete($id)
    {
        Category::find($id)->delete();
        $this->dispatch('notify', content: 'Đã xóa menu.', type: 'success');
    }

    // Toggle Ẩn/Hiện
    public function toggleStatus($id)
    {
        $menu = Category::find($id);
        if ($menu) {
            $menu->update(['is_active' => !$menu->is_active]);
            $this->dispatch('notify', content: 'Đã cập nhật trạng thái.', type: 'success');
        }
    }

    // --- LOGIC KÉO THẢ QUAN TRỌNG ---
    public function updateMenuOrder($list)
    {
        // $list là mảng phân cấp được gửi từ JS
        // Structure: [{id: 1, children: [{id: 2}, {id: 3}]}, {id: 4}]
        
        $this->updateRecursive($list, null);
        
        $this->dispatch('notify', content: 'Đã lưu cấu trúc menu mới.', type: 'success');
    }

    private function updateRecursive($items, $parentId)
    {
        foreach ($items as $index => $item) {
            // Cập nhật cha và thứ tự
            Category::where('id', $item['id'])->update([
                'parent_id' => $parentId,
                'sort_order' => $index
            ]);

            // Nếu có con, đệ quy tiếp
            if (isset($item['children']) && !empty($item['children'])) {
                $this->updateRecursive($item['children'], $item['id']);
            }
        }
    }

    public function render()
    {
        // Lấy toàn bộ menu, sắp xếp theo thứ tự
        // Chúng ta lấy dạng phẳng (Flat), việc phân cấp sẽ do View xử lý
        $menus = Category::menu()
            ->with('children') // Eager load để tối ưu
            ->whereNull('parent_id') // Lấy gốc trước
            ->orderBy('sort_order')
            ->get();

        return view('Admin::livewire.menus.menu-table', ['menus' => $menus]);
    }
}