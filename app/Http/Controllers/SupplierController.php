<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Supplier;
use Illuminate\Support\Facades\Log;
use IParts\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Session;
use DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Supplier();
        $selects_options = $this->formSelectsOptions();
        return view('supplier.create_update', compact(
            'model', 'selects_options'));
    }

    private function formSelectsOptions()
    {
        return [
            'countries' => DB::table('countries')->pluck('name', 'id'),
            'languages' => DB::table('languages')->pluck('name', 'id'),
            'currencies' => DB::table('currencies')->pluck('name', 'id')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $model = null;
        $supp_data = $request->all();

        if(!$request->has('marketplace')) $supp_data['marketplace'] = 0;

        try {
            $model = Supplier::create($request->all());
            $request->session()->flash('message', 'Proveedor guardado correctamente, sección de marcas habilitada.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('supplier.edit', $model->id);
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
        $model = Supplier::find($id);
        $selects_options = $this->formSelectsOptions();
        return view('supplier.create_update', compact(
            'model', 'selects_options'));
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
