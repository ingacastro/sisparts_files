<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Quotation*/
/*        $quotation_role = Role::create(['guard_name' => 'web', 'name' => 'Cotizador']);

        $permissions[] = Permission::create(['name' => 'dashboard']);
        //$permissions[] = Permission::create(['name' => 'inbox']);
        //$permissions[] = Permission::create(['name' => 'file']);
        $permissions[] = Permission::create(['name' => 'supplier-get-list']);
        $permissions[] = Permission::create(['name' => 'supplier-create-brand']);
        $permissions[] = Permission::create(['name' => 'supplier-sync-brands']);
        $permissions[] = Permission::create(['name' => 'supplier-index']);
        $permissions[] = Permission::create(['name' => 'supplier-create']);
        $permissions[] = Permission::create(['name' => 'supplier-edit']);

        $quotation_role->syncPermissions($permissions);*/
        
        /*Other Permissions*/
        Permission::create(['name' => 'user-get-list']);
        Permission::create(['name' => 'user-index']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'color-settings-edit']);
        Permission::create(['name' => 'message-get-list']);
        Permission::create(['name' => 'message-index']);
        Permission::create(['name' => 'message-create']);
        Permission::create(['name' => 'message-edit']);
    }
}
