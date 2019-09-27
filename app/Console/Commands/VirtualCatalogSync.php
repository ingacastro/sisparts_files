<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use IParts\Document;
use IParts\SupplySet;
use IParts\Supply;
use IParts\Supplier;
use IParts\File;
use IParts\SyncConnection;
use IParts\Replacement;
use IParts\Observation;
use DB;
use Storage;

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
        $this->virtual_cat_conn_name = 'mysql_virtual_catalog';
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
        $virtual_cat_sets = DB::connection($this->virtual_cat_conn_name)->table('cotizacion')
        ->get(); //->where('rfq', '!=', null)

        Log::notice(count($virtual_cat_sets));

        foreach($virtual_cat_sets as $virtual_cat_set) {

            DB::transaction(function() use ($virtual_cat_set) {            
                $document = $this->createDocument($virtual_cat_set);
                $this->createDocumentSupply($virtual_cat_set, $document);
            });
        }
    }

    private function createDocument(\stdClass $virtual_cat_set)
    {
        $sync_connection = SyncConnection::where('name', 'mysql_catalogo_virtual')->first();
        return Document::create([
            'sync_connections_id' => $sync_connection->id,
            'reference' => $virtual_cat_set->rfq,
            'type' => 'PCT',
            'status' => 1
        ]);
    }

    private function createDocumentSupply(\stdClass $virtual_cat_set, Document $document)
    {
        $supply = $this->createSupply($virtual_cat_set->proveedor, $virtual_cat_set->num_parte);

        $proveedor = $virtual_cat_set->proveedor;
        $suppliers_id = null;

        if(!empty($proveedor)) {
             $supplier = Supplier::where('trade_name', $proveedor)->first() ?? 
             Supplier::create(['trade_name' => $proveedor, 'marketplace' => 0]);
             $suppliers_id = $supplier->id;
         }
         
        SupplySet::create([
            'documents_id' => $document->id,
            'supplies_id' => $supply->id,
            'status' => 1, //Solicitud de cotización no enviada
            'suppliers_id' => $suppliers_id
        ]);
    }

    private function createSupply($proveedor, $number)
    {
        $supply = Supply::where('number', $number)->first();

        if($supply == null)
            $supply = Supply::create([
                'number' => $number,
                'tax' => 2 //Empty tax
            ]);

        $this->createFiles($supply, $number, $proveedor);
        $this->createObservations($supply);
        $this->createReplacements($supply);

        return $supply;
    }

    /*creates file if any, otherwise looks for a url */
    private function createFiles(Supply $supply, $supply_number, $proveedor)
    {
        $virtual_cat_files = DB::connection($this->virtual_cat_conn_name)->table('archivos_num_parte')
        ->where('num_parte', $supply_number)
        ->get();

        $virtual_catalog_urls = DB::connection($this->virtual_cat_conn_name)->table('producto_url')
        ->where('num_parte', $supply_number)
        ->get();

        $file_name = '';
        $supply_id = $supply->id;

        foreach($virtual_cat_files as $virtual_cat_file) {
            try {
                $file_name = uniqid() . '_' . $virtual_cat_file->nombre;
                Storage::disk('supplies_files')->put($file_name, $virtual_cat_file->contenido);

                $data['supplier'] = $proveedor;
                $data['path'] = 'storage/supplies_files/' . $file_name;

                $file = File::create($data);
                $file->supplies()->attach([$supply_id]);

            } catch(\Exception $e) {
                Storage::disk('supplies_files')->delete($file_name);
                Log::notice($e->getMessage());
            }
        }

        foreach($virtual_catalog_urls as $virtual_catalog_url) {
            $url_data['supplier'] = $proveedor;
            $url_data['url'] = $virtual_catalog_url->url;

            $file = File::create($url_data);
            $file->supplies()->attach([$supply_id]);
        }
    }

    private function createObservations(Supply $supply)
    {
        $observations = DB::connection($this->virtual_cat_conn_name)->table('producto_observaciones')
        ->where('num_parte', $supply->number)->get();

        foreach($observations as $observation) {
            Observation::create(['supplies_id' => $supply->id, 'description' => $observation->observacion]);
        }
    }
    private function createReplacements(Supply $supply)
    {
        $replacements = DB::connection($this->virtual_cat_conn_name)->table('producto_reemplazo')
        ->where('num_parte', $supply->number)->get();

        foreach($replacements as $replacement) {
            Replacement::create(['supplies_id' => $supply->id, 'description' => $replacement->reemplazo]); 
        }       
    }
}
