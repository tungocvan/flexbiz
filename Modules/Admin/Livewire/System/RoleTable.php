<?php

namespace Modules\Admin\Livewire\System;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleTable extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $selected = [];
    public $selectAll = false;
    
    public $showImportModal = false;
    public $importFile;

    // Reset & Select logic (Giống CustomerTable - Tôi lược bỏ cho ngắn gọn, bạn copy từ CustomerTable sang nhé)
    // ... include: updatedSearch, updatingPage, updatedSelectAll, resetSelection ...

    public function deleteSelected()
    {
        // Chặn xóa Super Admin
        $roles = Role::whereIn('id', $this->selected)->get();
        foreach($roles as $role) {
            if($role->name !== 'Super Admin') $role->delete();
        }
        $this->resetSelection();
        $this->dispatch('notify', content: 'Đã xóa vai trò (trừ Super Admin).', type: 'success');
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if($role->name === 'Super Admin') {
            $this->dispatch('notify', content: 'Không thể xóa Super Admin!', type: 'error');
            return;
        }
        $role->delete();
        $this->dispatch('notify', content: 'Đã xóa vai trò.', type: 'success');
    }

    // --- IMPORT / EXPORT JSON ---
    public function export()
    {
        $roles = Role::with('permissions')->get()->map(function($role) {
            return [
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permissions' => $role->permissions->pluck('name')->toArray()
            ];
        });

        $fileName = 'roles-export-' . date('Y-m-d') . '.json';
        return response()->streamDownload(function () use ($roles) {
            echo $roles->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $fileName);
    }

    public function import()
    {
        $this->validate(['importFile' => 'required|mimes:json,txt']);
        
        $json = json_decode(file_get_contents($this->importFile->getRealPath()), true);
        
        DB::transaction(function () use ($json) {
            foreach ($json as $item) {
                // 1. Tạo Role
                $role = Role::firstOrCreate(['name' => $item['name']], ['guard_name' => $item['guard_name'] ?? 'web']);
                
                // 2. Tạo Permission nếu chưa có (Tránh lỗi)
                if (!empty($item['permissions'])) {
                    foreach ($item['permissions'] as $permName) {
                        Permission::firstOrCreate(['name' => $permName]);
                    }
                    // 3. Gán quyền
                    $role->syncPermissions($item['permissions']);
                }
            }
        });

        $this->showImportModal = false;
        $this->dispatch('notify', content: 'Import cấu hình phân quyền thành công.', type: 'success');
    }

    public function render()
    {
        $roles = Role::withCount('users')
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->perPage);

        return view('Admin::livewire.system.role-table', ['roles' => $roles]);
    }
}