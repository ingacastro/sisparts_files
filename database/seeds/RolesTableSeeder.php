<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$role = Role::create(['guard_name' => 'web', 'name' => 'superadmin']);
		$role = Role::create(['guard_name' => 'web', 'name' => 'Cotizador']);
    }
}
