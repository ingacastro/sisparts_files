<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*México*/
        $mexico_id = DB::table('countries')->insertGetId(['name' => 'México']);
        DB::table('states')->insert(['name' => 'Jalisco', 'countries_id' => $mexico_id]);
        /*End México*/
    }
}
