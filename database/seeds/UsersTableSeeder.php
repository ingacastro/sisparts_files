<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use IParts\User;
use IParts\Employee;

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
        	'name' => 'Administrador',
        	'email' => 'admin@admin.com',
        	'password' => bcrypt('123456789')
        ]);

        $admin_role = Role::create(['guard_name' => 'web', 'name' => 'Administrador']);
         
        $user->assignRole($admin_role);

        //Default quoter
        $quoter = User::create([
            'name' => 'Cotizador genérico',
            'email' => 'cotizador_gral@siavcom.com',
            'password' => bcrypt(str_random(8))
        ]);

        $quoter->assignRole('Cotizador');

        Employee::create([
            'users_id' => $quoter->id,
            'number' => '999999',
            'buyer_number' => '999'
        ]);
    }
}
