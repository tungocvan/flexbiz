<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        // $adminRole = Role::create(['name' => 'admin']);
        // $editorRole = Role::create(['name' => 'editor']);
        // $userRole = Role::create(['name' => 'user']);

        // // Create permissions
        // $listPostPermission = Permission::create(['name' => 'user-list']);
        // $createPostPermission = Permission::create(['name' => 'user-create']);
        // $editPostPermission = Permission::create(['name' => 'user-edit']);
        // $deletePostPermission = Permission::create(['name' => 'user-delete']);

        // Assign permissions to roles
        // $adminRole->givePermissionTo($listPostPermission);
        // $adminRole->givePermissionTo($createPostPermission);
        // $adminRole->givePermissionTo($editPostPermission);
        // $adminRole->givePermissionTo($deletePostPermission);


        // $editorRole->givePermissionTo($listPostPermission);
        // $editorRole->givePermissionTo($createPostPermission);
        // $editorRole->givePermissionTo($editPostPermission);

        // $userRole->givePermissionTo($listPostPermission);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Danh sách quyền (Format: group_name => [actions])
        $modules = [
            'dashboard' => ['view'],
            'product'   => ['view', 'create', 'edit', 'delete'],
            'order'     => ['view', 'edit', 'delete'],
            'customer'  => ['view', 'create', 'edit', 'delete'],
            'coupon'    => ['view', 'create', 'edit', 'delete'],
            'staff'     => ['view', 'create', 'edit', 'delete'],
            'role'      => ['view', 'create', 'edit', 'delete'],
            'setting'   => ['view', 'edit'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $action . '_' . $module]);
            }
        }

        // Tạo Role mặc định: Super Admin
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());
    }
}
