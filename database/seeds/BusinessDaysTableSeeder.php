<?php

use Illuminate\Database\Seeder;

class BusinessDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('business_days')->insert(['month' => 1, 'amount' => 1]);
        DB::table('business_days')->insert(['month' => 2, 'amount' => 1]);
        DB::table('business_days')->insert(['month' => 3, 'amount' => 1]);
        DB::table('business_days')->insert(['month' => 4, 'amount' => 0]);
        DB::table('business_days')->insert(['month' => 5, 'amount' => 1]);
        DB::table('business_days')->insert(['month' => 6, 'amount' => 0]);
        DB::table('business_days')->insert(['month' => 7, 'amount' => 0]);
        DB::table('business_days')->insert(['month' => 8, 'amount' => 0]);
        DB::table('business_days')->insert(['month' => 9, 'amount' => 1]);
        DB::table('business_days')->insert(['month' => 10, 'amount'  => 0]);
        DB::table('business_days')->insert(['month' => 11, 'amount'  => 1]);
        DB::table('business_days')->insert(['month' => 12, 'amount'  => 2]);    }
}
