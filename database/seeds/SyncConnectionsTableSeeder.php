<?php

use Illuminate\Database\Seeder;

class SyncConnectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Postgres db connections for pct sync
        DB::table('sync_connections')->insert(['name' => 'pgsql_mxmro', 'display_name' => 'Mxmro']);
        DB::table('sync_connections')->insert(['name' => 'pgsql_pavan', 'display_name' => 'Intl Parts']);
        DB::table('sync_connections')->insert(['name' => 'pgsql_zukaely', 'display_name' => 'Zukaely']);
        DB::table('sync_connections')->insert(['name' => 'mysql_catalogo_virtual', 'display_name' => 'Catálogo virtual']);
    }
}
