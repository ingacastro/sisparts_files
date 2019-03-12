<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Message;
use IParts\Language;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use DB;
use Validator;

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

            $messages = Message::select('id', 'messages_languages.title', 'messages_languages.subject', 
            'messages_languages.body')
            ->join('messages_languages', 'messages_languages.messages_id', 'messages.id')
            ->where('languages_id', DB::raw("(select id from languages where name = 'Español')"))
            ->get();
            
            return Datatables::of($messages)
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
        return view('message.create_update', compact('selects_options'));
    }

/*    private function formSelectsOptions()
    {
        return [
            'messages' => Message::all(),
            'languages' => Language::pluck('name', 'id')
        ];
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message_data = $request->all();
        

        try {
            $request->session()->flash('message', 'Mensaje ' . $action . ' correctamente.');
            return redirect()->route('message.index');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        
    }

    private function messageValidations($message_data)
    {
        $messages = [
            'title.required' => 'El título es requerido.',
            'subject.required' => 'El asunto es requerido.'
        ];
        
        $validator = Validator::make($message_data, [
            'title' => 'required',
            'subject' => 'required'
        ], $messages);

        return $validator;
/*        
        if($validator->fails())
            return array('errors' => true, 'validator' => $validator);
        
        return array('errors' => false, 'data' => $setting_data);*/
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
        $message = Message::find($id);
        $languages = $message->languages;
        return view('message.create_update', compact('message', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $language_id)
    {
        //Log::notice($request->all());
        
        $data = $request->except('_method', '_token');
        $validator = $this->messageValidations($data);

        if($validator->fails())
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($validator)->render()]);

        try{
            $message = Message::find($data['messages_id']);
            $message->languages()->updateExistingPivot($language_id, $data);
            $request->session()->flash('message', 'Mensaje actualizado correctamente.');
        } catch(\Exception $e) {
            return response()->json(
                ['errors' => true,
                'errors_fragment' => \View::make('layouts.admin.includes.error_messages')
                ->withErrors($e->getMessage())->render()]);
        }
        
        return response()->json(['errors' => false]);
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
