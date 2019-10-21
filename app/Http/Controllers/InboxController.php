<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use IParts\Document;
use IParts\ColorSetting;
use IParts\User;
use IParts\Manufacturer;
use IParts\Supplier;
use IParts\Currency;
use IParts\File;
use IParts\Message;
use IParts\Binnacle;
use IParts\SupplySet;
use IParts\Rejection;
use IParts\Customer;
use IParts\Employee;
use IParts\QuotationRequest;
use IParts\UtilityPercentage;
use IParts\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Validator;
use DB;
use Auth;
use Storage;
use Mail;
use File as LaravelFile;
use Carbon\Carbon;
use IParts\Http\Helper;
use Cmixin\BusinessDay;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        BusinessDay::enable('Carbon\Carbon');
        $this->siavcomDocumentsTable = config('siavcom_sync.siavcom_documents');
        $this->siavcomDocumentsSuppliesTable = config('siavcom_sync.siavcom_documents_supplies');
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

        return view('inbox.index', compact('logged_user_role', 'dealerships', 'sync_connections', 'dealerships'));
    }

    //Inbox list
    public function getList(Request $request)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $sync_connection = $request->get('sync_connection') ?? 0;
        $status = $request->get('status') ?? 0;
        $dealer_ship = $request->get('dealer_ship') ?? 0;

        $fields = ['documents.id', 'documents.is_canceled', 'documents.created_at', 
                     'sync_connections.display_name as sync_connection',
                     'users.name as buyer', 'documents.number', 'customers.trade_name as customer',
                      DB::raw('(CASE documents.status WHEN 1 THEN "Nueva"
                              WHEN 2 THEN "En proceso"
                              WHEN 3 THEN "Terminada"
                              WHEN 4 THEN "Archivada"
                              ELSE "Indefinido" END) as status'), 'documents.reference', 'documents.siavcom_ctz'];

        $query = DB::table('documents')
                     ->join('employees', 'employees.users_id', 'documents.employees_users_id')
                     ->join('users', 'users.id', 'employees.users_id')
                     ->join('customers', 'customers.id', 'documents.customers_id')
                     ->join('sync_connections', 'documents.sync_connections_id', 'sync_connections.id');

        $base_query_clone = clone $query;

        if($sync_connection > 0)
            $query->where('documents.sync_connections_id', $sync_connection);
        if($dealer_ship > 0)
            $query->where('documents.employees_users_id', $dealer_ship);
        
        if($status > 0)
            $query->where('documents.status', $status);
        else
            $query->where('documents.status', '<', 3); //No finished or archived PCTs only


        $logged_user = Auth::user();
        //Dealership won't see customer
        if($logged_user->hasRole("Cotizador")) {
            $fiveBusinessDaysAgoDate = Carbon::subBusinessDays(5)->format('Y-m-d');
            $query->where('documents.employees_users_id', $logged_user->id);
            
            $query->orWhereBetween('documents.created_at', ['1000-01-01', $fiveBusinessDaysAgoDate]);

            if($status > 0)
                $query->where('documents.status', $status);
            else
                $query->where('documents.status', '<', 3); //No finished or archived PCTs only

            unset($fields[6]); //customer removed 
        }

        $first_query_ids = $query->select(['documents.id'])->pluck('id');
        $base_query_clone->whereIn('documents.id', $first_query_ids);
        $base_query_clone->select($fields);

        return $this->buildInboxDataTable($base_query_clone, $logged_user);
    }

    private function buildInboxDataTable($query, $logged_user)
    {
        return Datatables::of($query)
              ->addColumn('semaphore', function($document) {
                $days = $this->diffBusinessDays($document->created_at);
                $color = DB::table('color_settings')->where('days', '<=', $days)
                ->orderBy('days', 'DESC')->first();

                if(!$color)
                    $color = DB::table('color_settings')->orderBy('days', 'asc')->first();

                return '<div class="form-control" style="background-color: ' . $color->color . '; width: 70%; height: 25px;
                            line-height: 100%; text-align: center; color: #fff; margin: auto">' . 
                            $days . ' días </div>';
              })
              ->editColumn('created_at', function($document) {
                return date_format(new \DateTime($document->created_at), 'd/m/Y');
              })
              ->addColumn('actions', function($document) use ($logged_user) { 

                $is_admin = $logged_user->hasRole('Administrador');
                $actions = '<a href="' . config('app.url') . '/inbox/' . $document->id . '" class="btn btn-circle btn-icon-only green"><i class="fa fa-eye"></i></a>';

                //Admin actions
                $actions .= $is_admin ? '<a data-target="#brands_modal" data-toggle="modal" href="#brands_modal" class="btn btn-circle btn-icon-only default change-dealership" data-buyer="' . $document->buyer.'" data-document_id="' . $document->id . '"><i class="fa fa-user"></i></a>' : '';
                $actions .= $is_admin ? '<a class="btn btn-circle btn-icon-only default blue" onClick="archiveOrLockDocument(event, ' . $document->id . ', 1)"><i class="fa fa-archive"></i></a>' : '';
                $actions .= $is_admin ? '<a class="btn btn-circle btn-icon-only default red" onClick="archiveOrLockDocument(event, ' . $document->id . ', 2)"><i class="fa fa-lock"></i></a>' : '';
                
                return $actions;
              })
              ->rawColumns(['semaphore' => 'semaphore', 'actions' => 'actions'])
              ->make(true);
    }   
    
    private function diffBusinessDays($start_date)
    {
        $start_date = new Carbon($start_date);
        $end_date = Carbon::parse(DB::select('select now() as current')[0]->current);

        $days = 0;
        $days += $start_date->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday() ? 1 : 0;
        }, $end_date);
        return $days;
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

    /* Archive or lock(mark as cancelled) a document */
    public function archiveOrLock($document_id, $action)
    {
        $action_name = $action == 1 ? 'archivado' : 'cancelado';
        $updates = ['status' => 4];

        try {
            DB::transaction(function() use ($document_id, $action, $updates) {
                $document = Document::find($document_id);

                if($action == 2) {
                    $updates['was_canceled'] = 1;
                    $updates['is_canceled'] = 1;
                }

                $document->fill($updates);
                $document->update();
            });
            Session::flash('message', 'Documento ' . $action_name . ' correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
    }

    /* Remove cancel mark from document/PCT */
    public function unlock($document_id)
    {
        try {
            $document = Document::find($document_id);
       
            $sets_count = $document->supply_sets->count();
            $ctz_sets_count = $document->supply_sets->where('status', 9)->count();

            $status = 0;

            if($ctz_sets_count == 0) //New
                $status = 1; 
            else if($ctz_sets_count != $sets_count) //In process
                $status = 2; 
            else //Done
                $status = 3; 

            $document->fill([
                'status' => $status,
                'is_canceled' => 0,
            ])->update();
            Session::flash('message', 'Documento reactivado correctamente.');
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
        $document = Document::find($id);

        $document_supplies = $document->supplies->pluck('number', 'id');

        $messages = DB::table('messages')
        ->leftJoin('messages_languages', 'messages.id', 'messages_languages.messages_id')
        ->leftJoin('languages', 'messages_languages.languages_id', 'languages.id')
        ->where('languages.name', 'Español')
        ->pluck('messages_languages.title', 'messages.id');

        $rejection_reasons = DB::table('rejection_reasons')->pluck('title', 'id');

        //Canceled document shows archive's show view (no edit), otherwise It shows inbox's show view (edit)
        $view = $document->is_canceled == 1 ? 'archive' : 'inbox';

        return view($view . '.show', compact('document', 'document_supplies', 'messages', 
            'rejection_reasons'));
    }

    public function getSetTabs(Request $request, $set_id)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $set_pri_key = explode('_', $set_id);
        $doc_id = $set_pri_key[0];
        $set = SupplySet::where('documents_id', $doc_id)->where('supplies_id', $set_pri_key[1])->first();
        
        $suppliers = Supplier::pluck('trade_name', 'id');
        $currencies = Currency::pluck('name', 'id');
        $measurement = DB::table('measurements')->find($set->id);
        $countries = DB::table('countries')->pluck('name', 'id');
        $utility_percentages = DB::table('utility_percentages')->get()->toArray();
        $utility_percentages[] = (object)['id' => 0, 'name' => 'Otro', 'percentage' => 'null'];
        $checklist = DB::table('checklist')->find($set->id);
        $set_conditions = DB::table('documents_supplies_conditions')->find($set->id);
        $conditions = DB::table('conditions')->first();

        return response()->json(
            ['errors' => false,
            'budget_tab' => \View::make('inbox.set_edition_modal_tabs.budget', compact('set', 'suppliers', 'currencies', 
                'measurement', 'countries', 'utility_percentages', 'checklist', 'doc_id'))
            ->render(),
            'conditions_tab' => \View::make('inbox.set_edition_modal_tabs.conditions', compact('set', 'set_conditions', 
                'conditions', 'checklist', 'doc_id'))
            ->render(),
            'files_tab' => \View::make('inbox.set_edition_modal_tabs.files', compact('set', 'checklist', 'doc_id'))
            ->render()]);
    }

    //Now files are attached directly to supplies
    public function getSetFiles(Request $request, $set_supplies_id)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $files = DB::table('files')
        ->select('files.*', 'supplies_files.supplies_id', 'supplies_files.files_id')
        ->join('supplies_files', 'supplies_files.files_id', 'files.id')
        ->join('supplies', 'supplies.id', 'supplies_files.supplies_id')
        ->where('supplies.id', $set_supplies_id);

        return Datatables::of($files)
              ->editColumn('created_at', function($file) {
                return date('d/m/Y', strtotime($file->created_at));
              })
              ->addColumn('actions', function($file) {
                $actions = isset($file->url) ? '<a href="' . $file->url . '" target="_blank" class="btn btn-circle btn-icon-only green"><i class="fa fa-link"></i></a>' : '';
                $actions .= isset($file->path) ? '<a href="' . config('app.url') . '/' . $file->path . '" class="btn btn-circle btn-icon-only default change-dealership" download><i class="fa fa-download"></i></a>' : '';
                 $actions .= Auth::user()->hasRole('Administrador') ? '<a class="btn btn-circle btn-icon-only default blue" onClick="detachFile(event,' . $file->supplies_id .',' . $file->files_id .',2' . ')"><i class="fa fa-trash"></i></a>' : '';
                return $actions;
              })
              ->rawColumns(['actions' => 'actions'])
              ->make(true);
    }

    public function setsFileAttachment(Request $request)
    {
/*        if(!$request->ajax())
            return response()->json([
                'errorrs' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()
            ]);*/

        if((!$request->has('file') || empty($request->has('file'))) && empty($request->url))
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Se debe especificar un archivo o una url.')->render()]);

        $data = $request->all();

        $validator = $this->fileAttachmentValidations($data);
        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

        $file = null;
        $file_name = null;
        try {
            DB::transaction(function() use($request, $data, &$file, &$file_name) {   
                if($request->has('file') && !empty($request->file)) {                   
                    $file_name = $request->file->store(null, 'supplies_files');
                    $data['path'] = 'storage/supplies_files/' . $file_name;
                }
                
                $file = File::create($data);
                $file->supplies()->attach($data['supplies']);
            });
            
        } catch(\Exception $e) {
            Storage::disk('supplies_files')->delete($file_name);
            return response()->json([
                'errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render() 
            ]);
        }

      return response()->json([
        'errors' => false, 
        'file' => $file,
        'related_parts' => implode(',', $file->supplies->pluck('number')->toArray()),
        'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
        ->with('success_message', 'Archivo guardado correctamente.')->render()
      ]);
    }

    private function fileAttachmentValidations($data)
    {
        $messages = [
            'supplier.required' => 'El campo proveedor es requerido.',
            'url.url' => 'La url debe seguir el formato http(s)://dominio.com',
            'type.required' => 'El campo tipo es requerido.',
            'supplies.required' => 'El campo partes es requerido.'
        ];
        
        $validator = Validator::make($data, [
            'supplier' => 'required',
            'url' => 'nullable|url',
            'type' => 'required',
            'supplies' => 'required'
        ], $messages);

        return $validator;
    }

    public function getDocumentSetsFiles(Request $request, $document_id)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $files = DB::table('files')->select('files.*',
        'supplies_files.supplies_id', 'supplies_files.files_id',
        DB::raw('GROUP_CONCAT(supplies.number) as related_parts'))
        ->leftJoin('supplies_files', 'supplies_files.files_id', 'files.id')
        ->leftJoin('supplies', 'supplies.id', 'supplies_files.supplies_id')
        ->join('documents_supplies', 'documents_supplies.supplies_id', 'supplies.id')
        ->where('documents_supplies.documents_id', $document_id)
        ->groupBy('supplies_files.files_id')
        ->get();
        
        return Datatables::of($files)
              ->editColumn('created_at', function($file) {
                return date('d/m/Y', strtotime($file->created_at));
              })
              ->addColumn('actions', function($file) {
                $actions = $file->url != null ? '<a href="' . $file->url . '" target="_blank" class="btn btn-circle btn-icon-only green"><i class="fa fa-link"></i></a>' : '';

                $actions .= $file->path != null ? '<a href="' . config('app.url') . '/' . $file->path .'" class="btn btn-circle btn-icon-only default change-dealership" download><i class="fa fa-download"></i></a>' : '';

                $actions .= Auth::user()->hasRole('Administrador') ? '<a class="btn btn-circle btn-icon-only default blue" onClick="detachFile(event,' . $file->supplies_id .',' . $file->files_id .',1' . ')"><i class="fa fa-trash"></i></a>' : '';
                return $actions;
              })
              ->rawColumns(['actions' => 'actions'])
              ->make(true);
    }

    public function supplyFileDetach($supply_id, $file_id)
    {
        try {
            $file = File::find($file_id);
            $file->supplies()->detach($supply_id);
            //$file_path = $file->path;
            //$file->delete();
            //LaravelFile::delete($file->path);
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
      return response()->json(['errors' => false,
        'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
        ->with('success_message', 'Archivo removido correctamente.')->render()
      ]);
    }

    /*Document supplies sets and only authorized sets*/
    public function getDocumentSupplySets(Request $request)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');        

        $query = Document::select('documents_supplies.id', 'documents_supplies.set', 'supplies.manufacturers_id', 
        'supplies.number', 'suppliers.trade_name as supplier', 
        DB::raw('CAST(documents_supplies.products_amount as UNSIGNED) as products_amount'),
        'supplies.measurement_unit', 
        DB::raw('documents_supplies.sale_unit_cost * documents_supplies.products_amount + documents_supplies.importation_cost
        + documents_supplies.warehouse_shipment_cost + documents_supplies.customer_shipment_cost + documents_supplies.extra_charges as total_cost'),'currencies.name as currency', 'documents_supplies.unit_price',
        DB::raw('CASE WHEN documents_supplies.status = 1 THEN "No solicitado"
            WHEN documents_supplies.status = 2 THEN "Solicitado automáticamente"
            WHEN documents_supplies.status = 3 THEN "Solicitado manualmente"
            WHEN documents_supplies.status = 4 THEN "Confirmado por el proveedor"
            WHEN documents_supplies.status = 5 THEN "Presupuesto capturado"
            WHEN documents_supplies.status = 6 THEN "En autorización"
            WHEN documents_supplies.status = 7 THEN "Rechazado"
            WHEN documents_supplies.status = 8 THEN "Autorizado"
            WHEN documents_supplies.status = 9 THEN "Convertido a CTZ"
            ELSE "INDEFINIDO" END as status'), 
        'documents_supplies.documents_id', 'documents_supplies.supplies_id',
        DB::raw('CASE WHEN documents_supplies.utility_percentages_id IS NOT null THEN utility_percentages.percentage
            ELSE documents_supplies.custom_utility_percentage END AS utility_percentage'), 'manufacturers.name as manufacturer')
        ->leftJoin('documents_supplies', 'documents.id', 'documents_supplies.documents_id')
        ->leftJoin('supplies', 'documents_supplies.supplies_id', 'supplies.id')
        ->leftJoin('manufacturers', 'manufacturers.id', 'supplies.manufacturers_id')
        ->leftjoin('suppliers', 'suppliers.id', 'documents_supplies.suppliers_id')
        ->leftJoin('currencies', 'currencies.id', 'documents_supplies.currencies_id')
        ->leftJoin('utility_percentages', 'utility_percentages.id', 'documents_supplies.utility_percentages_id')
        ->where('documents_supplies.documents_id', $request->document_id);

        if($request->has('status'))
            $query->where('documents_supplies.status', $request->status);

        return Datatables::of($query)
              ->editColumn('number', function($document) {
                return '<a href="' . url('supply') . '?number=' . $document->number . '">' . $document->number . '</a>';
              })
              ->addColumn('actions', function($supplies_set) use ($request) {

                $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                $unit_price = $total_price / $supplies_set->products_amount;
                $total_profit = $total_price - $supplies_set->total_cost;
                $currency = ' ' . $supplies_set->currency;

                $edit_action = '<a data-target="#edit_set_modal" data-toggle="modal" class="btn btn-circle btn-icon-only default edit-set" 
                data-id="' . $supplies_set->documents_id . '_' . $supplies_set->supplies_id . '"
                data-total_cost="' . '$' . number_format($supplies_set->total_cost, 2, '.', ',') . $currency . '" 
                data-total_price="' . '$' . number_format($total_price, 2, '.', ',') . $currency . '"
                data-unit_price="' . '$' . number_format($unit_price, 2, '.', ',') . $currency . '"
                data-total_profit="' . '$' . number_format($total_profit, 2, '.', ',') . $currency . '"
                data-set_number=" ' . $supplies_set->set . '"
                data-supply_number=" ' . $supplies_set->number . '"><i class="fa fa-edit"></i></a>';

                return ($request->route == 'inbox') 
                ? $edit_action .
                '<a data-target="#quotation_request_modal" data-toggle="modal" class="btn btn-circle 
                yellow-crusta btn-icon-only default quotation-request"
                data-manufacturer="' . $supplies_set->manufacturer . '"
                data-manufacturer_id="' . $supplies_set->manufacturers_id . '"
                data-id="' . $supplies_set->id . '"
                data-documents_id="' . $supplies_set->documents_id . '"><i class="fa fa-envelope"></i></a>
                <a class="btn btn-circle btn-icon-only default blue set-file-attachment" href="#set_file_attachment_modal" data-target="#set_file_attachment_modal" data-toggle="modal"
                data-supply_id="' . $supplies_set->supplies_id . '"><i class="fa fa-paperclip"></i></a>'
                : $edit_action;
              })
              ->addColumn('checkbox', function($supplies_set){
                return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" class="checkboxes" value="' . $supplies_set->id . '"><span></span></label>';
              })
              ->editColumn('total_cost', function($supplies_set) {
                return '$' . number_format($supplies_set->total_cost, 2, '.', ',') . ' ' . $supplies_set->currency;
              })
              ->addColumn('total_price', function($supplies_set) {
                $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                return '$' .  number_format($total_price, 2, '.', ',') . ' ' . $supplies_set->currency;
              })
              ->editColumn('unit_price', function($supplies_set) {
                $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                $unit_price = $total_price / $supplies_set->products_amount;
                $total_price .= ' ' . $supplies_set->currency;
                return '$' .  number_format($unit_price, 2, '.', ',') . ' ' . $supplies_set->currency;
              })
              ->rawColumns(['number' => 'number', 'actions' => 'actions', 'total_cost' => 'total_cost', 
                'total_price' => 'total_price', 'checkbox' => 'checkbox'])
              ->make(true);
    }

    public function getDocumentBinnacle(Request $request, $documents_id)
    {
        if($request->ajax()):

            $binnacles = Binnacle::select('binnacles.created_at', 
                DB::raw('(CASE binnacles.entity WHEN 1 THEN "PCT" ELSE supplies.number END) as entity'),
                DB::raw('(CASE WHEN binnacles.type = 1 THEN "Llamada" ELSE "" END) as type'), 
                'users.name as user', 'binnacles.comments')
                ->leftJoin('users', 'binnacles.users_id', 'users.id')
                ->leftJoin('documents_supplies', 'documents_supplies.id', 'binnacles.documents_supplies_id')
                ->join('supplies', 'documents_supplies.supplies_id', 'supplies.id')
                ->where('binnacles.documents_id', $documents_id)->get();
               
            return Datatables::of($binnacles)
                  ->editColumn('created_at', function($binnacle){
                    return date('d/m/Y h:i', strtotime($binnacle->created_at));
                  })
                  ->make(true);

        endif;
        abort(403, 'Unauthorized action');
    }

    private function calculateTotalPrice($total_cost, $utility_percentage)
    {
        return $total_cost / ((100 - $utility_percentage) / 100);
    }

    public function getManufacturerSuppliersAndSupplies($document_id, $manufacturer_id)
    {
        $manufacturer = Manufacturer::find($manufacturer_id);
        $supplies_sets = Document::find($document_id)->supply_sets;
        $document = Document::find($document_id);
        $supplies = $document->supplies;

        return response()->json([
            'suppliers' => $manufacturer->suppliers,
            'supplies' => $supplies,
            'sets' => $supplies_sets,
            'manufacturer_name' => $manufacturer->name,
            'document_status' => $document->status
        ]);
    }

    public function updateBudget(Request $request, $set_id)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        $data = $request->all();
        $utility_percent_arr = explode('_', $data['utility_percentage']);
        $data['utility_percentage'] = $utility_percent_arr[1];
        $validator = $this->budgetValidations($data);
        
        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

        $set_id = explode('_', $set_id);

        $utility_percentage_amount = null;
        if($utility_percent_arr[0] == 0) {
            $utility_percentage_amount = $data['set']['custom_utility_percentage'] = $utility_percent_arr[1];
            $data['set']['utility_percentages_id'] = null;
        }else {
            $data['set']['utility_percentages_id'] = $utility_percent_arr[0];
            $data['set']['custom_utility_percentage'] = null;
            $utility_percentage_amount = UtilityPercentage::find($utility_percent_arr[0])->percentage;
        }

        DB::beginTransaction();
        try {

            $document_supply = SupplySet::where('documents_id', $set_id[0])
            ->where('supplies_id', $set_id[1])
            ->first();

            $budget_data = $this->calculateBudget($document_supply, $data['set'], $utility_percentage_amount);

            $data['set']['unit_price'] = preg_replace('/[^0-9.]/', '', $budget_data['unit_price']);
            $data['set']['status'] = 5; //Budget resgistered
            
            $document_supply->update($data['set']);
            $document_supply->document->fill(['status' => 2])->update();

            $data['measurement']['weight'] = $this->getVolumetricWeight($request, 1, false);
            DB::table('measurements')->where('id', $document_supply->id)->update($data['measurement']);
            $alert = Alert::where('type', 2)->where('set_status', 5)->first();
            
            if(!$alert) {
                DB::commit();
                return response()->json([
                    'errors' => false,
                    'budget_data' => $budget_data,
                    'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
                    ->with('success_message', 'Presupuesto correctamente actualizado. No se ha enviado notificación por que no existe la alerta.')->render()
                ]);
            }

            $document = $document_supply->document;
            $subject = $alert->subject . ' PCT'  . $document->number . ' ' . $document->reference;
            Helper::sendMail($alert->recipients, $subject, $alert->message, 'admin@admin.com', null);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
        
        return response()->json([
            'errors' => false,
            'budget_data' => $budget_data,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Presupuesto correctamente actualizado.')->render()
        ]);
    }

    private function calculateBudget($set, $set_data, $utility_percentage)
    {
        $currency = ' ' . $set->currency->name;
/*        $total_cost = ($set_data['sale_unit_cost'] * $set->products_amount) + 
                ($set_data['importation_cost'] + $set_data['warehouse_shipment_cost'] + 
                $set_data['customer_shipment_cost'] + $set_data['extra_charges']);*/
        $total_cost = $this->calculateTotalCost($set_data['sale_unit_cost'], $set->products_amount, $set_data['importation_cost'],
        $set_data['warehouse_shipment_cost'], $set_data['customer_shipment_cost'], $set_data['extra_charges']);

        $total_price = $this->calculateTotalPrice($total_cost, $utility_percentage);
        return [
            'total_cost' => number_format($total_cost, 2, '.', ',') . $currency,
            'total_price' => number_format($total_price, 2, '.', ',') . $currency,
            'unit_price' => number_format(($total_price / $set->products_amount), 2, '.', ',') . $currency,
            'total_profit' => number_format(($total_price - $total_cost), 2, '.', ',') . $currency
        ];
    }

    private function calculateTotalCost($sale_unit_cost, $products_amount, $importation_cost, 
        $warehouse_shipment_cost, $customer_shipment_cost, $extra_charges) {
        return ($sale_unit_cost * $products_amount) + 
                ($importation_cost + $warehouse_shipment_cost + 
                $customer_shipment_cost + $extra_charges);
    }

    private function budgetValidations($data)
    {
        $volumetricValidations = $this->volumetricWeightValidations(1, null);
        $messages = [
            'set.sale_unit_cost.required' => 'El campo costo unitario es requerido.',
            'set.importation_cost.required' => 'El campo importación es requerido.',
            'set.warehouse_shipment_cost.required' => 'El campo envío al almacen es requerido.',
            'set.customer_shipment_cost.required' => 'El campo envío al cliente es requerido.',
            'set.extra_charges.required' => 'El campo gastos extra es requerido.',
            'set.suppliers_id.required' => 'El campo proveedor es requerido.',
            'set.currencies_id.required' => 'El campo moneda es requerido.',
            /*'measurement.weight.required' => 'El campo peso es requerido.',*/
            'set.source_country_id.required' => 'El campo país de origen es requerido.',
            'utility_percentage.required' => 'El porcentaje de utilidad es requerido.',
            'utility_percentage.min' => 'El porcentaje de utilidad mínimo, es 1.',
            'utility_percentage.max' => 'El porcentaje de utilidad máximo, es 100.'
        ];
        
        $rules = [
            'set.suppliers_id' => 'required',
            'set.currencies_id' => 'required',
            'set.sale_unit_cost' => 'required',
            'set.importation_cost' => 'required',
            'set.warehouse_shipment_cost' => 'required',
            'set.customer_shipment_cost' => 'required',
            'set.extra_charges' => 'required',
            /*'measurement.weight' => 'required',*/
            'set.source_country_id' => 'required',
            'utility_percentage' => 'required|numeric|min:1|max:100'
        ];
        $rules = array_merge($rules, $volumetricValidations['rules']);
        $messages = array_merge($messages, $volumetricValidations['messages']);

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    /*Returns type = 1 returns array, type 2 returns validator obj*/
    private function volumetricWeightValidations($type, $data)
    {
            $validations['messages'] = [
                'measurement.length.required' => 'El campo largo es requerido.',
                'measurement.width.required' => 'El campo ancho es requerido.',
                'measurement.height.required' => 'El campo alto es requerido.',
            ];
            $validations['rules'] = [
                'measurement.length' => 'required',
                'measurement.width' => 'required',
                'measurement.height' => 'required',
            ];
            
            if($type == 1) return $validations;
            else
                return Validator::make($data, $validations['rules'], $validations['messages']);
    }

    /* returns volumetric weight, type 1 only value, type 2 json response*/
    public function getVolumetricWeight(Request $request, $type, $validate = true)
    {
/*        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);*/
                
        //Centimetres in an inch
        $cm_in = 2.54;
        
        $data = $request->all();

        if($validate) {
            $validator = $this->volumetricWeightValidations($type, $data);
            if($validator->fails())
                return response()->json(
                    ['errors' => true,
                    'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                    ->withErrors($validator)->render()]);
        }

        $measurement_data = $data['measurement'];
        
        //getting length, width and height always in cm
        $unit = $measurement_data['unit'];
        $length = str_replace(',', '', ($unit == 1) ? $measurement_data['length'] : ($measurement_data['length'] * $cm_in));
        $width = str_replace(',', '', ($unit == 1) ? $measurement_data['width'] : ($measurement_data['width'] * $cm_in));
        $height = str_replace(',', '', ($unit == 1) ? $measurement_data['height'] : ($measurement_data['height'] * $cm_in));

        //Applying volumetric weight formula
        $volumetric_weight = ($length * $width * $height) / 5000;
        if($type == 1) return $volumetric_weight;

        return response()->json(['errors' => false, 'volumetric_weight' => $volumetric_weight]);
    }

    public function checkChecklistItem(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        try {
            //og::notice($request->checklist_id);
            DB::table('checklist')->where('id', $request->checklist_id)
            ->update([$request->field => $request->status]);
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
        
        return response()->json(['errors' => false]);
    }

    public function updateConditions(Request $request, $set_id)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);
        try {
            DB::table('documents_supplies_conditions')->where('id', $set_id)->update($request->except('_token'));            
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
        
        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Condiciones correctamente actualizadas.')->render()
        ]);
    }

    public function getConditionValue($id, $field)
    {
        return $item = ((array)DB::table('conditions')->find($id))[$field];
    }

    public function sendSuppliersQuotation(Request $request)
    {  
        $data = $request->all();

        $data['emails'] = [];

        if(isset($data['suppliers_ids']))
            $data['emails'] = $data['suppliers_ids'];
        if(isset($data['custom_emails']))
            $data['emails'] = array_merge($data['emails'], $data['custom_emails']);

        $validator = $this->sendSuppliersQuotationValidations($data);

        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

            DB::beginTransaction();
        try {
            $set = SupplySet::find($data['documents_supplies_id']);
            $document = $set->document;
            $number = $document->number;
            $reference = $document->reference;

            $result['emailed_sets_ids'] = [];
            foreach($data['emails'] as $email) {
                $result = $this->sendSupplierQuotationEmail($email, $data, $number, $reference, $document->dealership, $set);
                $this->registerQuotationEmailBinnacle($result['supplier_email'], $data['sets']);
            }

            //Update all of the sets selected
            SupplySet::whereIn('id', $result['emailed_sets_ids'])->update(['status' => 3, 'quotation_request_date' => date('Y-m-d H:i:s')]);

             //QuotationsRequests inserts
            foreach($result['emailed_sets_ids'] as $set_id) {
                $quotation_request = QuotationRequest::create(['documents_supplies_id' => $set_id]);
                if(isset($data['suppliers_ids'])) $quotation_request->suppliers()->attach($data['suppliers_ids']);
            }

            //Document/PCT in process
            if($document->status < 2) {
                $doc = Document::find($set->documents_id);
                $doc->fill(['status' => 2])->update();
            }

            DB::commit();
            $alert = Alert::where('type', 2)->where('set_status', 3)->first();
            
            if(!$alert) {
                $request->session()->flash('message', 'Solicitud de cotización correctamente enviada. No se ha enviado notificación por que no existe la alerta.');
                return response()->json(['errors' => false]);
            }

            $subject = $alert->subject . ' PCT'  . $number . ' ' . $reference;
            Helper::sendMail($alert->recipients, $subject, $alert->message, 'admin@admin.com', null);

        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }

        $request->session()->flash('message', 'Cotización enviada correctamente.');
        return response()->json(['errors' => false]);
    }

    private function sendSupplierQuotationEmail($email, $data, $document_number, $document_reference, Employee $dealership, SupplySet $set)
    {   
        //Spanish as default, cause we have custom emails in addition to registered suppliers
        $message = DB::table('messages_languages')
        ->join('languages', 'languages.id', 'messages_languages.languages_id')
        ->where('languages.name', 'Español')->first();

        if(is_numeric($email)) {
            $supplier = Supplier::find($email);
            $email = $supplier->email;

            if(isset($supplier->$supplier->languages_id))
                $message = DB::table('messages_languages')->where('messages_id', $data['message_id'])
                ->where('languages_id', $supplier->languages_id)->first();
        }
        $subject = $message->subject;
        $dealership_user = $dealership->user;

        $message = $message->body . '<table>';
        $emailed_sets_ids = [];
        foreach($data['sets'] as $set) {
            $set = json_decode($set);
            $message .= '<tr>' .
            '<td><div>Número de parte: ' . $set->number . '</div>' .
            '<div>Descripción: ' . $set->description . '</div>' .
            '<div>Fabricante: ' . $set->manufacturer . '</div>' .
            '<div>Cantidad: ' . ((int)$set->quantity) . ' pzs</div></td></tr>';
            $emailed_sets_ids[] = $set->id;
        }

        $message .= '</table>';
        
        $message .= '<div>-----------------------------------------</div>' .
        '<div>Cotizador: ' . $dealership_user->name . '</div>' .
        '<div>Correo de cotizador: ' . $dealership_user->email . '</div>' . 
        '<div>Teléfono de cotizador:' . $dealership->ext . '</div>';

        try {            
/*            Mail::send([], [], function($m) use ($email, $subject, $body) {
                $m->from(Auth::user()->email);
                $m->to($email);
                $m->subject($subject);
                $m->setBody($body, 'text/html');
            });*/
            $dealership_email = Auth::user()->email;

            $subject = $subject . ' PCT'  . $document_number . ' ' . $document_reference;

            Helper::sendMail($email, $subject, $message, $dealership_email, $dealership_email);
            return ['emailed_sets_ids' => $emailed_sets_ids, 'supplier_email' => $email];

        } catch(\Exception $e) {
            Log::notice($e);
            throw new \Exception("Error al enviar el correo.", 1);
        }
    }

    private function registerQuotationEmailBinnacle($email, Array $sets)
    {
        try {        

            foreach($sets as $set) {
                $set = json_decode($set);
                $binnacle_data = [
                    'entity' => 2, //SupplySet
                    'pct_status' => $set->document_status, //In process
                    'comments' => 'Solicitud de cotización enviada al proveedor ' . $email,
                    'users_id' => Auth::user()->id,
                    'type' => 2, //Just a silly number that means nothing
                    'documents_id' => $set->document_id,
                    'documents_supplies_id' => $set->id
                ];

                Binnacle::create($binnacle_data);
            }
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function sendSuppliersQuotationValidations($data)
    {
        $messages = [
            'emails.required' => 'No se ha especificado ninguna dirección de correo de proveedor.',
            'custom_emails.*.email' => 'El formato en una o más direcciones de correo es incorrecto.',
            'sets.required' => 'No se ha seleccionado ninguna de las partes.',
            'message_id.required' => 'No se ha especificado un mensaje.'
        ];
        
        $validator = Validator::make($data, [
            'emails' => 'required',
            'custom_emails.*' => 'nullable|email',
            'sets' => 'required|array|min:1',
            'message_id' => 'required'
        ], $messages);

        return $validator;
    }

    public function changeSetStatus(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        if(!isset($request->checklist_form) || count($request->checklist_form) < 13) { //All of the checkboxes in checklist must be checked
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Existen puntos en el checklist sin revisar.')->render()]);
        }

        $status = $request->status;

        $base_query = DB::table('documents_supplies');
        $update_query = clone $base_query;
        
        $supply_set = SupplySet::find($request->set_id);

        $files = $base_query->join('supplies_files', 'supplies_files.supplies_id', 'documents_supplies.supplies_id')
        ->join('files', 'supplies_files.files_id', 'files.id')
        ->where('supplies_files.supplies_id', $supply_set->supplies_id)
        ->whereRaw('DATEDIFF(now(), files.created_at) < 30')->get();

        if($status == 6 && count($files) == 0)
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('La partida debe tener al menos un archivo o url de menos de 30 días de antigüedad.')->render()]);

        try {
           $update_query->where('id', $request->set_id)->update(['status' => $status]);            
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }

        $message = 'Estatus actualizado correctamente.';
        if($status == 6)
            $message = 'Partida cambiada a en autorización correctamente.';
        if($status == 7) {
            DB::table('documents_supplies')->where('id', $request->set_id)->update(['rejected_date' => date('Y-m-d H:i:s')]);
            $message = 'Partida rechazada correctamente.';
        }
        if($status == 8)
            $message = 'Partida autorizada correctamente.';

        $document_id = $request->document_id;
        $set_binnacle_data = [
            'entity' => 2,
            'comments' => $message,
            'pct_status' => 2,
            'users_id' => Auth::user()->id,
            'type' => 2, //Just a silly number tha means nothing
            'documents_id' => $document_id,
            'documents_supplies_id' => $request->set_id
        ];

        try {
            DB::table('checklist')->where('id', $request->set_id)->update(['material_specifications' => null, 'quoted_amounts' => null, 'quotation_currency' => null, 'unit_price' => null, 'delivery_time' => null, 'delivery_conditions' => null, 'product_condition' => null, 'entrance_shipment_costs' => null, 'weight_calculation' => null, 'material_origin' => null, 'incoterm' => null, 'minimum_purchase' => null, 'extra_charges' => null]);
            Binnacle::create($set_binnacle_data);

            $alert = Alert::where('type', 2)->where('set_status', $status)->first();
            if(!$alert)
                return response()->json([
                    'errors' => false,
                    'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
                    ->with('success_message', $message . ' No se ha enviado notificación por que no existe la alerta.')->render()
                ]);

            $document = $supply_set->document;
            $subject = $alert->subject . ' PCT'  . $document->number . ' ' . $document->reference;
            Helper::sendMail($alert->recipients, $subject, $alert->message, 'admin@admin.com', null);

        }catch(\Exception $e) {
            Log::notice($e);
            return redirect()->back()->withErrors($e->getMessage());
        }

        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', $message)->render()
        ]); 
    }

    /* Rejects a supply set */    
    public function rejectSet(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        $data = $request->all();
        $validator = $this->setRejectionValidations($data);
        
        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

        $set_id = $request->documents_supplies_id;

        $supply_set = SupplySet::find($set_id);

        $binnacle_data = [
            'entity' => 2, //item (supply set)
            'comments' => $request->comments,
            'pct_status' => $supply_set->document->status,
            'users_id' => Auth::user()->id,
            'type' => 2, //Just a silly number tha means nothing
            'documents_id' => $supply_set->document->id,
            'documents_supplies_id' => $set_id
        ];
        try {            
            DB::transaction(function() use($data, $supply_set, $binnacle_data) {

                Rejection::create($data);

                Binnacle::create($binnacle_data);

                $supply_set->update(['status' => 7, 'rejected_date' => Carbon::now()]);
            });

            $alert = Alert::where('type', 2)->where('set_status', 7)->first();
            if(!$alert) 
                return response()->json([
                    'errors' => false,
                    'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
                    ->with('success_message', 'Partida rechazada correctamente. No se ha enviado notificación por que no existe la alerta.')->render()
                ]); 

            $document = $supply_set->document;
            $subject = $alert->subject . ' PCT'  . $document->number . ' ' . $document->reference;
            Helper::sendMail($alert->recipients, $subject, $alert->message, 'admin@admin.com', null);

        } catch(\Exception $e) {
            Log::notice($e);
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }

        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Partida rechazada correctamente.')->render()
        ]); 
    }

    private function setRejectionValidations($data)
    {
        $messages = [
            'rejection_reasons_id.required' => 'El campo motivo es requerido.',
        ];
        
        $validator = Validator::make($data, [
            'rejection_reasons_id' => 'required',
        ], $messages);

        return $validator;
    }

    /*Turns a supply set into CTZ*/
    public function setsTurnCTZ(Request $request)
    {

        if(!$request->ajax())
            return response()->json([
                'errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        try {
            
            $supplies_sets = SupplySet::whereIn('id', $request->sets)->get();
            
            if($supplies_sets->count() == 0) return;

            $document = Document::find($request->document_id);

            $customers_errors = [];

            $conn = DB::table('sync_connections')->find($document->sync_connections_id);
            
            $ctz_number = $document->siavcom_ctz_number;

            if($document->siavcom_ctz == 0) {
                $last_siavcom_ctz_ndo_doc = DB::connection($conn->name)->table($this->siavcomDocumentsTable)
                ->where('tdo_tdo', 'CTZ')
                ->OrderBy('ndo_doc', 'desc')
                ->first();
                $ctz_number = $last_siavcom_ctz_ndo_doc->ndo_doc + 1;
            }

            DB::beginTransaction();
            $conn_name = $conn->name;
            DB::connection($conn_name)->beginTransaction();
            foreach($supplies_sets as $supply_set) {

                $customer = $supply_set->document->customer;

                $customer_verification = $this->verifyTurnCTZCustomer($customer);

                if(!$customer_verification['is_valid']) {
                    $customers_errors[] = trim($supply_set->supply->number) . ' - ' .
                    $customer_verification['message'];
                    continue;
                }

                $set_binnacle_data = [
                    'entity' => 2,
                    'documents_supplies_id' => $supply_set->id,
                    'comments' => 'Partida convertida a CTZ',
                    'pct_status' => 2,
                    'users_id' => Auth::user()->id,
                    'type' => 2, //Just a silly number tha means nothing
                    'documents_id' => $document->id,
                ];

                $supply_set->fill(['status' => 9, 'completed_date' => Carbon::now()->toDateTimeString()])
                ->update();

                Binnacle::create($set_binnacle_data);

                $this->createSiavcomCTZSet($supply_set, $conn, $ctz_number);
            }

            //Create CTZ on siavcom DB (zukaely, pavan or mxmro)
            if($document->siavcom_ctz == 0) {
                $this->createSiavcomCTZ($document, $conn, $ctz_number);
                $document->fill(['siavcom_ctz' => 1, 'siavcom_ctz_number' => $ctz_number])
                ->update();
            }

            $this->turnPCTtoCTZ($document);

            $document->touch();
            DB::commit();
            DB::connection($conn_name)->commit();
            return response()->json([
                'errors' => false,
                'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
                ->with('success_message', 'Partidas convertidas a CTZ correctamente.')->render()]); 

        } catch(\Exception $e) {
            DB::rollback();
            DB::connection($conn_name)->rollback();
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }

        if(!empty($customers_errors)) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($customers_errors)->with('title', 'Algunas de las partidas seleccionadas no pudieron ser convertidas a CTZ.')
                ->render()]);
        }
    }

    private function createSiavcomCTZSet(SupplySet $supply_set, $conn, $ctz_number)
    {
        $conn = DB::table('sync_connections')->find($supply_set->document->sync_connections_id);
        $last_siavcom_ctz_set_key_pri = DB::connection($conn->name)->table($this->siavcomDocumentsSuppliesTable)
        ->OrderBy('key_pri', 'desc')
        ->first();
        $condition = $supply_set->condition;
$sale_conditions = $condition->description . '
' . $condition->previous_sale . '
' . $condition->valid_prices . '
' . $condition->replacement . '
' . $condition->factory_replacement . '
' . $condition->condition . '
' . $condition->minimum_purchase . '
' . $condition->exworks;

        $total_cost = $this->calculateTotalCost($supply_set->sale_unit_cost, $supply_set->products_amount, $supply_set->importation_cost, 
        $supply_set->warehouse_shipment_cost, $supply_set->customer_shipment_cost, $supply_set->extra_charges);
        $utility_percentage = $supply_set->utility_percentage 
                            ? $supply_set->utility_percentage->percentage 
                            : $supply_set->custom_utility_percentage;
        $total_price = $this->calculateTotalPrice($total_cost, $utility_percentage);
        $unit_price = $total_price / $supply_set->products_amount;

        $set_currency = $supply_set->currency->name;
        $doc_currency = $supply_set->document->currency->name;

        if($set_currency != $doc_currency) {
            try {
                $unit_price = $this->currencyExchange($unit_price, $set_currency, $doc_currency);
            } catch(\Exception $e) {
                throw new \Exception($e->getMessage(), 1);
                
            }
        }

        $data = [
            'suc_pge' => '',
            'tdo_tdo' => 'CTZ',
            'ndo_doc' => $ctz_number,
            'mov_mov' => $supply_set->set,
            'ens_mov' => 0,
            'inv_tdo' => 'N',
            'cla_isu' => $supply_set->supply->number,
            'dse_mov' => $sale_conditions,
            /*'dse_mov' => $supply_set->supply->large_description . '\n' . $sale_conditions,*/
            'ser_mov' => '',
            'dga_pro' => 0,
            'ped_ped' => '',
            'can_mov' => $supply_set->products_amount,
            'med_mov' => $supply_set->mesurement_unit_code,
            'pve_mov' => $unit_price,
            'de1_mov' => 0,
            'de2_mov' => 0,
            'de3_mov' => 0,
            'de4_mov' => 0,
            'de5_mov' => 0,
            'im1_mov' => 0,
            'im2_mov' => 0,
            'im3_mov' => $supply_set->document->customer->getIVA() * 100,
            'im4_mov' => 0,
            'im5_mov' => 0,
            'tba_tba' => '',
            'pga_pga' => '',
            'mon_mov' => $supply_set->currencies_id,
            'adv_tar' => 0,
            'cuo_tar' => 0,
            'cpu_tar' => '',
            'fec_mov' => $supply_set->created_at,
            'fme_mov' => date('Y-m-d H:i:s', strtotime($supply_set->created_at . ' + 15 days')),
            'dpe_mov' => '',
            'npe_mov' => 0,
            'mpe_mov' => 0,
            'alm_tda' => '',
            'spi_mov' => '',
            'sns_mov' => '',
            'cen_mov' => 0,
            'tpe_mov' => '',
            'est_mov' => 'A',
            'usu_usu' => $supply_set->usu_usu,
            /*'tie_uac' => '',*/
            'key_pri' => $last_siavcom_ctz_set_key_pri->key_pri + 1,
            'im0_mov' => 0,
            'obs_mov' => ''
        ];
        DB::connection($conn->name)->table('comemov')->insert($data);
    }

    //Exchange to document's currency
    private function currencyExchange($amount, $set_currency, $doc_currency)
    {
        $currency_exchange_rates = [
            'USD' => null,
            'EUR' => null
        ];

        $sie_api_response = FALSE;
        if(file_exists(config('sie_api.url')))
            $sie_api_response = file_get_contents(config('sie_api.url'));

        if($sie_api_response === FALSE) {
            $non_mxn_currencies = Currency::where('name', '!=', 'MXN')->get();
            foreach($non_mxn_currencies as $currency) {
               if($currency->name == 'USD')
                $currency_exchange_rates['USD'] = $currency->mxn_exchange_rate;
               else if($currency->name == 'EUR')
                $currency_exchange_rates['EUR'] = $currency->mxn_exchange_rate;
            }
        } else {
            $response_obj = json_decode($sie_api_response);
            foreach($response_obj->bmx->series as $serie) {
                if($serie->idSerie == config('sie_api.usd_serie')) {
                    $currency_exchange_rates['USD'] = $serie->datos[0]->dato;
                    Currency::where('name', 'USD')->update(['mxn_exchange_rate' => $serie->datos[0]->dato]);
                }
                else if($serie->idSerie == config('sie_api.eur_serie')) {
                    $currency_exchange_rates['EUR'] = $serie->datos[0]->dato;
                    Currency::where('name', 'EUR')->update(['mxn_exchange_rate' => $serie->datos[0]->dato]);
                }
            }
        }

        if($set_currency == 'MXN') { //MXN to USD or EUR
            if(empty($currency_exchange_rates[$doc_currency])) 
                throw new \Exception("No se ha podido obtener el tipo de cambio.", 1);
            $amount /= $currency_exchange_rates[$doc_currency];
        }
        else if($set_currency == 'USD') { //USD to MXN or EUR
            if($doc_currency == 'MXN') { 
                if(empty($currency_exchange_rates[$set_currency])) 
                    throw new \Exception("No se ha podido obtener el tipo de cambio.", 1);
                $amount *= $currency_exchange_rates[$set_currency]; 
            }else { 
                if(empty($currency_exchange_rates[$doc_currency]))
                    throw new \Exception("No se ha podido obtener el tipo de cambio.", 1);
                $amount /= $currency_exchange_rates[$doc_currency]; 
            }
        } 
        else { //EUR to MXN or USD
            if(empty($currency_exchange_rates['EUR']))
                    throw new \Exception("No se ha podido obtener el tipo de cambio.", 1);
            $amount *= $currency_exchange_rates['EUR'];
            if($doc_currency == 'USD') { 
                if(empty($currency_exchange_rates['USD']))
                    throw new \Exception("No se ha podido obtener el tipo de cambio.", 1);
                $amount /= $currency_exchange_rates['USD']; 
            }
        }
        return $amount;
    }

    private function createSiavcomCTZ(Document $document, $conn, $ctz_number) 
    {
        $last_siavcom_ctz_key_pri = DB::connection($conn->name)->table($this->siavcomDocumentsTable)
        //->where('tdo_tdo', 'CTZ')
        ->OrderBy('key_pri', 'desc')
        ->first();

        //$subtotal = array_sum($document->supply_sets->pluck('sale_unit_cost')->toArray());

        $doc_currency = $document->currency->name;
        $subtotal = 0;

        foreach($document->supply_sets as $set) {

            $set_currency = $set->currency->name;
            $total_cost = $this->calculateTotalCost($set->sale_unit_cost, $set->products_amount, $set->importation_cost, 
            $set->warehouse_shipment_cost, $set->customer_shipment_cost, $set->extra_charges);

            $utility_percentage = $set->utility_percentage 
                                ? $set->utility_percentage->percentage 
                                : $set->custom_utility_percentage;


            $total_price = $this->calculateTotalPrice($total_cost, $utility_percentage);
            Log::notice('set id ' . $set->id . 'total_cost' . $total_cost . 'total price ' . $total_price);
            if($set_currency != $doc_currency) {
               try {
                   $total_price = $this->currencyExchange($total_price, $set_currency, $doc_currency);
               } catch(\Exception $e) {
                    throw new \Exception($e->getMessage(), 1);                    
               }
            }

            $subtotal += $total_price;
        }

        $key_pri = $last_siavcom_ctz_key_pri->key_pri + 1;

        $data = [
            'suc_pge' => '',
            'tdo_tdo' => 'CTZ',
            'ndo_doc' => $ctz_number,
            'ref_doc' => $document->reference,
            'cop_nom' => $document->cop_nom,
            'cod_nom' => $document->customer->code,
            'con_con' => $document->con_con,
            'fel_doc' => $document->fel_doc,
            'fec_doc' => $document->fec_doc,
            'fve_doc' => date('Y-m-d H:i:s', strtotime($document->created_at . ' + 15 days')),
            'imp_doc' => $subtotal,
            'im1_doc' => $document->im1_doc,
            'im2_doc' => $document->im2_doc,
            'im3_doc' => $subtotal * $document->customer->getIVA(),
            'im4_doc' => $document->im4_doc,
            'im5_doc' => $document->im5_doc,
            'ven_ven' => $document->seller_number,
            'com_doc' => $document->com_doc,
            'sta_doc' => 'P',
            'mon_doc' => $document->mon_doc,
            'vmo_doc' => $document->vmo_doc,
            'vm2_doc' => $document->vm2_doc,
            'vm3_doc' => $document->vm3_doc,
            'vm4_doc' => $document->vm4_doc,
            'vm5_doc' => $document->vm5_doc,
            'sal_doc' => $document->sal_doc,
            'ale_doc' => '',
            'als_doc' => '',
            'ob1_doc' => $document->ob1_doc,
            'ob2_doc' => $document->dealership->user->name,
            'ob3_doc' => '',
            'aut_doc' => '',
            'sau_doc' => $document->sau_doc,
            'fau_doc' => $document->fau_doc,
            'ped_ped' => '',
            'hrs_doc' => date("H:i:s"),
            'rut_rut' => $document->rut_rut,
            'num_pry' => $document->num_pry,
            'tcd_tcd' => $document->dealership->buyer_number,
            //'via_via' => '',
            'pga_pga' => '',
            'tba_tba' => '',
            /*'cba_cba' => '',*/
            'che_doc' => $document->che_doc,
            'usu_usu' => $document->usu_usu,
            //'tie_uac' => '',
            'key_pri' => $key_pri,
            'tor_doc' => $document->tor_doc,
            'nor_doc' => $document->nor_doc,
            'tde_doc' => '',
            //'nde_doc' => '',
            'im0_doc' => $document->im0_doc,
            'mov_doc' => $document->mov_doc,
            'fip_doc' => $document->fip_doc,
            'tpa_doc' => $document->tpa_doc,
            'rpa_doc' => $document->rpa_doc,
            'tip_tdn' => $document->tip_tdn,
            'npa_doc' => $document->npa_doc,
            'mpa_sat' => $document->mpa_sat,
            'fpa_sat' => $document->fpa_sat,
            'uso_sat' => $document->uso_sat,
            'tre_sat' => '',
            'tdr_doc' => '',
            'ndr_doc' => $document->ndr_doc,
            'dto_doc' => $document->dto_doc
        ];
        try {
            //Inserts new CTZ
            DB::connection($conn->name)->table('comedoc')->insert($data); 
            //Update above CTZ related PCT
            DB::connection($conn->name)->table('comedoc')
            ->where('ndo_doc', $document->number)
            ->where('tdo_tdo', 'PCT')
            ->update(['tde_doc' => 'CTZ', 'nde_doc' => $ctz_number]);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 1);            
        }
    }

    private function turnPCTtoCTZ(Document $pct)
    {
        $pct_supplies_count = $pct->supplies->count();
        $pct_ctz_supplies_count = $pct->supplies()->wherePivot('status', '=', 9)->count();

        if($pct_ctz_supplies_count < $pct_supplies_count) return;

        $pct_binnacle_data = [
            'entity' => 1,
            'comments' => 'PCT convertida a CTZ',
            'pct_status' => 3,
            'users_id' => Auth::user()->id,
            'type' => 2, //Just a silly number tha means nothing
            'documents_id' =>$pct->id
        ];

        try {           

            $pct->fill(['status' => 3, 'completed_date' => Carbon::now()->toDateTimeString()])->update();
            Binnacle::create($pct_binnacle_data);

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    /*Verify if supply set's customer is correct to turn a pct into a CTZ*/
    private function verifyTurnCTZCustomer(Customer $customer)
    {
        $result = ['is_valid' => true];
        $country = trim(strtolower($customer->country));
        
        $search = ['é','í','ó','è','ì','ò','ë','ï','ö','ê','î','ô'];
        $replace = ['e','i','o','e','i','o','e','i','o','e','i','o'];
        $country = str_replace($search, $replace, $country);

        if($customer->type == 1 && $country == 'mexico') { //Foreign customer
            $result['is_valid'] = false;
            $result['message'] = 'El cliente asociado a la partida es extranjero y tiene a México como país.';
        }
        if($customer->type == 9 && $country != 'mexico') {
            $result['is_valid'] = false;
            $result['message'] = 'El cliente asociado a la partida es persona moral y tiene un país diferente a México.';
        }

        return $result;
    }

    public function binnacleEntry(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        $data = $request->all();
        $validator = $this->binnacleEntryValidations($data);

        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

        $entity = $request->entity;
        $data['users_id'] = Auth::user()->id;
        $document = Document::find($request->documents_id);
        $data['pct_status'] = $document->status;
        try {
            if($entity == 1)
                Binnacle::create($data);
            else {
                $supplies = $data['supplies'];
                unset($data['supplies']);
                foreach($supplies as $supply_id) {
                    $data['documents_supplies_id'] = $supply_id;
                    Binnacle::create($data);
                }
            }

        }catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }

        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Entrada agregada correctamente.')->render()
        ]); 

    }

    private function binnacleEntryValidations($data)
    {
        $messages = [
            'entity.required' => 'El campo Item o PCT es requerido.',
            'type.required' => 'El campo tipo es requerido.',
            'comments.required' => 'El campo comentarios es requerido.',
            'supplies.required' => 'Se debe especificar al menos un número de parte.'
        ];
        
        $validator = Validator::make($data, [
            'entity' => 'required',
            'type' => 'required',
            'comments' => 'required'
        ], $messages);

        $validator->sometimes('supplies', 'required', function($data){
            return $data['entity'] == 2;
        });

        return $validator;
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
     * Remove the specified resource from  .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
