<?php

namespace IParts\Http\Controllers;

use Illuminate\Support\Facades\Log;
use IParts\Document;
use IParts\Customer;
use DB;

class DocumentSyncController extends Controller
{
	/*Syncs all of the documents(type pct) from mxmro, pavan and zukaely postgres databases*/
    public function siavcomQuotationsSync()
    {
    	$documentsTable = env('SIAVCOM_DOCUMENTS');

/*    	DB::connection('pgsql_pavan')->table($documentsTable)
    	->orderBy('key_pri')
    	->chunk(10, function($documents){
    		foreach($documents as $k => $document) {
    			if($k == 9) return;
    			if($this->createDocument($document, 'pgsql_pavan') == false) continue;
    		}
    	});*/
    	$documents = DB::connection('pgsql_pavan')->table($documentsTable)
    	->take(10)->get();
		foreach($documents as $k => $document) {
			if($this->createDocument($document, 'pgsql_pavan') == false) continue;
		}
    }

    /*Insert all the necessary data in the required tables, to create a document(type pct) */
    private function createDocument(\stdClass $document, $dbConnection)
    {
    	$customerCode = $document->cod_nom;
	    
    	$document_data = [
    		'type' => $document->tdo_tdo,
    		'number' => $document->ndo_doc,
    		'reference' => $document->ref_doc,
    		'customer_code' => $customerCode,
    		'seller_number' => $document->ven_ven,
    		'state' => $document->sta_doc,
    		'currency_id' => $document->mon_doc,
    		'mxn_currency_exchange_rate' => $document->vmo_doc,
    		'customer_requirement_number' => $document->ob1_doc,
    		'buyer_name' => $document->ob2_doc,
    		'buyer_number' => $document->tcd_tcd,
    	];

	    $customer_data = $this->getCustomer($customerCode, $dbConnection);

	    //Customer wasn't found by code
	    if(!isset($customer_data)) return false;

    	DB::beginTransaction();
    	try {    		
	    	//If customer doesn't exist creat it before, the document
    		$customer = Customer::where('code', $customerCode)->first();
    		if(!isset($customer)) $customer = Customer::create($customer_data);

	    	$document_data['customers_id'] = $customer->id;
	    	Document::create($document_data);
    	} catch(\Exception $e) {
    		Log::notice($e->getMessage());
    		DB::rollback();
    		return false;
    	}
    	DB::commit();
    	return true;
    }

    /*Retrieves the customer found by code on siavcom database*/
    private function getCustomer($code, $dbConnection)
    {
    	$customersTable = env('SIAVCOM_CUSTOMERS');
    	//Log::notice($code);
    	$customer = DB::connection($dbConnection)->table($customersTable)->where('cod_nom', $code)->first();

    	return !isset($customer) ? null 
    	: [
    		'code' => $customer->cod_nom,
    		'trade_name' => $customer->cli_nom,
    		'business_name' => $customer->nom_nom,
    		'post_code' => $customer->cpo_nom,
    		'state' => $customer->edo_edo,
    		'country' => $customer->pai_nom
    	];
    }
}
