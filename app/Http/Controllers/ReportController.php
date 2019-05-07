<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use IParts\User;
use IParts\Customer;
use Yajra\Datatables\Datatables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sync_connections = DB::table('sync_connections')->pluck('display_name', 'id')->prepend('TODAS', 0);
        $dealerships = User::role('Cotizador')->pluck('name', 'id')->prepend('TODOS', 0);
        $customers = Customer::pluck('trade_name', 'id')->prepend('TODOS', 0);
        return view('report.index', compact('sync_connections', 'dealerships', 'customers'));
    }

    public function getList()
    {
        
    }
}
