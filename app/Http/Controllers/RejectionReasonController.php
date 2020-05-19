<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use IParts\RejectionReason;
use Illuminate\Support\Facades\Log;
use IParts\Http\Requests\RejectionReasonRequest;
use Session;

class RejectionReasonController extends Controller
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
        return view('rejection_reason.index');
    }

    public function getList(Request $request)
    {   
        if($request->ajax()) {

            $rejection_reasons = RejectionReason::all();

            return Datatables::of($rejection_reasons)
                  ->addColumn('actions', function($reject_reason) {
                    return '<a href="' . config('app.url') . '/rejection-reason/'. $reject_reason->id . '/edit" class="btn btn-circle btn-icon-only default"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-circle btn-icon-only red"
                            onclick="deleteModel(event, ' . $reject_reason->id . ')"><i class="fa fa-times"></i></a>';
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
        $model = new RejectionReason();
        return view('rejection_reason.create_edit', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RejectionReasonRequest $request)
    {
        try {
            RejectionReason::create($request->all());
            $request->session()->flash('message', 'Motivo de rechazo creado correctamente.');
            return redirect()->route('rejection-reason.index');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
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
        $model = RejectionReason::find($id);
        return view('rejection_reason.create_edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RejectionReasonRequest $request, $id)
    {
        try {
            RejectionReason::find($id)->update($request->all());
            $request->session()->flash('message', 'Motivo de rechazo actualizado correctamente.');
            return redirect()->route('rejection-reason.index');
        }catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
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
            $reject_reason = RejectionReason::find($id);
            /*
            if($reject_reason->rejections->count() > 0) {
                back()->withErrors('El motivo de rechazo no puede ser eliminado, por que está siendo usado en algunas partidas.');
                return;
            }
            */
            $reject_reason->delete();
            Session::flash('message', 'Motivo de rechazo eliminado correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
    }
}
