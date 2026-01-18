<?php

namespace Modules\Admin\Livewire\Menus;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Website\Models\Category;
use Illuminate\Support\Facades\DB;

class MenuTable extends Component
{
    use WithFileUploads; // <--- 2. Sử dụng Trait upload

    public $importFile; // Biến chứa file upload
    public $isImporting = false; // Trạng thái hiển thị khung import

    // --- LOGIC EXPORT (XUẤT RA FILE JSON) ---
    public function export()
    {
        // Lấy dữ liệu đầy đủ
        $menus = Category::where('type', 'menu')
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->orderBy('sort_order', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->get()
            ->makeHidden(['created_at', 'updated_at', 'id', 'parent_id']); // Ẩn các trường không cần thiết khi export

        $fileName = 'menu-backup-' . date('Y-m-d-His') . '.json';

        // Download file về máy
        return response()->streamDownload(function () use ($menus) {
            echo $menus->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $fileName);
    }

    // --- LOGIC IMPORT (NHẬP TỪ FILE JSON) ---
    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:json,txt|max:1024',
        ]);

        try {
            $jsonContent = file_get_contents($this->importFile->getRealPath());
            $data = json_decode($jsonContent, true);

            if (!is_array($data)) {
                $this->addError('importFile', 'File JSON không hợp lệ.');
                return;
            }

            DB::beginTransaction();

            $countNew = 0; // Đếm số menu mới thêm
            $countSkip = 0; // Đếm số menu bị bỏ qua

            foreach ($data as $parentItem) {
                // 1. XỬ LÝ MENU CHA
                // Kiểm tra tồn tại: Cùng tên, cùng URL, và là menu cha (parent_id null)
                $parent = Category::where('type', 'menu')
                    ->where('name', $parentItem['name'])
                    ->where('url', $parentItem['url'] ?? '#')
                    ->whereNull('parent_id')
                    ->first();

                // Nếu chưa có -> Tạo mới
                if (!$parent) {
                    $parent = Category::create([
                        'type'       => 'menu',
                        'name'       => $parentItem['name'],
                        'icon'       => $parentItem['icon'] ?? null,
                        'url'        => $parentItem['url'] ?? '#',
                        'sort_order' => $parentItem['sort_order'] ?? 0,
                        'is_active'  => $parentItem['is_active'] ?? true,
                        'parent_id'  => null,
                    ]);
                    $countNew++;
                } else {
                    // Nếu đã có -> Đánh dấu skip, nhưng VẪN GIỮ BIẾN $parent 
                    // để kiểm tra tiếp các con của nó.
                    $countSkip++;
                }

                // 2. XỬ LÝ MENU CON (nếu có)
                if (!empty($parentItem['children']) && $parent) {
                    foreach ($parentItem['children'] as $childItem) {
                        
                        // Kiểm tra tồn tại: Cùng tên, cùng URL, và PHẢI THUỘC ĐÚNG CHA
                        $childExists = Category::where('type', 'menu')
                            ->where('name', $childItem['name'])
                            ->where('url', $childItem['url'] ?? '#')
                            ->where('parent_id', $parent->id) 
                            ->exists();

                        if (!$childExists) {
                            Category::create([
                                'type'       => 'menu',
                                'name'       => $childItem['name'],
                                'icon'       => $childItem['icon'] ?? null,
                                'url'        => $childItem['url'] ?? '#',
                                'sort_order' => $childItem['sort_order'] ?? 0,
                                'is_active'  => $childItem['is_active'] ?? true,
                                'parent_id'  => $parent->id, // Gắn vào ID cha (dù cha mới hay cũ)
                            ]);
                            $countNew++;
                        } else {
                            $countSkip++;
                        }
                    }
                }
            }

            DB::commit();

            $this->importFile = null;
            $this->isImporting = false;
            
            // Thông báo chi tiết
            session()->flash('success', "Import hoàn tất! Đã thêm mới: $countNew, Bỏ qua (trùng): $countSkip.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('importFile', 'Lỗi: ' . $e->getMessage());
        }
    }
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
