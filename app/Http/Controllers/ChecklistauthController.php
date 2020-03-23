<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Checklistauth;
//use IParts\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Session;
//use IParts\Manufacturer;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

class ChecklistauthController extends Controller
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
        return view('checklistauth.index');
    }

    public function getList(Request $request)
    {
        if(!$request->ajax()) abort(403, 'Unauthorized action');

        $supps = Checklistauth::All();

        $i = 0;

        return Datatables::of($supps)
              ->addColumn('actions', function($supplier) {

                $actions = '<a href="' . config('app.url') . '/checklistauth/'. $supplier->id . '/edit" class="btn btn-circle btn-icon-only default edit-checklistauth">
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
        $model = new Checklistauth();
        $states = [];
        return view('checklistauth.create', compact(
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
            $model = Checklistauth::create([
                'name'            => $request->name,
                'help'            => $request->help,
                'status'          => $request->status,
                'checklis_column' => ''
            ]);

            $dato=Checklistauth::All(); 
            $checklistauth=$dato->last();
            $i = $checklistauth->id;
            $id = 'column_'.$checklistauth->id;

            $crearcolumn = DB::unprepared(DB::raw("ALTER TABLE `checklist` ADD `$id` ENUM('','checked') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT ''"));

            $model = Checklistauth::find($i);
            $model->fill([
                'checklist_column' => $id
            ])->update();
            
            $request->session()->flash('message', 'Checklist guardado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('checklistauth.index');
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
        $model = Checklistauth::find($id);
        return view('checklistauth.update', compact(
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
            'help'            => $request->help,
            'status'          => $request->status
        ];

        try {
            $model = Checklistauth::find($id);
            $model->fill($data)->update();
            $request->session()->flash('message', 'Checklist actualizado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('checklistauth.index');
    }

    public function updated(Request $request)
    {
        $data = [
            'name'            => $request->name,
            'help'            => $request->help,
            'status'          => $request->status,
        ];

        $id = $request->id;

        try {
            $model = Checklistauth::find($id);
            $model->fill($data)->update();
            $request->session()->flash('message', 'Checklist actualizado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->route('checklistauth.index');
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
            $supp = Checklistauth::destroy($id);
            Session::flash('message', 'Checklist eliminado correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
    }
}
