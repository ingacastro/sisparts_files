<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;

class VirtualCatalogSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'virtual_catalog:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate quotations, supplies sets, files and suppliers from virtual catalog db.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->conn_name = 'virtual_catalog';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->main();
    }

    private function main()
    {
        $supplies_sets = DB::connection($this->conn_name)->table('cotizacion')
        ->get();
        Log::notice($supplies_sets);
    }
}
