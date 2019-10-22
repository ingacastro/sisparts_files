<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use IParts\Document;
use IParts\Customer;
use IParts\Supply;
use IParts\SupplySet;
use IParts\Manufacturer;
use IParts\Employee;
use IParts\Binnacle;
use DB;
use Mail;
use IParts\Http\Helper;

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

    /*Connects and sync pcts from all of the siavcom connections*/
    private function connectAndSync(\stdClass $conn)
    {
        $documentsTable = config('siavcom_sync.siavcom_documents');
        $quotation_acronym = config('siavcom_sync.acr_quotation');
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
            'currency_id' => $siavcomDocument->mon_doc,
            'mxn_currency_exchange_rate' => $siavcomDocument->vmo_doc,
            'customer_requirement_number' => $siavcomDocument->ob1_doc,
            'buyer_name' => $siavcomDocument->ob2_doc,
            'buyer_number' => $siavcomDocument->tcd_tcd,
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
            $customer = $this->getCustomer($customerCode, $conn);
            if(!isset($customer)) { DB::rollback(); return; }

            //Document
            $data['customers_id'] = $customer->id;
            $document = Document::where('number',$documentNumber)
            ->where('sync_connections_id', $conn->id)->first();

            $is_new_pct = true;
            if($document) {  //PCT update
                $document->fill($data)->update(); 
                $is_new_pct = false;
            } else { //PCT create
                $data['status'] = 1;
                $data['employees_users_id'] = $dealer_ship->users_id;
                $data['sync_connections_id'] = $conn->id;
                $document = Document::create($data);
            }

            //Document's supplies
            $this->insertUpdateSupplies($document, $conn, $is_new_pct);

        } catch(\Exception $e) {
            Log::notice($e->getMessage());
            DB::rollback();
            return false;
        }
        DB::commit();
        return true;
    }

    private function insertUpdateSupplies(Document $document, \stdClass $conn, $is_new_pct)
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

        if($is_new_pct)
            $this->sendSuppliersQuotations($document);
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

            if(isset($siavcom_manufacturer)) 
                $manufacturer_id = $this->getManufacturer($siavcom_manufacturer, $document, $pivot, $siavcom_supply)->id;

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


        $pivot_data = [
            'set' => $pivot->mov_mov,
            'product_description' => $pivot->dse_mov,
            'products_amount' => $pivot->can_mov,
            'type' => $pivot->tdo_tdo,
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
            'measurement_unit_code' => $pivot->med_mov
        ];

        $supply_id = $supply->id;
        $document_supply = $document->supplies()->where('supplies_id', $supply_id)
        ->where('set', $pivot->mov_mov)->first();

        if(isset($document_supply))
            $document->supplies()->updateExistingPivot($supply_id, $pivot_data);
        else {
            $currency = DB::table('currencies')->where('id', $pivot->mon_mov)->first();
            
            $pivot_data['status'] = 1;
            $pivot['currencies_id'] = $currency->id ?? null;
            $pivot_data['sale_unit_cost'] = $pivot->pve_mov;
            $pivot_data['documents_id'] = $document->id;
            $pivot_data['supplies_id'] = $supply_id;
            $document_supply_id = DB::table('documents_supplies')->insertGetId($pivot_data);

            DB::table('checklist')->insert(['id' => $document_supply_id]);
            DB::table('measurements')->insert(['id' => $document_supply_id]);
            DB::table('documents_supplies_conditions')->insert(
                ['id' => $document_supply_id, 'description' => $supply->large_description]);
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
            'tax' => $tax,
            'measurement_unit' => $siavcom_supply->un1_isu
        ];

        $is_new_supply = true;
        if(isset($supply))
            $supply->fill($supply_data)->update();
        else
            $supply = Supply::create($supply_data);
        
        return $supply;
    }

    //Gets an existent manufacturer or creates a new one
    private function getManufacturer(\stdClass $siavcom_manufacturer, Document $document, \stdClass $siavcom_set, \stdClass $siavcom_supply)
    {
        $key_xmd = $siavcom_manufacturer->key_xmd;

        $siavcom_manufacturer_name = simplexml_load_string($siavcom_manufacturer->xml_xmd)->data[0]->attributes()['FABRICANTE'];

        $siavcom_manufacturer_name = trim($siavcom_manufacturer_name);

        $manufacturer = Manufacturer::where('name', $siavcom_manufacturer_name)->first();

        //If no manufacturer with this name was found, create
        if(!$manufacturer) {
            $manufacturer_data = [
                'name' => $siavcom_manufacturer_name ?? null,
                'document_type' => $siavcom_manufacturer->xml_xmd
            ];
            //$manufacturer_data['siavcom_key_xmd'] = $key_xmd;
            $manufacturer = Manufacturer::create($manufacturer_data);
        } 

        return $manufacturer;
    }

    //Send quotation email to every supplier selling the brand/manufacturer specified
    private function sendSuppliersQuotations(Document $document)
    {
        $supplies_sets = $document->supply_sets;
        $sets_ids = $supplies_sets->pluck('id');
        $supplies_ids = $supplies_sets->pluck('supplies_id');
        $supplies = Supply::whereIn('id', $supplies_ids);
        $supplies_ids = $supplies->pluck('id');
        $manufacturers_ids = $supplies->pluck('manufacturers_id');

        $manufacturers = Manufacturer::whereIn('id', $manufacturers_ids)->get();

/*        $suppliers = $manufacturer->suppliers;
        $supplies = $manufacturer->supplies->whereIn('id', $supplies_ids);*/

        try {        
            foreach($manufacturers as $manufacturer) {
                foreach($manufacturer->suppliers as $supplier) {
                    $man_supplies_ids = $supplies->where('manufacturers_id', $manufacturer->id)->pluck('id');
                    $supply_sets = SupplySet::whereIn('supplies_id', $man_supplies_ids)->get();
                    if($supply_sets->count() > 0)
                        $this->sendQuotationEmail($supplier->email, $supply_sets, $document);
                }
            }
        } catch(\Exception $e) {
            Log::notice($e->getMessage());
        }
    }

    private function sendQuotationEmail($email, $supply_sets, Document $document)
    {
        //Log::notice("Supplier found, sending email to $email");
        //Spanish as default, cause we have custom emails in addition to registered suppliers
        $message = DB::table('messages_languages')
        ->join('languages', 'languages.id', 'messages_languages.languages_id')
        ->where('languages.name', 'Español')->first();

        $dealership_name = null;
        $dealership_email = null;
        $dealership_ext = null;

        if($document->dealership) {
            $dealership_name = $document->dealership->user->name;
            $dealership_email = $document->dealership->user->email;
            $dealership_ext = $document->dealership->ext;
        }

        $subject = $message->subject . ' PCT'  . $document->number . ' ' . $document->reference;

        $body = $message->body . '<table>';

        foreach($supply_sets as $set) {
            $supply = $set->supply;
            $supply->manufacturer->name;
            $body .= '<tr>' . 
            '<td><div>Número de parte: ' . $supply->cla_isu . '</div>' .
            '<div>Descripción: ' . $set->product_description . '</div>' .
            '<div>Fabricante: ' . $supply->manufacturer->name . '</div>' .
            '<div>Cantidad: ' . (int)$set->products_amount . ' pzs</div></td>';
        }

        $body .= '</table>';

        $body .= '<div>-----------------------------------------</div>' .
        '<div>Cotizador: ' . $dealership_name . '</div>' .
        '<div>Correo de cotizador: ' . $dealership_email . '</div>' . 
        '<div>Teléfono de cotizador:' . $dealership_ext . '</div>';

        try {            
/*            Mail::send([], [], function($m) use ($email, $subject, $body) {
                $m->to($email);
                $m->subject($subject);
                $m->setBody($body, 'text/html');
            });*/
            
            Helper::sendMail($email, $subject, $body, 'admin@admin.com', null);
        } catch(\Exception $e) {
            throw new \Exception("Error al enviar el correo.", 1);
        }

        $this->registerQuotationEmailBinnacle($email, $document);
    }

    private function registerQuotationEmailBinnacle($email, Document $doc)
    {
        try {        
            

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
            $doc->fill(['status' => 2])->update();
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
