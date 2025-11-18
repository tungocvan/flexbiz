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
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $listPostPermission = Permission::create(['name' => 'user-list']);
        $createPostPermission = Permission::create(['name' => 'user-create']);
        $editPostPermission = Permission::create(['name' => 'user-edit']);
        $deletePostPermission = Permission::create(['name' => 'user-delete']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($listPostPermission);
        $adminRole->givePermissionTo($createPostPermission);
        $adminRole->givePermissionTo($editPostPermission);
        $adminRole->givePermissionTo($deletePostPermission);


        $editorRole->givePermissionTo($listPostPermission);
        $editorRole->givePermissionTo($createPostPermission);
        $editorRole->givePermissionTo($editPostPermission);

        $userRole->givePermissionTo($listPostPermission);
    }
}
