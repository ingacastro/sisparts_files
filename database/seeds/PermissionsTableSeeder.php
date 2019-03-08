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
        //Quotation
        $quotation_role = Role::create(['guard_name' => 'web', 'name' => 'Cotizador']);

        $permissions[] = Permission::create(['name' => 'dashboard']);
        //$permissions[] = Permission::create(['name' => 'inbox']);
        //$permissions[] = Permission::create(['name' => 'file']);
        $permissions[] = Permission::create(['name' => 'supplier-index']);
        $permissions[] = Permission::create(['name' => 'supplier-create']);
        $permissions[] = Permission::create(['name' => 'supplier-edit']);

        $quotation_role->syncPermissions($permissions);
    }
}
