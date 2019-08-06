<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class UtilController extends Controller
{
	/*Gets all the states belonging a country*/
    public function getCountryStates(Request $request)
    {
    	$country = DB::table('countries')->where('id', $request->country_id)->first();

    	Log::notice($request->country_id);	

    	$states = [];
    	$enable = false;
    	if($country->name == 'Mexico') {
    		$states = DB::table('states')->pluck('name', 'id');
    		$enable = true;
    	}

    	
    	return response()->json([
    		'enable' => $enable,
    		'states' =>	$states
    	]);
    }
}
