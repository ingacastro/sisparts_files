<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert(['id' => 1, 'name' => 'MXN']);
        DB::table('currencies')->insert(['id' => 2, 'name' => 'USD']);
        DB::table('currencies')->insert(['id' => 3, 'name' => 'EUR']);
    }
}
