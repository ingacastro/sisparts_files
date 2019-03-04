<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Supplier;
use Illuminate\Support\Facades\Log;
use IParts\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Session;
use IParts\Brand;
use Yajra\Datatables\Datatables;
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

    public function getList(Request $request)
    {
        if($request->ajax()) {
            return Datatables::of(Supplier::query())
                  ->addColumn('actions', function($supplier) {
                    return '<a href="/admin/supplier/'. $supplier->id . '/edit" class="btn btn-primary">Edit</a>
                            <a href="/admin/supplier/'. $supplier->id . '" class="btn btn-danger"
                            onclick="deleteSupplier(event, ' . $supplier->id . ')">Delete</a>';
                  })
                  ->rawColumns(['delete' => 'delete','actions' => 'actions'])
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

    public function getBrandsKeyVal(Request $request)
    {
        $brands = Brand::select('id', 'name as text')
        ->where('name', 'like', '%' . $request->get('term') . '%')->get();
        return response()->json($brands);
    }

    /*Creates a new brand or simply returns the brand received*/
    public function createBrand(Request $request)
    {
        $brand = Brand::find($request->get('value'));

        if(is_null($brand)) $brand = Brand::create(['name' => $request->get('value')]);
        
        return response()->json($brand);
    }

    /*Associate every brand received with supplier*/
    public function syncBrands(Request $request)
    {  
        try {
            $supp_id = $request->get('supplier_id');
            $brands = json_decode($request->get('supplier_brands'));
            Supplier::find($supp_id)->brands()->sync($brands);
            $request->session()->flash('message', 'Marcas actualizadas correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('supplier.edit', $supp_id);
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
        $data = $request->all();
        if(!$request->has('marketplace')) $data['marketplace'] = 0;

        try {
            $model = Supplier::find($id);
            $model->fill($data)->update();
            $request->session()->flash('message', 'Proveedor actualizado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('supplier.edit', $model->id);
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
