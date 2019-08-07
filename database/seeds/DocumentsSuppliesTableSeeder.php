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
        DB::table('utility_percentages')->insert(['name' => 'Nacional', 'percentage' => 33.30]);
        DB::table('utility_percentages')->insert(['name' => 'Internacional', 'percentage' => 37.50]);
        DB::table('utility_percentages')->insert(['name' => 'Remplazo', 'percentage' => 50.00]);
        DB::table('utility_percentages')->insert(['name' => 'Pieza usada', 'percentage' => 50.00]);

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
