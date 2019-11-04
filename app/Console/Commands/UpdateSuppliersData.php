<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use DB;
use IParts\Supplier;
use Illuminate\Support\Facades\Log;

class UpdateSuppliersData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'virtual_catalog:update_suppliers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating sisparts suppliers data from virtual catalog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->virtual_cat_conn_name = 'mysql_virtual_catalog';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->updateSuppliers();
    }

    private function updateSuppliers()
    {

      $suppliers = Supplier::all();

      foreach ($suppliers as $supplier) {

        $virtual_cat_supplier = DB::connection($this->virtual_cat_conn_name)->table('proveedor')
        ->where('proveedor', $supplier->trade_name)->orderBy('id', 'desc')->first(); 

        if(!$virtual_cat_supplier) continue;

        $supplier->email = $virtual_cat_supplier->email;
        $supplier->update();

      }
    }
}
