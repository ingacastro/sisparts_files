<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use IParts\Supply;
use DB;

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
                    return '<a href="/supply/'. $supply->id . '/edit" class="btn btn-circle btn-icon-only default"><i class="fa fa-edit"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
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
