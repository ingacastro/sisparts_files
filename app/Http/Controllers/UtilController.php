<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UtilController extends Controller
{
	/*Gets all the states belonging a country*/
    public function getCountryStates(Request $request)
    {
    	$states = DB::table('states')->pluck('name', 'id');
    	return response()->json($states);
    }
}
