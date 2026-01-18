<?php

namespace Modules\Admin\Livewire\System;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleForm extends Component
{
    public $roleId;
    public $isEdit = false;
    public $name;
    
    // Mảng chứa các quyền được chọn: ['view_product', 'edit_order', ...]
    public $selectedPermissions = []; 
    
    // Dữ liệu hiển thị (Không wire:model)
    public $permissionGroups = [];

    public function mount($id = null)
    {
        // 1. Lấy và nhóm các quyền (Group by module)
        $allPermissions = Permission::all();
        foreach ($allPermissions as $perm) {
            // Quy tắc đặt tên: action_module (VD: view_product)
            $parts = explode('_', $perm->name);
            $module = end($parts); // Lấy phần cuối làm tên nhóm
            $this->permissionGroups[$module][] = $perm;
        }

        // 2. Load dữ liệu nếu edit
        if ($id) {
            $this->isEdit = true;
            $this->roleId = $id;
            $role = Role::findOrFail($id);
            $this->name = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        }
    }

    public function save()
    {
        $this->validate(['name' => 'required|unique:roles,name,' . $this->roleId]);

        $role = Role::updateOrCreate(
            ['id' => $this->roleId],
            ['name' => $this->name, 'guard_name' => 'web']
        );

        // Sync permissions (array of names)
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('success', 'Lưu vai trò thành công.');
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('Admin::livewire.system.role-form');
    }
}