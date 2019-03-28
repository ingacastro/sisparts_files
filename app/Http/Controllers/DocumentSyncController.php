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

    	DB::connection('pgsql_pavan')->table($documentsTable)
    	->orderBy('key_pri')
    	->chunk(1000, function($documents){
    		foreach($documents as $document) {
    			if($this->createDocument($document, 'pgsql_pavan') == false) continue;
    		}
    	});

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

    	DB::beginTransaction();
    	try {    		
	    	//If customer doesn't exist creat it before, the document
	    	$customer = $this->getCustomer($customerCode, $dbConnection);

	    	$document_data['customers_id'] = $customer->id;
    	} catch(\Exception $e) {
    		DB::rollback();
    		return false;
    	}
    	DB::commit();
    	return true;
    }

    /*Retrieves an existent customer or creates a new one*/
    private function getCustomer($code, $dbConnection)
    {
    	$customersTable = env('SIAVCOM_CUSTOMERS');
    	$test = DB::connection($dbConnection)->table($customersTable)->where('cod_nom', $code)->first();
    	//Log::notice((array)$test);
    	//Customer::create
    }
}
