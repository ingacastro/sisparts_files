<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Selectlistauth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

class SelectlistauthController extends Controller
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
        return view('selectlistauth.index');
    }

    public function getList(Request $request)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $supps = Selectlistauth::All();

        $i = 0;

        return Datatables::of($supps)
              ->addColumn('actions', function($supplier) {

                $actions = '<a href="' . config('app.url') . '/selectlistauth/'. $supplier->id . '/edit" class="btn btn-circle btn-icon-only default edit-selectlistauth">
                        <i class="fa fa-edit"></i></a>';
                        
                $actions .= Auth::user()->hasRole('Administrador') ? '<button class="btn btn-circle btn-icon-only red"
                        onclick="deleteModel(event, ' . $supplier->id . ')"><i class="fa fa-times"></i></button>'
                        : '';
                return $actions;
              })
              ->addColumn('id', function($supplier) {
                global $i;
                $i++;
                return $i;
              })
              ->rawColumns(['actions' => 'actions','id' => 'id'])
              ->make(true);        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Selectlistauth();
        $states = [];
        return view('selectlistauth.create', compact(
            'model', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = null;
        $supp_data = $request->all();

        try {
            $model = Selectlistauth::create([
                'name'            => $request->name,
                'status'          => $request->status,
            ]);
            
            $request->session()->flash('message', 'Item guardado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('selectlistauth.index');
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
        $model = Selectlistauth::find($id);
        return view('selectlistauth.update', compact(
            'model'));
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
        $data = [
            'name'            => $request->name,
            'status'          => $request->status
        ];

        try {
            $model = Selectlistauth::find($id);
            $model->fill($data)->update();
            $request->session()->flash('message', 'Item actualizado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('selectlistauth.index');
    }

    public function updated(Request $request)
    {
        $data = [
            'name'            => $request->name,
            'status'          => $request->status,
        ];

        $id = $request->id;

        try {
            $model = Selectlistauth::find($id);
            $model->fill($data)->update();
            $request->session()->flash('message', 'Item actualizado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('selectlistauth.index');
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
            $supp = Selectlistauth::destroy($id);
            Session::flash('message', 'Item eliminado correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
    }
}
