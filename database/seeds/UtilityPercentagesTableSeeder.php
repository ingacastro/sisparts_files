<?php

use Illuminate\Database\Seeder;

class UtilityPercentagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('utility_percentages')->insert(['name' => 'Nacional', 'percentage' => 5]);
        DB::table('utility_percentages')->insert(['name' => 'Internacional', 'percentage' => 10]);
        DB::table('utility_percentages')->insert(['name' => 'Remplazo', 'percentage' => 15]);
        DB::table('utility_percentages')->insert(['name' => 'Pieza usada', 'percentage' => 20]);
    }
}
