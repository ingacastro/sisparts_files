<?php

use Illuminate\Database\Seeder;
use IParts\ColorSetting;

class ColorSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//Green
    	ColorSetting::create([
    		'color' => '#33e656',
    		'days' => 5
    	]);
    	//Yellow
    	ColorSetting::create([
    		'color' => '#ffbb33',
    		'days' => 10
    	]);
    	//Red
    	ColorSetting::create([
    		'color' => '#ff4444',
    		'days' => 15
    	]);
    	//Black
    	ColorSetting::create([
    		'color' => '#000000',
    		'days' => 20
    	]);
    }
}
