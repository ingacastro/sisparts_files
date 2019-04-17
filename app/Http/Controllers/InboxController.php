<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use IParts\Document;
use IParts\ColorSetting;
use IParts\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Validator;
use DB;
use Auth;

class InboxController extends Controller
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
        $sync_connections = DB::table('sync_connections')->pluck('display_name', 'id')->prepend('TODAS', 0);
        $dealerships = User::role('Cotizador')->pluck('name', 'id')->prepend('TODOS', 0);
        return view('inbox.index', compact('logged_user_role', 'dealerships', 'sync_connections', 'dealerships'));
    }

    //Inbox list
    public function getList(Request $request)
    {
        if($request->ajax()) {

            $sync_connection = $request->get('sync_connection') ?? 0;
            $status = $request->get('status') ?? 0;
            $dealer_ship = $request->get('dealer_ship') ?? 0;

            $first_color_setting = DB::table('color_settings')->orderBy('days', 'asc')->first();

            $fields = ['documents.id', 'documents.created_at', 'sync_connections.display_name as sync_connection',
            'users.name as buyer', 'documents.number', 'customers.trade_name as customer', 
             DB::raw('DATEDIFF(NOW(), documents.created_at) as semaphore_days'), 
             DB::raw('(CASE WHEN documents.status = 1 THEN "Nueva"
                      WHEN documents.status = 2 THEN "En proceso"
                      WHEN documents.status = 3 THEN "Terminada"
                      WHEN documents.status = 4 THEN "Archivada"
                      ELSE "Indefinido" END) as status'),
            DB::raw('(CASE WHEN (SELECT color
                     FROM color_settings WHERE semaphore_days >= days ORDER BY days DESC limit 1)
                     IS NULL THEN "' . $first_color_setting->color . '" ELSE (SELECT color
                     FROM color_settings WHERE semaphore_days >= days ORDER BY days DESC limit 1) END) as semaphore_color')];
            $query = DB::table('documents')
                         ->join('employees', 'employees.users_id', 'documents.employees_users_id')
                         ->join('users', 'users.id', 'employees.users_id')
                         ->join('customers', 'customers.id', 'documents.customers_id')
                         ->join('sync_connections', 'documents.sync_connections_id', 'sync_connections.id');

            $logged_user = Auth::user();
            //Dealership won't see customer
            if($logged_user->roles()->first()->name == "Cotizador") {
                $query->where('employees_users_id', $logged_user->id);
                unset($fields[5]);
            }

            if($sync_connection > 0)
                $query->where('documents.sync_connections_id', $sync_connection);
            if($status > 0)
                $query->where('documents.status', $status);
            if($dealer_ship > 0)
                $query->where('documents.employees_users_id', $dealer_ship);

             $documents = $query->get($fields);
             return $this->buildInboxDataTable($documents);
        }
        abort(403, 'Unauthorized action');
    }

    private function buildInboxDataTable($documents)
    {
        //$colorSettings = ColorSetting::all();
        return Datatables::of($documents)
              ->editColumn('semaphore', function($document) {
                return '<div class="form-control" style="background-color: ' . $document->semaphore_color . '; width: 100%; height: 25px;
                            line-height: 100%; vertical-align: middle; text-align: center; color: #fff">' . 
                            $document->semaphore_days . ' días </div>';
              })
              ->editColumn('created_at', function($document) {
                return date_format(new \DateTime($document->created_at), 'd/m/Y');
              })
              ->addColumn('actions', function($document) {
                return '<a href="/inbox/' . $document->id . '" class="btn btn-circle btn-icon-only green"><i class="fa fa-eye"></i></a><a data-target="#brands_modal" data-toggle="modal" href="#brands_modal" class="btn btn-circle btn-icon-only default change-dealership" data-buyer="' . $document->buyer.'" data-document_id="' . $document->id . '"><i class="fa fa-user"></i></a><a class="btn btn-circle btn-icon-only default blue" onClick="archiveDocument(event, ' . $document->id . ')"><i class="fa fa-archive"></i></a>';
              })
              ->rawColumns(['semaphore' => 'semaphore', 'actions' => 'actions'])
              ->make(true);
    }   
    public function changeDealerShip(Request $request)
    {
        $data = $request->all();
        $validator = $this->dealerShipValidations($data);

        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);
        try {
            Document::find($data['document_id'])->fill(['employees_users_id' => $data['employees_users_id']])->update();
            $request->session()->flash('message', 'Cotizador asignado correctamente.');
            return response()->json(['errors' => false]);
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
    }

    private function dealerShipValidations($message_data)
    {
        $messages = [
            'employees_users_id.required' => 'El campo nuevo cotizador es requerido.'
        ];
        
        $validator = Validator::make($message_data, [
            'employees_users_id' => 'required'
        ], $messages);

        return $validator;
    }

    public function archive($document_id)
    {
        try {
            Document::find($document_id)->fill(['status' => 4])->update();
            Session::flash('message', 'Elemento archivado correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
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
        $pct = Document::find($id);
        return view('inbox.show', compact('pct'));
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
