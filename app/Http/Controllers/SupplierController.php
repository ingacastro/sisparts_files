<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Supplier;
use IParts\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Session;
use IParts\Manufacturer;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

class SupplierController extends Controller
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
       /* dd(Supplier::select('suppliers.id', 'users.name AS user', 'trade_name', 'business_name', 
        'countries.name as country', 'suppliers.rfc', 'suppliers.email', 'suppliers.landline', 'suppliers.contact_name',
        DB::raw("GROUP_CONCAT(manufacturers.name) as brands"))
    ->leftJoin('countries', 'countries.id', 'suppliers.countries_id')
    ->leftJoin('users', 'users.id', 'suppliers.user_id')
    ->leftJoin('suppliers_manufacturers', 'suppliers.id', 'suppliers_manufacturers.suppliers_id')
    ->leftJoin('manufacturers', 'suppliers_manufacturers.manufacturers_id', 'manufacturers.id')
    ->orderBy('suppliers.created_at', 'DESC')
    ->groupBy('suppliers.id')->get());
    */
        return view('supplier.index');
    }

    public function getList(Request $request)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $supps = Supplier::select('suppliers.id', 'users.name AS user', 'trade_name', 'business_name', 
        'countries.name as country', 'suppliers.rfc', 'suppliers.email', 'suppliers.landline', 'suppliers.contact_name',
        DB::raw("GROUP_CONCAT(manufacturers.name) as brands"))
    ->leftJoin('countries', 'countries.id', 'suppliers.countries_id')
    ->leftJoin('users', 'users.id', 'suppliers.user_id')
    ->leftJoin('suppliers_manufacturers', 'suppliers.id', 'suppliers_manufacturers.suppliers_id')
    ->leftJoin('manufacturers', 'suppliers_manufacturers.manufacturers_id', 'manufacturers.id')
    ->orderBy('suppliers.created_at', 'DESC')
    ->groupBy('suppliers.id');

        return Datatables::of($supps)
              ->addColumn('actions', function($supplier) {

                $actions = '<a data-toggle="modal" data-id="' . $supplier->id .'" href="#brands_modal" 
                        class ="btn btn-circle btn-icon-only green show-brands"><i class="fa fa-eye"></i></a>
                        <a href="' . config('app.url') . '/supplier/'. $supplier->id . '/edit" class="btn btn-circle btn-icon-only default edit-supplier">
                        <i class="fa fa-edit"></i></a>';
                        
                $actions .= Auth::user()->hasRole('Administrador') ? '<button class="btn btn-circle btn-icon-only red"
                        onclick="deleteModel(event, ' . $supplier->id . ')"><i class="fa fa-times"></i></button>'
                        : '';
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
        $model = new Supplier();
        $states = [];
        $selects_options = $this->formSelectsOptions();
        return view('supplier.create_update', compact(
            'model', 'selects_options', 'states'));
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
            $model = Supplier::create($supp_data);
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
        $states = DB::table('states')->pluck('name', 'id');
        $selects_options = $this->formSelectsOptions();
        return view('supplier.create_update', compact(
            'model', 'selects_options', 'states'));
    }

    public function getModelBrands(Request $request, $id)
    {
        if($request->ajax()) {
            $brands = Supplier::find($id)->brands;
            return Datatables::of($brands)
                  ->addColumn('actions', function($brand) {
                    return (Auth::user()->hasRole('Administrador')) ? '<a class="remove-brand" id="' . $brand->id . '">Eliminar</a>' : '';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
    }

    public function getBrandsKeyVal(Request $request)
    {
        $brands = Manufacturer::select('id', 'name as text')
        ->where('name', 'like', '%' . $request->get('term') . '%')->get();
        return response()->json($brands);
    }

    /*Creates a new brand or simply returns the brand received*/
    public function createBrand(Request $request)
    {
        $brand = Manufacturer::find($request->get('value'));
        if(is_null($brand)) $brand = Manufacturer::create(['name' => $request->get('value')]);
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

        return redirect()->route($request->get('redirect_to'), $supp_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $data = $request->all();
        if(!$request->has('marketplace')) $data['marketplace'] = 0;

        $data['states_id'] = $data['states_id'] ?? null;
        $data['state'] = $data['state'] ?? null;

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
        try {
            $supp = Supplier::destroy($id);
            Session::flash('message', 'Proveedor eliminado correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
    }

    public function ajaxstore(SupplierRequest $request)
    {
        $model = null;
        $supp_data = $request->all();
        $doc = explode('_', $request['manufacturer']);

        if(!$request->has('marketplace')) $supp_data['marketplace'] = 0;

        try {
            $model = Supplier::create($supp_data);
            $message = 'Proveedor guardado correctamente.';
            $errors  = false;

            $ultimoRegistro = Supplier::all()->last();

            $docsup = DB::table('documents_supplies')->where('id', $doc[1])->get();

            $supplies_id = $docsup[0]->supplies_id;
            $supp = DB::table('supplies')->where('id', $supplies_id)->get();
        
            $manufacturers_id = $supp[0]->manufacturers_id;
            Supplier::find($ultimoRegistro->id)->brands()->sync($manufacturers_id);


            return response()->json(['message' => $message, 'errors' => $errors]);
        } catch(\Exception $e) {
            $message = 'Proveedor no pudo ser guardado.';
            $errors  = true;
            return response()->json(['message' => $message, 'errors' => $errors]);
        }
    }

    public function checksupplier(Request $request)
    {
      $doc = explode('_', $request['document']);

      try {
        $docsup = DB::table('documents_supplies')->where('id', $doc[1])->get();

        $supplies_id = $docsup[0]->supplies_id;
        $supp = DB::table('supplies')->where('id', $supplies_id)->get();
        
        $manufacturers_id = $supp[0]->manufacturers_id;


        $existe = DB::table('suppliers_manufacturers')
          ->where('manufacturers_id', $manufacturers_id)
          ->where('suppliers_id', $request['id'])
          ->get();
        
        if (isset($existe[0])) {
          return response()->json(['message' => 1]);
        }

        return response()->json(['message' => 0]);

      } catch (Exception $e) {
        return response()->json(['message' => 0]);
      }
    }
}
