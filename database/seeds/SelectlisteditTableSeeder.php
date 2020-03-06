<?php

use IParts\Selectlistauth;
use Illuminate\Database\Seeder;

class SelectlisteditTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $select = new Selectlistauth();
        $select->name = 'Llamada';
        $select->status = 'Visible';
        $select->save();
    }
}
