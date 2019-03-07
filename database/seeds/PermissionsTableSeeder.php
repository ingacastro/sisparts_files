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
        $permissions[] = Permission::create(['name' => 'index supplier']);
        $permissions[] = Permission::create(['name' => 'create supplier']);
        $permissions[] = Permission::create(['name' => 'edit supplier']);

        $quotation_role->syncPermissions($permissions);
    }
}
