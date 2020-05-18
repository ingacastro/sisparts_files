<?php

use Illuminate\Database\Seeder;
use IParts\NumberOfAutomaticEmail;

class NumberOfAutomaticEmailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $init = new NumberOfAutomaticEmail;
        $init->quantity = 1;
        $init->save();
    }
}
