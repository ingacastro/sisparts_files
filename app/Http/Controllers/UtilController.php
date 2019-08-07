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
        $country_name = strtolower($country->name);
    	$states = [];
    	$disabled = true;
    	if($country_name == 'mexico' || $country_name == 'méxico') {
    		$states = DB::table('states')->pluck('name', 'id');
    		$disabled = false;
    	}

    	return response()->json([
    		'disabled' => $disabled,
    		'states' =>	$states
    	]);
    }
}
