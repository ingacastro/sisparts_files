<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Message;
use IParts\Language;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('message.index');
    }

    public function getList(Request $request)
    {
        if($request->ajax()) {
            return Datatables::of(Message::query())
                  ->addColumn('actions', function($message) {
                    return '<a href="/message/'. $message->id . '/edit" class="btn btn-circle btn-icon-only default"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-circle btn-icon-only red"
                            onclick="deleteModel(event, ' . $message->id . ')"><i class="fa fa-times"></i></a>';
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
        $selects_options = $this->formSelectsOptions();
        $is_create = true;
        return view('message.create_update', compact('selects_options', 'is_create'));
    }

    private function formSelectsOptions()
    {
        return [
            'messages' => Message::all(),
            'languages' => Language::pluck('name', 'id')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message_data = $request->all();
        $is_edit = isset($message_data['id']);
        $action = $is_edit ? 'actualizado' : 'guardado';

        try {
            if($is_edit)
                Message::find($message_data['id'])->fill($message_data)->update();

            $request->session()->flash('message', 'Mensaje ' . $action . ' correctamente.');
            return redirect()->route('message.index');
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
        $selects_options = $this->formSelectsOptions();
        $is_create = false;
        return view('message.create_update', compact('selects_options', 'is_create'));
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
