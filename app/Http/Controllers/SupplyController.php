<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use IParts\Supply;
use IParts\SupplySet;
use IParts\Binnacle;
use Validator;
use DB;
use IParts\Replacement;
use IParts\Observation;
use IParts\Document;

class SupplyController extends Controller
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
        return view('supply.index');
    }

    public function getList(Request $request)
    {    
        if($request->ajax()) {

            $supplies = Supply::select('supplies.id', 'supplies.number', 'manufacturers.name as manufacturer',
            'supplies.short_description', 'supplies.large_description',
            DB::raw('GROUP_CONCAT(CASE WHEN documents_supplies.status > 1 THEN CONCAT(suppliers.trade_name, " " ,"(Cotizado)")
            WHEN documents_supplies.id is null THEN suppliers.trade_name END) as suppliers'),
            DB::raw('GROUP_CONCAT(files.path) as files'))
            ->leftJoin('manufacturers', 'manufacturers.id', 'supplies.manufacturers_id')
            ->leftJoin('suppliers_manufacturers', 'suppliers_manufacturers.manufacturers_id', 'manufacturers.id')
            ->leftJoin('suppliers', 'suppliers.id', 'suppliers_manufacturers.suppliers_id')
            ->leftJoin('documents_supplies', 'documents_supplies.suppliers_id', 'suppliers.id')
            ->leftJoin('supplies_files', 'supplies_files.supplies_id', 'supplies.id')
            ->leftJoin('files', 'supplies_files.files_id', 'files.id')
            ->groupBy('supplies.id')
            ->get();

            return Datatables::of($supplies)
                  ->addColumn('actions', function($supply) {
                        return '<a href="#replacement_observation_modal" class="btn btn-circle btn-icon-only blue replacement-observation" data-toggle="modal" data-target="#replacement_observation_modal" 
                            data-supply_id="' . $supply->id . '" data-type="1"><i class="fa fa-refresh"></i></a>
                        <a href="#replacement_observation_modal" class="btn btn-circle btn-icon-only yellow-crusta replacement-observation" data-toggle="modal" data-target="#replacement_observation_modal" 
                            data-supply_id="' . $supply->id . '" data-type="2"><i class="fa fa-clipboard"></i></a>
                        <a href="#pcts_modal" class="btn btn-circle btn-icon-only default pcts" data-toggle="modal" data-target="#pcts_modal" 
                            data-supply_id="' . $supply->id . '"><i class="fa fa-list"></i></a>
                        <a href="#suppliy_binnacle_modal" class="btn btn-circle btn-icon-only green-meadow supply-binnacle" data-toggle="modal" data-target="#supply_binnacle_modal" data-supply_id="' . $supply->id . '"><i class="fa fa-list"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
    }

    public function getPcts(Request $request, $supply_id)
    {
        if($request->ajax()) {

            $documents = Document::select('documents.id', 'documents.created_at', 'documents.number',
            DB::raw('"RFQ" as rfq'), 'documents_supplies.products_amount', 'documents_supplies.sale_unit_cost',
            DB::raw('documents_supplies.sale_unit_cost * documents_supplies.products_amount + documents_supplies.importation_cost
            + documents_supplies.warehouse_shipment_cost + documents_supplies.customer_shipment_cost + documents_supplies.extra_charges as total_cost'),
            DB::raw('CASE WHEN documents_supplies.utility_percentages_id IS NOT null THEN utility_percentages.percentage
                ELSE documents_supplies.custom_utility_percentage END AS utility_percentage'),
            'suppliers.trade_name as supplier')
            ->leftJoin('documents_supplies', 'documents_supplies.documents_id', 'documents.id')
            ->leftJoin('utility_percentages', 'utility_percentages.id', 'documents_supplies.utility_percentages_id')
            ->leftJoin('suppliers', 'suppliers.id', 'documents_supplies.suppliers_id')
            ->where('documents_supplies.supplies_id', $supply_id)
            ->get();

            return Datatables::of($documents)
                  ->editColumn('created_at', function($document) {
                    return date('d/m/Y', strtotime($document->created_at));
                  })
                  ->addColumn('unit_total_cost', function($supplies_set) {
                    return '$' . number_format($supplies_set->sale_unit_cost, 2, '.', ',') . ' ' . $supplies_set->currency . ' - ' .
                           '$' . number_format($supplies_set->total_cost, 2, '.', ',') . ' ' . $supplies_set->currency;
                  })
                  ->addColumn('unit_total_price', function($supplies_set) {

                    $total_price = $supplies_set->total_cost / ((100 - $supplies_set->utility_percentage) / 100);
                    $unit_price = $total_price / $supplies_set->products_amount;

                    return '$' . number_format($unit_price, 2, '.', ',') . ' ' . $supplies_set->currency . ' - ' .
                           '$' . number_format($total_price, 2, '.', ',') . ' ' . $supplies_set->currency;
                  })
                  ->addColumn('actions', function($document) {
                        return '<a href="' . config('app.url') . '/inbox/' . $document->id . '" class="btn btn-circle btn-icon-only green"><i class="fa fa-eye"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
    }

    public function getBinnacle(Request $request, $supply_id)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

          $sets_ids = SupplySet::where('supplies_id', $supply_id)->pluck('id');
          $binnacles = Binnacle::select('binnacles.*', 'users.name as user',
          DB::raw('(CASE binnacles.entity WHEN 1 THEN "PCT" ELSE supplies.number END) as entity'),
          DB::raw('(CASE WHEN binnacles.type = 1 THEN "Llamada" ELSE "" END) as type'))
          ->leftJoin('documents_supplies', 'documents_supplies.id', 'binnacles.documents_supplies_id')
          ->join('supplies', 'documents_supplies.supplies_id', 'supplies.id')
          ->leftJoin('users', 'binnacles.users_id', 'users.id')
          ->whereIn('documents_supplies_id', $sets_ids)->get();
          
          return Datatables::of($binnacles)->make(true);
    }

    public function getReplacementsObservations(Request $request, $supply_id, $type)
    {
        if($request->ajax()) {

            $table = $type == 1 ? 'replacements' : 'observations';
            $items = DB::table($table)->where('supplies_id', $supply_id)->get();

            return Datatables::of($items)
                  ->addColumn('actions', function($item) use($type) {
                        $actions = '<a class="btn btn-circle btn-icon-only red"
                            onclick="deleteReplacementObservation(event,' . $item->id . ',' . $type . ')"><i class="fa fa-times"></i></a>';
                        if($type == 1)
                            $actions = '<a class="btn btn-circle btn-icon-only default replacement-edit" 
                            data-description="' . $item->description . '" data-id="' . $item->id .'">
                            <i class="fa fa-edit"></i></a>' . $actions;
                        return $actions;
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
    }

    /*Store and update replacement or store observation*/
    public function saveReplacementObservation(Request $request, $type)
    {
        if(!$request->ajax())
            return response()->json([
                'errorrs' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors('Acción no autorizada.')->render()
            ]);

        $data = $request->all();

        $validator = $this->replacementObvservationValidations($data);

        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

        $obj = null;
        $action = 1; //1. save, 2. update
        try {
            if($type == 1) {
                $replacement_id = $request->replacement_id;
                if(is_null($replacement_id))
                    $obj = Replacement::create($data);
                else {
                    Replacement::find($replacement_id)->fill($data)->update();
                    $action = 2;
                }
            } else
                $obj = Observation::create($data);
        } catch(\Exception $e) {
            return response()->json([
                'errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render() 
            ]);
        }

      $type_name = $type == 1 ? 'Reemplazo' : 'Observación';
      return response()->json([
        'errors' => false,
        'action' => 2,
        'obj' => $obj,
        'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
        ->with('success_message', $type_name . ($action == 1 ? ' guardado' : ' actualizado') . ' correctamente.')->render()
      ]);
    }

    private function replacementObvservationValidations($data)
    {
        $messages = [
            'description.required' => 'El campo descripción es requerido.',
        ];
        
        $validator = Validator::make($data, [
            'description' => 'required',
        ], $messages);

        return $validator;
    }

    public function deleteReplacementObservation(Request $request, $id, $type)
    {
        $type_name = 'Reemplazo';
        try {
            if($type == 1)
                Replacement::destroy($id);
            else {
                Observation::destroy($id);
                $type_name = 'Observación';
            }
        } catch(\Exception $e) {
            return response()->json([
                'errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render() 
            ]);
        }

      return response()->json([
        'errors' => false,
        'success_fragment' => \View::make('inbox.set_edition_modal_tabs.success_message')
        ->with('success_message', $type_name . ' eliminado correctamente.')->render()
      ]);
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
        //
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
