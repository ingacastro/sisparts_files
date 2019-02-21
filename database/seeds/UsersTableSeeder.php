<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['guard_name' => 'web', 'name' => 'superadmin']);

        $user = User::create([
        	'name' => 'Admin',
        	'email' => 'admin@admin.com',
        	'password' => bcrypt('123456789')
        ]);

        $user->assignRole($role);
    }
}
