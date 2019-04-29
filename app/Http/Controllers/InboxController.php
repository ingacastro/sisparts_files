<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use IParts\Document;
use IParts\ColorSetting;
use IParts\User;
use IParts\Manufacturer;
use IParts\Currency;
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
        $document = Document::find($id);
        $document_supplies = $document->supplies->pluck('number', 'pivot.id');
        return view('inbox.show', compact('document', 'manufacturers', 'document_supplies'));
    }

    public function getSetTabs(Request $request, $set_id)
    {
        if($request->ajax()) {

            $set_pri_key = explode('_', $set_id);
            $set = DB::table('documents_supplies')->where('documents_id', $set_pri_key[0])
            ->where('supplies_id', $set_pri_key[1])->first();
            
            $manufacturers = Manufacturer::pluck('name', 'id');
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
                'budget_tab' => \View::make('inbox.set_edition_modal_tabs.budget', compact('set', 'manufacturers', 'currencies', 
                    'measurement', 'countries', 'utility_percentages', 'checklist'))
                ->render(),
                'conditions_tab' => \View::make('inbox.set_edition_modal_tabs.conditions', compact('set', 'set_conditions', 
                    'conditions', 'checklist'))
                ->render(),
                'files_tab' => \View::make('inbox.set_edition_modal_tabs.files', compact('set', 'checklist'))
                ->render()]);
        }
        
        abort(403, 'Unauthorized action');
    }

    public function getSetFiles(Request $request, $set_id)
    {
        if($request->ajax()):

            $files = DB::table('files')->where('documents_supplies_id', $set_id)->get();

            return Datatables::of($files)
                  ->editColumn('created_at', function($file) {
                    return date('d/m/Y', strtotime($file->created_at));
                  })
                  ->addColumn('actions', function($file) {
                    return '<a href="/inbox/' . $file->id . '"class="btn btn-circle btn-icon-only green"><i class="fa fa-link"></i></a><a href="" class="btn btn-circle btn-icon-only default change-dealership"><i class="fa fa-download"></i></a><a class="btn btn-circle btn-icon-only default blue"><i class="fa fa-trash"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        endif;
        abort(403, 'Unauthorized action');
    }

    public function setsFileAttachment(Request $request)
    {
        Log::notice($request);
    }

    /*Document supplies sets*/
    public function getDocumentSupplies(Request $request)
    {
        if($request->ajax()) {            
            $supplies_sets = Document::select('supplies.number', 'manufacturers.name as manufacturer', 
            DB::raw('CAST(documents_supplies.products_amount as UNSIGNED) as products_amount'),
            DB::raw('CASE WHEN documents_supplies.measurement_unit_code = 1 THEN "Pieza" ELSE "Caja" END AS measurement_unit_code'), 
            DB::raw('documents_supplies.sale_unit_cost * documents_supplies.products_amount + documents_supplies.importation_cost
            + documents_supplies.warehouse_shipment_cost + documents_supplies.customer_shipment_cost + documents_supplies.extra_charges as total_cost'), 
            'currencies.name as currency', 'documents_supplies.type as status', 'documents_supplies.documents_id', 
            'documents_supplies.supplies_id',
            DB::raw('CASE WHEN documents_supplies.utility_percentages_id IS NOT null THEN utility_percentages.percentage
                ELSE documents_supplies.custom_utility_percentage END AS utility_percentage'))
            ->leftJoin('documents_supplies', 'documents.id', 'documents_supplies.documents_id')
            ->leftJoin('supplies', 'documents_supplies.supplies_id', 'supplies.id')
            ->leftjoin('manufacturers', 'manufacturers.id', 'documents_supplies.manufacturers_id')
            ->leftJoin('currencies', 'currencies.id', 'documents_supplies.currencies_id')
            ->leftJoin('utility_percentages', 'utility_percentages.id', 'documents_supplies.utility_percentages_id')
            ->where('documents.id', $request->document_id)->get();

            return Datatables::of($supplies_sets)
                  ->addColumn('actions', function($supplies_set) {

                    $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                    $unit_price = $total_price / $supplies_set->products_amount;
                    $total_profit = $total_price - $supplies_set->total_cost;
                    $currency = ' ' . $supplies_set->currency;

                    return '<a data-target="#edit_set_modal" data-toggle="modal" class="btn btn-circle btn-icon-only default edit-set" 
                    data-id="' . $supplies_set->documents_id . '_' . $supplies_set->supplies_id . '"
                    data-total_cost="' . '$ ' . number_format($supplies_set->total_cost, 2, '.', ',') . $currency . '" 
                    data-total_price="' . '$ ' . number_format($total_price, 2, '.', ',') . $currency . '"
                    data-unit_price="' . '$ ' . number_format($unit_price, 2, '.', ',') . $currency . '"
                    data-total_profit="' . '$ ' . number_format($total_profit, 2, '.', ',') . $currency . '"><i class="fa fa-edit"></i></a>';
                  })
                  ->editColumn('total_cost', function($supplies_set) {

                    return '$ ' . number_format($supplies_set->total_cost, 2, '.', ',') . ' ' . $supplies_set->currency;

                  })
                  ->addColumn('total_price', function($supplies_set) {

                    $total_price = $this->calculateTotalPrice($supplies_set->total_cost, $supplies_set->utility_percentage);
                    return '$ ' .  number_format($total_price, 2, '.', ',') . ' ' . $supplies_set->currency;

                  })
                  ->rawColumns(['actions' => 'actions', 'total_cost' => 'total_cost', 'total_price' => 'total_price'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
    }

    private function calculateTotalPrice($total_cost, $utility_percentage)
    {
        return $total_cost / ((100 - $utility_percentage) / 100);
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

    public function updateChecklist(Request $request, $set_id)
    {
        if(!$request->ajax())
            return response()->json([
                'errors' => true, 
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()]);

        $request_data = $request->except('_token');
        $checklist = [ 'material_specifications' => '', 'quoted_amounts' => '', 'quotation_currency' => '', 'unit_price' => '', 
          'delivery_time' => '', 'delivery_conditions' => '', 'product_condition' => '', 'entrance_shipment_costs' => '',
          'weight_calculation' => '', 'material_origin' => '', 'incoterm' => '', 'minimum_purchase' => '',
          'extra_charges' => '',
        ];

        $checklist = array_merge($checklist, $request_data);

        try {
            DB::table('checklist')->where('id', $set_id)->update($checklist);
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
        
        return response()->json([
            'errors' => false,
            'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
            ->with('success_message', 'Checklist correctamente actualizado.')->render()
        ]);
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
