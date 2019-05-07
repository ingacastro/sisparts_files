<?php

use Illuminate\Database\Seeder;

class SuppliesSetsStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplies_sets_status')->insert(['id' => 1, 'name' => 'No solicitado']);
        DB::table('supplies_sets_status')->insert(['id' => 2, 'name' => 'Solicitado automáticamente']);
        DB::table('supplies_sets_status')->insert(['id' => 3, 'name' => 'Solicitado manualmente']);
        DB::table('supplies_sets_status')->insert(['id' => 4, 'name' => 'Confirmado por el proveedor']);
        DB::table('supplies_sets_status')->insert(['id' => 5, 'name' => 'Presupuesto capturado']);
        DB::table('supplies_sets_status')->insert(['id' => 6, 'name' => 'En Autorización']);
        DB::table('supplies_sets_status')->insert(['id' => 7, 'name' => 'Rechazado.']);
    }
}
