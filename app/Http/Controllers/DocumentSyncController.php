<?php

namespace IParts\Http\Controllers;

use Illuminate\Support\Facades\Log;
use IParts\Document;
use IParts\Customer;
use IParts\Supply;
use IParts\Manufacturer;
use DB;

class DocumentSyncController extends Controller
{
	/*Syncs all of the documents(type pct) from mxmro, pavan and zukaely postgres databases*/
    public function siavcomQuotationsSync()
    {
    	$documentsTable = env('SIAVCOM_DOCUMENTS');
    	$quotation_acronym = env('ACR_QUOTATION');

/*    	DB::connection('pgsql_pavan')->table($documentsTable)
    	->orderBy('key_pri')
    	->chunk(10, function($documents){
    		foreach($documents as $k => $document) {
    			if($k == 9) return;
    			if($this->createDocument($document, 'pgsql_pavan') == false) continue;
    		}
    	});*/
    	$siavcomDocuments = DB::connection('pgsql_pavan')->table($documentsTable)
    	->where('tdo_tdo', $quotation_acronym)
    	->take(10)->get();
		foreach($siavcomDocuments as $k => $siavcomDocument) {
			if($this->createDocument($siavcomDocument, 'pgsql_pavan') == false) continue;
		}
    }

    /*Insert all the necessary data in the required tables, to create a document(type pct) */
    private function createDocument(\stdClass $siavcomDocument, $dbConnection)
    {
    	$customerCode = $siavcomDocument->cod_nom;
	    
    	$document_data = [
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
    	];

    	DB::beginTransaction();
    	try {    	
    		//Document's customer	
    		$customer = $this->getCustomer($customerCode, $dbConnection);
    		if(!isset($customer)) { DB::rollback(); return; }

    		//Document
	    	$document_data['customers_id'] = $customer->id;
	    	$document = Document::create($document_data);

    		//Document's supplies
    		$this->insertSupplies($document, $dbConnection);

    	} catch(\Exception $e) {
    		Log::notice($e->getMessage());
    		DB::rollback();
    		return false;
    	}
    	DB::commit();
    	return true;
    }

    private function insertSupplies(Document $document, $dbConnection)
    {
    	$documentId = $document->id;
    	$documentNumber = $document->number;

		$documentSuppliesTable = env('SIAVCOM_DOCUMENTS_SUPPLIES');
		$suppliesTable = env('SIAVCOM_SUPPLIES');
		$manufacturersTable = env('SIAVCOM_MANUFACTURERS');

    	$siavcomDocumentSupplies = DB::connection($dbConnection)->table($documentSuppliesTable)
    	->where('ndo_doc', $documentNumber)->get();

    	//Document has no supplies
    	if(empty($siavcomDocumentSupplies)) return;

    	foreach($siavcomDocumentSupplies as $pivot) {
    		//Supply
			$siavcom_supply = DB::connection($dbConnection)->table($suppliesTable)
			->where('cla_isu', $pivot->cla_isu)->first();

			if(!isset($siavcom_supply)) continue;

    		//Manufacturer
			$siavcom_manufacturer = DB::connection($dbConnection)->table($manufacturersTable)
			->where('key_xmd', $siavcom_supply->key_pri)->first();

			if(!isset($siavcom_manufacturer)) continue;

			DB::beginTransaction();
			try {				
				//Retrieve manufacturer or create it
				$key_xmd = $siavcom_manufacturer->key_xmd;
				$manufacturer = Manufacturer::find($key_xmd);
				if(!isset($manufacturer))
					$manufacturer = Manufacturer::create([
						'id' => $key_xmd, 
						'document_type' => $siavcom_manufacturer->xml_xmd]);

				//Retrieve supply or create it
				$cla_isu = $siavcom_supply->cla_isu;
				$supply = Supply::where('number', $cla_isu)->first();
				if(!isset($supply))
					$supply = Supply::create([
						'number' => $cla_isu, 
						'manufacturers_id' => $manufacturer->id]);

				$document->supplies()->attach($supply->id, [
					'set' => $pivot->mov_mov,
					'product_description' => $pivot->dse_mov,
					'products_amount' => $pivot->can_mov,
					'measurement_unit_code' => $pivot->med_mov,
					'sale_unit_price' => $pivot->pve_mov
				]);
				DB::commit();
			} catch(\Exception $e) {
				DB::rollback();
				Log::notice($e->getMessage());
			}
    	}
    }

    /*Retrieves the founded customer by code on siavcom database*/
    private function getCustomer($code, $dbConnection)
    {
    	$customersTable = env('SIAVCOM_CUSTOMERS');
    	$siavcom_customer = DB::connection($dbConnection)->table($customersTable)->where('cod_nom', $code)->first();

		//If customer were found on siavcom db, we're not gonna try to find it or create it
    	if(!isset($siavcom_customer)) return null;
		
		//Otherwise, we found it, or create it in our db
		$customer = Customer::where('code', $code)->first();
		if(!isset($customer))
			$customer = Customer::create(
			[
	    		'code' => $siavcom_customer->cod_nom,
	    		'trade_name' => $siavcom_customer->cli_nom,
	    		'business_name' => $siavcom_customer->nom_nom,
	    		'post_code' => $siavcom_customer->cpo_nom,
	    		'state' => $siavcom_customer->edo_edo,
	    		'country' => $siavcom_customer->pai_nom
		    ]);
		return $customer;
    }
}
