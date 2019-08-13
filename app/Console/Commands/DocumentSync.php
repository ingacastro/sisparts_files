<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use IParts\Document;
use IParts\Customer;
use IParts\Supply;
use IParts\Manufacturer;
use IParts\Employee;
use IParts\Binnacle;
use DB;
use Mail;

class DocumentSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siavcom:document-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Siavcom Document/PCT synchronization.';

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
        $sync_connections = DB::table('sync_connections')->where('name', 'like', 'pgsql_%')->get();
        foreach($sync_connections as $conn) {
            //if($conn->name == 'pgsql_zukaely') continue;
            try {
                $this->connectAndSync($conn);
            } catch (\Exception $e) {
                Log::notice($e->getMessage());
            }
        }
    }
    
    /*Syncs all of the documents(type pct) from mxmro, pavan and zukaely postgres databases*/
/*    private function connectAndSync(String $conn_name)
    {
        $documentsTable = config('siavcom_sync.siavcom_documents');
        $quotation_acronym = config('siavcom_sync.acr_quotation');

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
        $documentsTable = config('siavcom_sync.siavcom_documents');
        $quotation_acronym = config('siavcom_sync.acr_quotation');
        //Log::notice($conn->name . '  ' . $documentsTable);
        $siavcomDocuments = DB::connection($conn->name)->table($documentsTable)
        ->where('tdo_tdo', $quotation_acronym)
        //->whereIn('ndo_doc', [201,1068,1082,2096,5233,2468,3370,3389,2865,5399])
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
        $dealer_ship = Employee::where('buyer_number', $siavcomDocument->tcd_tcd)->first();

        //Default quoter
        if($dealer_ship == null)
            $dealer_ship = Employee::where('buyer_number', config('siavcom_sync.generic_quoter_buyer_num'))->first();
         
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
            'employees_users_id' => $dealer_ship->users_id,
            'cop_nom' => $siavcomDocument->cop_nom,
            'con_con' => $siavcomDocument->con_con,
            'fel_doc' => $siavcomDocument->fel_doc,
            'fec_doc' => $siavcomDocument->fec_doc,
            'im1_doc' => $siavcomDocument->im1_doc,
            'im2_doc' => $siavcomDocument->im2_doc,
            'im4_doc' => $siavcomDocument->im4_doc,
            'im5_doc' => $siavcomDocument->im5_doc,
            'com_doc' => $siavcomDocument->com_doc,
            'vm4_doc' => $siavcomDocument->vm4_doc,
            'vm5_doc' => $siavcomDocument->vm5_doc,
            'sal_doc' => $siavcomDocument->sal_doc,
            'ob1_doc' => $siavcomDocument->ob1_doc,
            'sau_doc' => $siavcomDocument->sau_doc,
            'fau_doc' => $siavcomDocument->fau_doc,
            'rut_rut' => $siavcomDocument->rut_rut,
            'num_pry' => $siavcomDocument->num_pry,
            'che_doc' => $siavcomDocument->che_doc,
            'usu_usu' => $siavcomDocument->usu_usu,
            'tor_doc' => $siavcomDocument->tor_doc,
            'nor_doc' => $siavcomDocument->nor_doc,
            'im0_doc' => $siavcomDocument->im0_doc,
            'mov_doc' => $siavcomDocument->mov_doc,
            'fip_doc' => $siavcomDocument->fip_doc,
            'tpa_doc' => $siavcomDocument->tpa_doc,
            'rpa_doc' => $siavcomDocument->rpa_doc,
            'tip_tdn' => $siavcomDocument->tip_tdn,
            'npa_doc' => $siavcomDocument->npa_doc,
            'mpa_sat' => $siavcomDocument->mpa_sat,
            'fpa_sat' => $siavcomDocument->fpa_sat,
            'uso_sat' => $siavcomDocument->uso_sat,
            'ndr_doc' => $siavcomDocument->ndr_doc,
            'dto_doc' => $siavcomDocument->dto_doc,
            'mon_doc' => $siavcomDocument->mon_doc,
            'vmo_doc' => $siavcomDocument->vmo_doc,
            'vm2_doc' => $siavcomDocument->vm2_doc,
            'vm3_doc' => $siavcomDocument->vm3_doc
        ];

        DB::beginTransaction();
        try {       
            //Document's customer   
            $customer = $this->getCustomer($customerCode,
             $conn);
            if(!isset($customer)) { DB::rollback(); return; }

            //Document
            $data['customers_id'] = $customer->id;
            $document = Document::where('number',$documentNumber)
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

        $documentSuppliesTable = config('siavcom_sync.siavcom_documents_supplies');

        $siavcomDocumentSupplies = DB::connection($conn->name)->table($documentSuppliesTable)
        ->where('ndo_doc', $documentNumber)
        ->where('tdo_tdo', config('siavcom_sync.acr_quotation'))->get(); //supplies_sets type PCT

        foreach($siavcomDocumentSupplies as $pivot) {
            $this->attachDocumentSupply($pivot, $conn,  $document);
        }
    }

    //Inserts on document_supplies table
    private function attachDocumentSupply(\stdClass $pivot, \stdClass $conn, $document)
    {
        $suppliesTable = config('siavcom_sync.siavcom_supplies');
        $manufacturersTable = config('siavcom_sync.siavcom_manufacturers');

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
            if(isset($siavcom_manufacturer)) $manufacturer_id = $this->getManufacturer($siavcom_manufacturer, $document)->id;

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
            'currencies_id' => $currency->id ?? null,
            'status' => 1,
            'ens_mov' => $pivot->ens_mov,
            'inv_tdo' => $pivot->inv_tdo,
            'dga_pro' => $pivot->dga_pro,
            'de1_mov' => $pivot->de1_mov,
            'de2_mov' => $pivot->de2_mov,
            'de3_mov' => $pivot->de3_mov,
            'de4_mov' => $pivot->de4_mov,
            'de5_mov' => $pivot->de5_mov,
            'im1_mov' => $pivot->im1_mov,
            'im2_mov' => $pivot->im2_mov,
            'im4_mov' => $pivot->im4_mov,
            'im5_mov' => $pivot->im5_mov,
            'adv_tar' => $pivot->adv_tar,
            'cuo_tar' => $pivot->cuo_tar,
            'npe_mov' => $pivot->npe_mov,
            'mpe_mov' => $pivot->mpe_mov,
            'cen_mov' => $pivot->cen_mov,
            'est_mov' => $pivot->est_mov,
            'im0_mov' => $pivot->im0_mov,
            'usu_usu' => $pivot->usu_usu,
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

        //Undefined tax
        $tax = 2;
        if($siavcom_supply->ta3_isu == 'I1') $tax = 1; //16%
        else if($siavcom_supply->ta3_isu == 'I4') $tax = 0; //0%

        $supply_data = [
            'number' => $cla_isu,
            'manufacturers_id' => $manufacturer_id,
            'short_description' => $siavcom_supply->des_isu,
            'large_description' => $siavcom_supply->dea_isu,
            'tax' => $tax
        ];

        $is_new_supply = true;
        if(isset($supply))
            $supply->fill($supply_data)->update();
        else
            $supply = Supply::create($supply_data);
        
        return $supply;
    }

    //Creates a new manufacturer if it doesn't exist
    private function getManufacturer(\stdClass $siavcom_manufacturer, Document $document)
    {
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

        $this->sendSuppliersQuotations($manufacturer, $document);

        return $manufacturer;
    }

    //Send quotation email to every supplier selling the brand/manufacturer specified
    private function sendSuppliersQuotations(Manufacturer $manufacturer, Document $document)
    {
        $suppliers = $manufacturer->suppliers;
        $supplies = $manufacturer->supplies;

        if($suppliers->count() == 0 || $supplies->count() == 0) return;

        $supplies = implode(', ', $supplies->pluck('number')->toArray());

        try {        
            foreach($suppliers as $supplier) {
                $this->sendQuotationEmail($supplier->email, $manufacturer->name, $supplies, $document);
            }
        } catch(\Exception $e) {
            Log::notice($e->getMessage());
        }
    }

    private function sendQuotationEmail($email, $manufacturer, $supplies, Document $document)
    {
        //Spanish as default, cause we have custom emails in addition to registered suppliers
        $message = DB::table('messages_languages')
        ->join('languages', 'languages.id', 'messages_languages.languages_id')
        ->where('languages.name', 'Español')->first();

        $subject = $message->subject;
        $body = $message->body . '<div>Fabricante: <strong>' . $manufacturer . '</strong></div>' .
        '<div>Partes: ' . $supplies . '</div>';

        try {            
            Mail::send([], [], function($m) use ($email, $subject, $body) {
                $m->to($email);
                $m->subject($subject);
                $m->setBody($body, 'text/html');
            });
        } catch(\Exception $e) {
            throw new \Exception("Error al enviar el correo.", 1);
        }

        $this->registerQuotationEmailBinnacle($email, $document);
    }

    private function registerQuotationEmailBinnacle($email, Document $doc)
    {
        try {        
            
            $doc->fill(['status' => 2])->update();

            $binnacle_data = [
                'entity' => 1, //Document
                'pct_status' => $doc->status, //In process
                'comments' => 'Solicitud de cotización enviada al proveedor ' . $email,
                'users_id' => null,
                'type' => 2, //Just a silly number that means nothing
                'documents_id' => $doc->id,
                'documents_supplies_id' => null
            ];

            Binnacle::create($binnacle_data);
        } catch(\Exception $e) {
            throw new \Exception("Error al registrat la bitácora.", 1);
        }
    }

    /*Retrieves created/found customer based on siavcom database customer code*/
    private function getCustomer($code, \stdClass $conn)
    {
        $customersTable = config('siavcom_sync.siavcom_customers');
        $siavcom_customer = DB::connection($conn->name)->table($customersTable)
        ->where('cod_nom', $code)
        ->where('cop_nom', 'C')
        ->first();

        //If customer wasn't found on siavcom db, we're not gonna try to find it or create it
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
                'country' => $siavcom_customer->pai_nom,
                'type' => $siavcom_customer->tip_tdn
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
