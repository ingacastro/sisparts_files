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
        DB::table('sync_connections')->insert(['name' => 'pgsql_mxmro']);
        DB::table('sync_connections')->insert(['name' => 'pgsql_pavan']);
        DB::table('sync_connections')->insert(['name' => 'pgsql_zukaely']);
    }
}
