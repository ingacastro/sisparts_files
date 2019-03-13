<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$spanish_id = DB::table('languages')->insertGetId(['name' => 'Español']);
		$english_id = DB::table('languages')->insertGetId(['name' => 'Inglés']);
		$portuguese_id = DB::table('languages')->insertGetId(['name' => 'Portugués']);
    }
}
