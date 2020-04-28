<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use IParts\Country;
use IParts\Language;
use IParts\currency;
use IParts\GlobalSupplier;
use IParts\Manufacturer;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class GlobalSuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('global-suppliers.index');
    }

    public function getList(){
        $globalSuppliers = DB::table('global_suppliers')->select('global_suppliers.id', 'global_suppliers.name', 'a.name AS country', 'global_suppliers.email', 'b.name AS language', 'global_suppliers.telephone', 'c.name AS currency', 'global_suppliers.phone', 'global_suppliers.marketplace', 'global_suppliers.brokers_pais')
        ->leftJoin('countries AS a', 'global_suppliers.country_id', '=', 'a.id')
        ->leftJoin('languages AS b', 'global_suppliers.language_id', '=', 'b.id')
        ->leftJoin('currencies AS c', 'global_suppliers.currency_id', '=', 'c.id');
        
        return Datatables::of($globalSuppliers)
                ->addColumn('actions', 'global-suppliers.action')
                ->editColumn('brokers_pais', function($globalSupplier){
                    return ($globalSupplier->brokers_pais) ? "Activo" : "Desactivado";
                })
                ->rawColumns(['actions' => 'actions', 'brokers_pais' => 'brokers_pais'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries  = Country::all();
        $languages  = Language::all();
        $currencies = Currency::all();
        return view('global-suppliers.create', compact('countries', 'languages', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'country_id'    => 'required|integer',
            'email'         => 'required|email',
            'language_id'   => 'required|integer',
            'telephone'     => 'required|string',
            'currency_id'   => 'required|integer',
        ], [
            'name.required' => 'Nombre requerido',
            'email.required'=> 'Email requerido',
            'email.email'   => 'Email debe tener formato @dominio.com',
            'telephone.required' => 'Teléfono requerido',
        ]);

        $model = null;
        $supp_data = $request->except(['_token', '_method']);
        
        if(!$request->has('marketplace')) 
            $supp_data['marketplace'] = 0;

        if(!$request->has('brokers_pais')) 
            $supp_data['brokers_pais'] = 0;


        try {
            $model = GlobalSupplier::create($supp_data);
            $request->session()->flash('message', 'Proveedor Brokers guardado correctamente, sección de marcas habilitada.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('global-suppliers.edit', $model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $countries      = Country::all();
        $languages      = Language::all();
        $currencies     = Currency::all();
        $globalSupplier = GlobalSupplier::find($id);

        return view('global-suppliers.show', compact('countries', 'languages', 'currencies', 'globalSupplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries      = Country::all();
        $languages      = Language::all();
        $currencies     = Currency::all();
        $globalSupplier = GlobalSupplier::find($id);
        $manufacturers   = Manufacturer::all();
        $global_supplier_manufacturers = $this->getListGlobalSuppliersManufacturers($id);
        return view('global-suppliers.edit', compact('countries', 'languages', 'currencies', 'globalSupplier', 'manufacturers', 'global_supplier_manufacturers'));
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
        $request->validate([
            'name'          => 'required',
            'country_id'    => 'required|integer',
            'email'         => 'required|email',
            'language_id'   => 'required|integer',
            'telephone'     => 'required|string',
            'currency_id'   => 'required|integer',
        ], [
            'name.required' => 'Nombre requerido',
            'email.required'=> 'Email requerido',
            'email.email'   => 'Email debe tener formato @dominio.com',
            'telephone.required' => 'Teléfono requerido',
        ]);
        $model = null;
        $supp_data = $request->except(['_token', '_method']);
    
        if(!$request->has('marketplace')) 
            $supp_data['marketplace'] = 0;

        try {
            GlobalSupplier::where('id', $id)->update($supp_data);
            $request->session()->flash('message', 'Proveedor Brokers actualizado correctamente, sección de marcas habilitada.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return back();
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

    public function getListGlobalSuppliersManufacturers($id){
        return DB::table('globals_manufacturers')
            ->select('globals_manufacturers.manufacturer_id', 'manufacturers.id', 'manufacturers.name')
            ->where('global_supplier_id', $id)
            ->leftJoin('manufacturers', 'globals_manufacturers.manufacturer_id', '=', 'manufacturers.id' )
            ->orderBy('globals_manufacturers.created_at', 'DESC')
            ->get();
    }

    public function globalSuppliersManufacturersDelete($id, Request $request){
        if ( ! $request->ajax() )
            abort(403, 'No autorizado');

        DB::table('globals_manufacturers')->where('manufacturer_id', $id)->delete();
    }
    
    public function globalSuppliersManufacturers(Request $request){
        if ( ! $request->ajax() )
                abort(403, 'No autorizado');

        DB::table('globals_manufacturers')->insert([
                    'global_supplier_id'    => $request->input('globalSupplier'),
                    'manufacturer_id'       => $request->input('manufacturer'),
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now() 
                ]);
       
                
        $global_supplier_manufacturers = $this->getListGlobalSuppliersManufacturers($request->input('globalSupplier'));

        return response()->json([
            'resultados' => View::make('global-suppliers.brands', compact('global_supplier_manufacturers'))->render()
        ]);        
    }
}
