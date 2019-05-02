<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use IParts\Document;
use IParts\Customer;
use IParts\Supply;
use IParts\Manufacturer;
use IParts\Employee;
use DB;

class DocumentSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siavcom:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Siavcom PCT synchronization.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
        $sync_connections = DB::table('sync_connections')->get();
        foreach($sync_connections as $conn) {
            //if($conn->name == 'pgsql_zukaely') continue;
            $this->connectAndSync($conn);
        }
    }
    
    /*Syncs all of the documents(type pct) from mxmro, pavan and zukaely postgres databases*/
/*    private function connectAndSync(String $conn_name)
    {
        $documentsTable = env('SIAVCOM_DOCUMENTS');
        $quotation_acronym = env('ACR_QUOTATION');

        DB::connection($conn_name)->table($documentsTable)
        ->where('tdo_tdo', $quotation_acronym)
        ->orderBy('key_pri')
        ->chunk(1000, function($documents) use ($conn_name) {
            foreach($documents as $document) {
                if($this->createUpdateDocument($document, $conn_name) == false) continue;
            }
        });
    }*/

    //TEST, ONLY 1 DB CONNECTION  
    private function connectAndSync(\stdClass $conn)
    {
        $documentsTable = env('SIAVCOM_DOCUMENTS');
        $quotation_acronym = env('ACR_QUOTATION');

        $siavcomDocuments = DB::connection($conn->name)->table($documentsTable)
        ->where('tdo_tdo', $quotation_acronym)
        ->whereIn('ndo_doc', [201,1068,1082,2096,5233,2468,3370,3389,2865,5399])
        ->get();
        foreach($siavcomDocuments as $siavcomDocument) {
            if($this->createUpdateDocument($siavcomDocument, $conn) == false) continue;
        }
    }

    /*Insert all the necessary data in the required tables, to create a document(type pct)*/
    private function createUpdateDocument(\stdClass $siavcomDocument, \stdClass $conn)
    {
        $customerCode = $siavcomDocument->cod_nom;
        $documentNumber = $siavcomDocument->ndo_doc;
        $quoter = Employee::where('buyer_number', $siavcomDocument->tcd_tcd)->first();

        //Default quoter
        if($quoter == null)
            $quoter = Employee::where('buyer_number', env('GENERIC_QUOTER_BUYER_NUM'))->first();
         
        $data = [
            'type' => $siavcomDocument->tdo_tdo,
            'number' => $siavcomDocument->ndo_doc,
            'reference' => $siavcomDocument->ref_doc,
            'customer_code' => $customerCode,
            'seller_number' => $siavcomDocument->ven_ven,
            'state' => $siavcomDocument->sta_doc,
            'status' => 1,
            'currency_id' => $siavcomDocument->mon_doc,
            'mxn_currency_exchange_rate' => $siavcomDocument->vmo_doc,
            'customer_requirement_number' => $siavcomDocument->ob1_doc,
            'buyer_name' => $siavcomDocument->ob2_doc,
            'buyer_number' => $siavcomDocument->tcd_tcd,
            'employees_users_id' => $quoter->users_id
        ];

        DB::beginTransaction();
        try {       
            //Document's customer   
            $customer = $this->getCustomer($customerCode, $conn);
            if(!isset($customer)) { DB::rollback(); return; }

            //Document
            $data['customers_id'] = $customer->id;
            $document = Document::where('number', $documentNumber)
                        ->where('sync_connections_id', $conn->id)->first();

            if(isset($document))
                $document->fill($data)->update();
            else {
                $data['sync_connections_id'] = $conn->id;
                $document = Document::create($data);
            }

            //Document's supplies
            $this->insertUpdateSupplies($document, $conn);

        } catch(\Exception $e) {
            Log::notice($e->getMessage());
            DB::rollback();
            return false;
        }
        DB::commit();
        return true;
    }

    private function insertUpdateSupplies(Document $document, \stdClass $conn)
    {
        $documentId = $document->id;
        $documentNumber = $document->number;

        $documentSuppliesTable = env('SIAVCOM_DOCUMENTS_SUPPLIES');

        $siavcomDocumentSupplies = DB::connection($conn->name)->table($documentSuppliesTable)
        ->where('ndo_doc', $documentNumber)->get();
        //->where('tdo_tdo', env('ACR_QUOTATION'))->get();

        //Document has no supplies
        if(empty($siavcomDocumentSupplies)) return;

        foreach($siavcomDocumentSupplies as $pivot) {
            $this->attachDocumentSupply($pivot, $conn,  $document);
        }
    }

    //Inserts on document_supplies table
    private function attachDocumentSupply(\stdClass $pivot, \stdClass $conn, $document)
    {
        $suppliesTable = env('SIAVCOM_SUPPLIES');
        $manufacturersTable = env('SIAVCOM_MANUFACTURERS');

        //Supply
        $siavcom_supply = DB::connection($conn->name)->table($suppliesTable)
        ->where('cla_isu', $pivot->cla_isu)->first();

        if(!isset($siavcom_supply)) return;

        //Manufacturer
        $siavcom_manufacturer = DB::connection($conn->name)->table($manufacturersTable)
        ->where('key_xmd', $siavcom_supply->key_pri)->first();

/*        if(!isset($siavcom_manufacturer)) return;*/

        DB::beginTransaction();
        try {    
            $manufacturer_id = null;
            if(isset($siavcom_manufacturer)) $manufacturer_id = $this->getManufacturer($siavcom_manufacturer)->id;

            $supply = $this->getSupply($siavcom_supply, $manufacturer_id);
            $this->insertDocumentSupply($pivot, $document, $supply);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            Log::notice($e->getMessage());
        }
    }

    //documents-supplies relationship
    private function insertDocumentSupply(\stdClass $pivot, Document $document, Supply $supply) {

        $currency = DB::table('currencies')->where('id', $pivot->mon_mov)->first();

        $pivot_data = [
            'set' => $pivot->mov_mov,
            'product_description' => $pivot->dse_mov,
            'products_amount' => $pivot->can_mov,
            'measurement_unit_code' => $pivot->med_mov,
            'sale_unit_cost' => $pivot->pve_mov,
            'type' => $pivot->tdo_tdo,
            'currencies_id' => $currency->id ?? null
        ];

        $supply_id = $supply->id;
        $document_supply = $document->supplies()->find($supply_id);

        if(isset($document_supply))
            $document->supplies()->updateExistingPivot($supply_id, $pivot_data);
        else{

            $pivot_data['documents_id'] = $document->id;
            $pivot_data['supplies_id'] = $supply_id;
            $document_supply_id = DB::table('documents_supplies')->insertGetId($pivot_data);

            DB::table('checklist')->insert(['id' => $document_supply_id]);
            DB::table('measurements')->insert(['id' => $document_supply_id]);
            DB::table('documents_supplies_conditions')->insert(['id' => $document_supply_id]);
        }
    }

    //Find or create a supply
    private function getSupply(\stdClass $siavcom_supply, $manufacturer_id)
    {
        //Retrieve supply or create it
        $cla_isu = $siavcom_supply->cla_isu;
        $supply = Supply::where('number', $cla_isu)->first();
        $supply_data = [
            'number' => $cla_isu,
            'manufacturers_id' => $manufacturer_id
        ];

        $is_new_supply = true;
        if(isset($supply))
            $supply->fill($supply_data)->update();
        else
            $supply = Supply::create($supply_data);
        
        return $supply;
    }

    //Creates a new manufacturer if it doesn't exist
    private function getManufacturer(\stdClass $siavcom_manufacturer)
    {
        //Retrieve manufacturer or create it
        $key_xmd = $siavcom_manufacturer->key_xmd;
        $manufacturer = Manufacturer::where('siavcom_key_xmd', $key_xmd)->first();
        $manufacturer_data = [
            'name' => simplexml_load_string($siavcom_manufacturer->xml_xmd)->data[0]->attributes()['FABRICANTE'] ?? null,
            'document_type' => $siavcom_manufacturer->xml_xmd,
            'siavcom_key_xmd' => $key_xmd
        ];
        if(isset($manufacturer))
            $manufacturer->fill($manufacturer_data)->update();
        else
            $manufacturer = Manufacturer::create($manufacturer_data);

        return $manufacturer;
    }

    /*Retrieves created/found customer based on siavcom database customer code*/
    private function getCustomer($code, \stdClass $conn)
    {
        $customersTable = env('SIAVCOM_CUSTOMERS');
        $siavcom_customer = DB::connection($conn->name)->table($customersTable)
        ->where('cod_nom', $code)
        ->where('cop_nom', 'C')
        ->first();

        //If customer were found on siavcom db, we're not gonna try to find it or create it
        if(!isset($siavcom_customer)) return null;
        
        //Otherwise, we found it, or create it in our db
        $customer = Customer::where('code', $code)
                    ->where('sync_connections_id', $conn->id)
                    ->first();

        $data = [
                'code' => $siavcom_customer->cod_nom,
                'trade_name' => $siavcom_customer->cli_nom,
                'business_name' => $siavcom_customer->nom_nom,
                'post_code' => $siavcom_customer->cpo_nom,
                'state' => $siavcom_customer->edo_edo,
                'country' => $siavcom_customer->pai_nom
            ];

        if(isset($customer))
            $customer->fill($data)->update();
        else{
            $data['sync_connections_id'] = $conn->id;
            $customer = Customer::create($data);
        }

        return $customer;
    }
}
