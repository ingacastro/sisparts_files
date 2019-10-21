<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use IParts\User;
use IParts\Document;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class ArchiveController extends Controller
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
        $logged_user_role = Auth::user()->roles()->first()->name;
        $sync_connections = DB::table('sync_connections')->where('name', '!=', 'mysql_catalogo_virtual')
        ->pluck('display_name', 'id')->prepend('TODAS', 0);
        $dealerships = User::role('Cotizador')->pluck('name', 'id')->prepend('TODOS', 0);        
        return view('archive.index', compact('logged_user_role', 'dealerships', 'sync_connections', 'dealerships'));
    }

    //Inbox list
    public function getList(Request $request)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $sync_connection = $request->get('sync_connection') ?? 0;
        $dealer_ship = $request->get('dealer_ship') ?? 0;

        $fields = ['documents.id', 'documents.is_canceled', 'documents.created_at', 
                     'sync_connections.display_name as sync_connection',
                     'users.name as buyer', 'documents.number', 'customers.trade_name as customer',
                      DB::raw('(CASE documents.status 
                              WHEN 3 THEN "Terminada"
                              WHEN 4 THEN "Archivada"
                              ELSE "Indefinido" END) as status'), 'documents.reference', 'documents.siavcom_ctz'];

        $query = DB::table('documents')
                     ->join('employees', 'employees.users_id', 'documents.employees_users_id')
                     ->join('users', 'users.id', 'employees.users_id')
                     ->join('customers', 'customers.id', 'documents.customers_id')
                     ->join('sync_connections', 'documents.sync_connections_id', 'sync_connections.id');

        if($sync_connection > 0)
            $query->where('documents.sync_connections_id', $sync_connection);
        if($dealer_ship > 0)
            $query->where('documents.employees_users_id', $dealer_ship);

        $query->where('documents.status', '>', 2); //Finished and archived status

        $logged_user = Auth::user();
        //Dealership won't see customer
        if($logged_user->hasRole("Cotizador")) {
            $query->where('documents.employees_users_id', $logged_user->id);
            unset($fields[6]); //customer removed 
        }
        $query->select($fields);
        return $this->buildInboxDataTable($query, $logged_user);
    }

   private function buildInboxDataTable($query)
   {
        return Datatables::of($query)
          ->editColumn('created_at', function($document) {
            return date_format(new \DateTime($document->created_at), 'd/m/Y');
          })
          ->addColumn('actions', function($document) { 
            
            $actions = '<a href="' . config('app.url') . '/archive/' . $document->id . '" class="btn btn-circle btn-icon-only green"><i class="fa fa-eye"></i></a>';
            
            return $actions;
          })
          ->rawColumns(['actions' => 'actions'])
          ->make(true);
    }  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::find($id);
        $document_supplies = $document->supplies->pluck('number', 'pivot.id');
        $messages = DB::table('messages')
        ->leftJoin('messages_languages', 'messages.id', 'messages_languages.messages_id')
        ->leftJoin('languages', 'messages_languages.languages_id', 'languages.id')
        ->where('languages.name', 'Español')
        ->pluck('messages_languages.title', 'messages.id');

        return view('archive.show', compact('document', 'document_supplies', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
