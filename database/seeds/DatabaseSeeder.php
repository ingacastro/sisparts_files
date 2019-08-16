<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(ColorSettingsTableSeeder::class);
        $this->call(SyncConnectionsTableSeeder::class);
        $this->call(DocumentsSuppliesTableSeeder::class);
        //$this->call(SuppliesSetsStatusTableSeeder::class);
        $this->call(BusinessDaysTableSeeder::class);
    }
}
