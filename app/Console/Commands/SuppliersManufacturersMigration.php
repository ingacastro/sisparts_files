<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use DB;
use IParts\Supplier;
use IParts\Manufacturer;
use Illuminate\Support\Facades\Log;

class SuppliersManufacturersMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'virtual_catalog:suppliers_manufacturers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suppliers manufacturers relationships';

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
        $this->attachSupplierManufacturers();
    }

     private function attachSupplierManufacturers()
     {

      $suppliers = Supplier::all();

      foreach ($suppliers as $supplier) {

        $virtual_cat_manufacturers = DB::connection($this->virtual_cat_conn_name)->table('producto_proveedor')
        ->where('proveedor', $supplier->trade_name)
        ->whereNotNull('marca')
        ->where('marca', '!=', '')->get();

        $manufacturers_ids = [];
        $supplier_brands_ids = $supplier->brands->pluck('id')->toArray();
        

        foreach ($virtual_cat_manufacturers as $virtual_cat_manufacturer) {

          $virtual_cat_brand_name = trim($virtual_cat_manufacturer->marca);

          $manufacturer = Manufacturer::where('name', $virtual_cat_brand_name)->first();
          $sisparts_manufacturer = isset($manufacturer) ? $manufacturer
                                   : Manufacturer::create(['name' => $virtual_cat_brand_name]);
          if(!in_array($sisparts_manufacturer->id, $supplier_brands_ids)) 
            $manufacturers_ids[] = $sisparts_manufacturer->id;
        }
        
        $manufacturers_ids = array_unique($manufacturers_ids);
        $supplier->brands()->attach($manufacturers_ids);
      }
    }
}
