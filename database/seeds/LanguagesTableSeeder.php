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

        //Messages
        DB::table('messages')->insert(['languages_id' => $spanish_id, 'title' => 'Título', 'subject' => 'Asunto']);
        DB::table('messages')->insert(['languages_id' => $english_id, 'title' => 'Title', 'subject' => 'Subject']);
        DB::table('messages')->insert(['languages_id' => $portuguese_id, 'title' => 'Título', 'subject' => 'Sujeito']);
    }
}
