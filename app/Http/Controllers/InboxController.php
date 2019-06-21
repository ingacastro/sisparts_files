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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Validator;
use DB;
use Auth;
use Storage;
use Mail;
use Carbon\Carbon;

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

            $route = $request->route;
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
            if($route == 'archive')
                $query->where('documents.status', 4);

             $documents = $query->get($fields);
             return $this->buildInboxDataTable($documents, $route);
        }
        abort(403, 'Unauthorized action');
    }

    private function buildInboxDataTable($documents, $route)
    {
        return Datatables::of($documents)
              ->editColumn('semaphore', function($document) {
                return '<div class="form-control" style="background-color: ' . $document->semaphore_color . '; width: 100%; height: 25px;
                            line-height: 100%; vertical-align: middle; text-align: center; color: #fff">' . 
                            $document->semaphore_days . ' días </div>';
              })
              ->editColumn('created_at', function($document) {
                return date_format(new \DateTime($document->created_at), 'd/m/Y');
              })
              ->addColumn('actions', function($document) use ($route) {
                $actions = ($route == 'inbox') 
                ? '<a href="/inbox/' . $document->id . '" class="btn btn-circle btn-icon-only green"><i class="fa fa-eye"></i></a><a data-target="#brands_modal" data-toggle="modal" href="#brands_modal" class="btn btn-circle btn-icon-only default change-dealership" data-buyer="' . $document->buyer.'" data-document_id="' . $document->id . '"><i class="fa fa-user"></i></a><a class="btn btn-circle btn-icon-only default blue" onClick="archiveDocument(event, ' . $document->id . ')"><i class="fa fa-archive"></i></a>'
                : '<a href="/archive/' . $document->id . '" class="btn btn-circle btn-icon-only green"><i class="fa fa-eye"></i></a>';
                return $actions;
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
        $document = Document::find($id);
        $document_supplies = $document->supplies->pluck('number', 'pivot.id');
        $messages = DB::table('messages')
        ->leftJoin('messages_languages', 'messages.id', 'messages_languages.messages_id')
        ->leftJoin('languages', 'messages_languages.languages_id', 'languages.id')
        ->where('languages.name', 'Español')
        ->pluck('messages_languages.title', 'messages.id');

        $rejection_reasons = DB::table('rejection_reasons')->pluck('title', 'id');

        return view('inbox.show', compact('document', 'manufacturers', 'document_supplies', 'messages', 
            'rejection_reasons'));
    }

    public function getSetTabs(Request $request, $set_id)
    {
        if($request->ajax()) {

            $set_pri_key = explode('_', $set_id);
            $doc_id = $set_pri_key[0];
            $set = DB::table('documents_supplies')->where('documents_id', $doc_id)
            ->where('supplies_id', $set_pri_key[1])->first();
            
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
        
        abort(403, 'Unauthorized action');
    }

    public function getSetFiles(Request $request, $set_id)
    {
        if($request->ajax()):

            $files = DB::table('files')
            ->join('documents_supplies_files', 'documents_supplies_files.files_id', 'files.id')
            ->join('documents_supplies', 'documents_supplies.id', 'documents_supplies_files.documents_supplies_id')
            ->where('documents_supplies.id', $set_id)->get();

            return Datatables::of($files)
                  ->editColumn('created_at', function($file) {
                    return date('d/m/Y', strtotime($file->created_at));
                  })
                  ->addColumn('actions', function($file) {
                    return '<a href="' . $file->url . '" target="_blank" class="btn btn-circle btn-icon-only green"><i class="fa fa-link"></i></a><a href="/' . $file->path . '" class="btn btn-circle btn-icon-only default change-dealership" download><i class="fa fa-download"></i></a><a class="btn btn-circle btn-icon-only default blue" onClick="detachFile(event,' . $file->documents_supplies_id .',' . $file->files_id .',2' . ')"><i class="fa fa-trash"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        endif;
        abort(403, 'Unauthorized action');
    }

    public function setsFileAttachment(Request $request)
    {

        if(!$request->ajax())
            return response()->json([
                'errorrs' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()
            ]);

        if(!$request->has('file') && empty($request->url))
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
                if($request->has('file')) {
                    $file_name = $request->file->store(null, 'supplies_sets_files');
                    $data['path'] = 'storage/supplies_sets_files/' . $file_name;
                }
                
                $file = File::create($data);
                $file->sets()->attach($data['sets']);
            });
            
        } catch(\Exception $e) {
            Storage::disk('supplies_sets_files')->delete($file_name);
            return response()->json([
                'errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render() 
            ]);
        }

      return response()->json([
        'errors' => false, 
        'file' => $file,
        'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
        ->with('success_message', 'Archivo guardado correctamente.')->render()
      ]);
    }

    private function fileAttachmentValidations($data)
    {
        $messages = [
            'supplier.required' => 'El campo proveedor es requerido.',
            'url.url' => 'La url debe seguir el formato http(s)://dominio.com'
        ];
        
        $validator = Validator::make($data, [
            'supplier' => 'required',
            'url' => 'nullable|url'
        ], $messages);

        return $validator;
    }

    public function getDocumentSetsFiles(Request $request, $document_id)
    {
        if($request->ajax()):

            $files = DB::table('files')->select('files.id', 'files.created_at', 'files.supplier', 'files.url', 'files.path',
            'documents_supplies_files.documents_supplies_id', 'documents_supplies_files.files_id')
            ->join('documents_supplies_files', 'documents_supplies_files.files_id', 'files.id')
            ->join('documents_supplies', 'documents_supplies.id', 'documents_supplies_files.documents_supplies_id')
            ->where('documents_supplies.documents_id', $document_id)->get();
            return Datatables::of($files)
                  ->editColumn('created_at', function($file) {
                    return date('d/m/Y', strtotime($file->created_at));
                  })
                  ->addColumn('actions', function($file) {
                    return '<a href="' . $file->url . '" target="_blank" class="btn btn-circle btn-icon-only green"><i class="fa fa-link"></i></a><a href="/' . $file->path .'" class="btn btn-circle btn-icon-only default change-dealership" download><i class="fa fa-download"></i></a><a class="btn btn-circle btn-icon-only default blue" onClick="detachFile(event,'. $file->documents_supplies_id .',' . $file->files_id .',1' . ')"><i class="fa fa-trash"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        endif;
        abort(403, 'Unauthorized action');
    }

    public function setFileDetach($set_id, $file_id)
    {
        try {
            File::find($file_id)->sets()->detach($set_id);
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
      return response()->json(['errors' => false, 
        'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
        ->with('success_message', 'Archivo eliminado correctamente.')->render()
      ]);
    }

    /*Document supplies sets and only authorized sets*/
    public function getDocumentSupplySets(Request $request)
    {
        if($request->ajax()):          

            $query = Document::select('documents_supplies.id', 'documents_supplies.set', 'supplies.manufacturers_id', 'supplies.number', 'suppliers.trade_name as supplier', 
            DB::raw('CAST(documents_supplies.products_amount as UNSIGNED) as products_amount'),
            DB::raw('CASE WHEN documents_supplies.measurement_unit_code = 1 THEN "Pieza" ELSE "Caja" END AS measurement_unit_code'), 
            DB::raw('documents_supplies.sale_unit_cost * documents_supplies.products_amount + documents_supplies.importation_cost
            + documents_supplies.warehouse_shipment_cost + documents_supplies.customer_shipment_cost + documents_supplies.extra_charges as total_cost'), 
            'currencies.name as currency', 
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
                ELSE documents_supplies.custom_utility_percentage END AS utility_percentage'))
            ->leftJoin('documents_supplies', 'documents.id', 'documents_supplies.documents_id')
            ->join('supplies', 'documents_supplies.supplies_id', 'supplies.id')
            ->leftjoin('suppliers', 'suppliers.id', 'documents_supplies.suppliers_id')
            ->leftJoin('currencies', 'currencies.id', 'documents_supplies.currencies_id')
            ->leftJoin('utility_percentages', 'utility_percentages.id', 'documents_supplies.utility_percentages_id')
            ->where('documents.id', $request->document_id);

            if($request->has('status'))
                $query->where('documents_supplies.status', $request->status);

            $supplies_sets = $query->get();

            return Datatables::of($supplies_sets)
                  ->addColumn('actions', function($supplies_set) use ($request) {

                    $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                    $unit_price = $total_price / $supplies_set->products_amount;
                    $total_profit = $total_price - $supplies_set->total_cost;
                    $currency = ' ' . $supplies_set->currency;

                    return ($request->route == 'inbox') 
                    ? '<a data-target="#edit_set_modal" data-toggle="modal" class="btn btn-circle btn-icon-only default edit-set" 
                    data-id="' . $supplies_set->documents_id . '_' . $supplies_set->supplies_id . '"
                    data-total_cost="' . '$ ' . number_format($supplies_set->total_cost, 2, '.', ',') . $currency . '" 
                    data-total_price="' . '$ ' . number_format($total_price, 2, '.', ',') . $currency . '"
                    data-unit_price="' . '$ ' . number_format($unit_price, 2, '.', ',') . $currency . '"
                    data-total_profit="' . '$ ' . number_format($total_profit, 2, '.', ',') . $currency . '"
                    data-set_number=" ' . $supplies_set->set . '"
                    data-supply_number=" ' . $supplies_set->number . '"><i class="fa fa-edit"></i></a>
                    <a data-target="#quotation_request_modal" data-toggle="modal" class="btn btn-circle yellow-crusta btn-icon-only default quotation-request"
                    data-number="' . $supplies_set->number . '"
                    data-manufacturer_id="' . $supplies_set->manufacturers_id . '"
                    data-id="' . $supplies_set->id . '"><i class="fa fa-envelope"></i></a>
                    <a class="btn btn-circle btn-icon-only default blue set-file-attachment" href="#set_file_attachment_modal" data-target="#set_file_attachment_modal" data-toggle="modal"
                    data-set_id="' . $supplies_set->id . '"><i class="fa fa-paperclip"></i></a>'
                    : null;
                  })
                  ->addColumn('checkbox', function($supplies_set){
                    return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" class="checkboxes" value="' . $supplies_set->id . '"><span></span></label>';
                  })
                  ->editColumn('total_cost', function($supplies_set) {
                    return '$ ' . number_format($supplies_set->total_cost, 2, '.', ',') . ' ' . $supplies_set->currency;
                  })
                  ->addColumn('total_price', function($supplies_set) {
                    $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                    return '$ ' .  number_format($total_price, 2, '.', ',') . ' ' . $supplies_set->currency;
                  })
                  ->rawColumns(['actions' => 'actions', 'total_cost' => 'total_cost', 
                    'total_price' => 'total_price', 'checkbox' => 'checkbox'])
                  ->make(true);
        endif;
        abort(403, 'Unauthorized action');
    }

    public function getDocumentBinnacle(Request $request, $documents_id)
    {
        if($request->ajax()):

            $binnacles = Binnacle::select('binnacles.created_at', 
                DB::raw('CASE WHEN binnacles.entity = 1 THEN "PCT" ELSE supplies.number END as entity'),
                DB::raw('CASE 
                    WHEN binnacles.type = 1 THEN "Llamada" ELSE "" END as type'), 
                'users.name as user', 'binnacles.comments')
                ->join('users', 'binnacles.employees_users_id', 'users.id')
                ->leftJoin('supplies', 'binnacles.documents_supplies_id', 'supplies.id')
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

    public function getManufacturerSuppliers($manufacturer_id)
    {
        $suppliers = Manufacturer::find($manufacturer_id)->suppliers;
        return response()->json(Manufacturer::find($manufacturer_id)->suppliers);
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

        if($utility_percent_arr[0] == 0) {
            $data['set']['custom_utility_percentage'] = $utility_percent_arr[1];
            $data['set']['utility_percentages_id'] = null;
        }else {
            $data['set']['utility_percentages_id'] = $utility_percent_arr[0];
            $data['set']['custom_utility_percentage'] = null;
        }

        try {
            $document_supply = DB::table('documents_supplies')->where('documents_id', $set_id[0])
            ->where('supplies_id', $set_id[1])->first();
            DB::table('documents_supplies')->where('documents_id', $set_id[0])
            ->where('supplies_id', $set_id[1])->update($data['set']);
            
            DB::table('measurements')->where('id', $document_supply->id)->update($data['measurement']);
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
        
        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Presupuesto correctamente actualizado.')->render()
        ]);
    }

    private function budgetValidations($data)
    {
        $messages = [
            'set.sale_unit_cost.required' => 'El campo costo unitario es requerido.',
            'set.importation_cost.required' => 'El campo importación es requerido.',
            'set.warehouse_shipment_cost.required' => 'El campo envío al almacen es requerido.',
            'set.customer_shipment_cost.required' => 'El campo envío al cliente es requerido.',
            'set.extra_charges.required' => 'El campo gastos extra es requerido.',
            'utility_percentage.required' => 'El porcentaje de utilidad es requerido.',
            'utility_percentage.min' => 'El porcentaje de utilidad mínimo, es 1.',
            'utility_percentage.max' => 'El porcentaje de utilidad máximo, es 100.'
        ];
        
        $validator = Validator::make($data, [
            'set.sale_unit_cost' => 'required',
            'set.importation_cost' => 'required',
            'set.warehouse_shipment_cost' => 'required',
            'set.customer_shipment_cost' => 'required',
            'set.extra_charges' => 'required',
            'utility_percentage' => 'required|numeric|min:1|max:100'
        ], $messages);

        return $validator;
    }

    public function checkChecklistItem(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        try {
            $obj = DB::table('checklist')->where('id', $request->checklist_id)
            ->update([$request->field => 'checked']);
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
        foreach($request->suppliers_ids as $supplier_id) {
            $supplier = Supplier::find($supplier_id);
            $message = DB::table('messages_languages')->where('messages_id', $request->message_id)
            ->where('languages_id', $supplier->languages_id)->first();
            try {                
                Mail::send([], [], function($m) use ($supplier, $message) {
                    $m->to($supplier->email);
                    $m->subject($message->subject);
                    $m->setBody($message->body, 'text/html');
                });
            } catch(\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }

        $set = SupplySet::find($request->documents_supplies_id);
        $set->fill(['status' => 2])->update();
        $doc = Document::find($set->documents_id);
        $doc->fill(['status' => 2])->update();

        $binnacle_data = [
            'entity' => 2,
            'pct_status' => $doc->status, //In process
            'comments' => 'Solicitud de cotización enviada',
            'employees_users_id' => Auth::user()->id,
            'type' => 2, //Just a silly number that means nothing
            'documents_id' => $doc->id,
            'documents_supplies_id' => $set->id
        ];

        try {
            DB::table('documents_supplies')->where('id', $doc_supply_id)->update(['status' => 2]);
            Binnacle::create($binnacle_data);
        }catch(\Exception $e) {
            Log::notice($e);
            return redirect()->back()->withErrors($e->getMessage());
        }

        $request->session()->flash('message', 'Cotización enviada correctamente.');
        return redirect()->back();
    }

    public function changeSetStatus(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        $status = $request->status;

        $base_query = DB::table('documents_supplies');
        $update_query = clone $base_query;
        
        $files = $base_query->join('documents_supplies_files', 'documents_supplies_files.documents_supplies_id', 'documents_supplies.id')
        ->join('files', 'documents_supplies_files.files_id', 'files.id')
        ->where('documents_supplies.id', $request->set_id)
        ->whereRaw('DATEDIFF(now(), files.created_at) < 30')->get();

        if($status == 6 && count($files) == 0)
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('La partida debe tener al menos un archivo de menos de 30 días de antigüedad.')->render()]);

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
            'employees_users_id' => Auth::user()->id,
            'type' => 2, //Just a silly number tha means nothing
            'documents_id' => $document_id,
            'documents_supplies_id' => $request->set_id
        ];

        try {
            Binnacle::create($set_binnacle_data);
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
            'employees_users_id' => Auth::user()->id,
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

    public function setsTurnCTZ(Request $request)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        $document_id = $request->document_id;

        try {
            DB::table('documents_supplies')->whereIn('id', $request->sets)->update(['status' => 9, 'completed_date' => Carbon::now()->toDateTimeString()]);
            foreach($request->sets as $set_id) {
                $set_binnacle_data = [
                    'entity' => 2,
                    'documents_supplies_id' => $set_id,
                    'comments' => 'Partida convertida a CTZ',
                    'pct_status' => 2,
                    'employees_users_id' => Auth::user()->id,
                    'type' => 2, //Just a silly number tha means nothing
                    'documents_id' => $document_id,
                ];
                Binnacle::create($set_binnacle_data);
            }
           //PCT Binnacle 
            $pct = Document::find($document_id);
            $pct->fill(['status' => 3, 'completed_date' => Carbon::now()->toDateTimeString()])->update();
            $pct_supplies_count = $pct->supplies->count();
            $pct_ctz_supplies_count = $pct->supplies()->wherePivot('status', '=', 9)->count();

            if($pct_supplies_count == $pct_ctz_supplies_count) {
                $pct_binnacle_data = [
                    'entity' => 1,
                    'comments' => 'PCT convertida a CTZ',
                    'pct_status' => 3,
                    'employees_users_id' => Auth::user()->id,
                    'type' => 2, //Just a silly number tha means nothing
                    'documents_id' => $document_id
                ];
                Binnacle::create($pct_binnacle_data);
            }
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }

        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Partidas convertidas a CTZ correctamente.')->render()
        ]); 
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
        $data['employees_users_id'] = Auth::user()->id;
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
