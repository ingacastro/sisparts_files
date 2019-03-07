<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use IParts\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        $user = User::create([
        	'name' => 'Admin',
        	'email' => 'admin@admin.com',
        	'password' => bcrypt('123456789')
        ]);

        $admin_role = Role::create(['guard_name' => 'web', 'name' => 'superadmin']);
         
        $user->assignRole($admin_role);
    }
}
