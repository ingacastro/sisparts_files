<?php

use Illuminate\Database\Seeder;

class DocumentsSuppliesTableSeeder extends Seeder
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

        DB::table('conditions')->insert([
        	'previous_sale' => 'Salvo Previa venta',
        	'valid_prices' => 'Precios válidos',
        	'replacement' => 'Remplazo',
        	'factory_replacement' => 'Remplazo de fábrica',
        	'condition' => 'Condición: USADO',
        	'minimum_purchase' => 'Mínimo de compra',
        	'exworks' => 'Ex-Works International Parts'
        ]);
    }
}
