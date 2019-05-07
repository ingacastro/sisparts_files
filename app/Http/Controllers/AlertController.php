<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Alert;
use DB;
use Validator;
use Illuminate\Support\Facades\Log;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alert.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Alert();
        $types = [
            1 => 'Cantidad de días desde solicitud PCT',
            2 => 'Una partida cambia de estatus a:'
        ];
        $set_status = DB::table('supplies_sets_status')->pluck('name', 'id');
        return view('alert.create_edit', compact('model', 'types', 'set_status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->formValidations($data);

        if($validator->fails())
            return response()->json(
                        ['errors' => true,
                        'errors_fragment' => \View::make('color_settings.error_messages')
                        ->withErrors($validator)->render()]);
        try {
            Alert::create($data);
            $request->session()->flash('message', 'Alerta creada correctamente.');
        }catch(\Exception $e) {
            return response()->json(
                        ['errors' => true,
                        'errors_fragment' => \View::make('color_settings.error_messages')
                        ->withErrors($e->getMessage())->render()]);
        }

        return response()->json(['errors' => false]);
    }

    private function formValidations($data)
    {
        $exploded_recipients = $data['recipients'] == null ? [] : explode(',', $data['recipients']);
        $data['recipients'] = $exploded_recipients;

        $messages = [
            'title.required' => 'El campo título es requerido.',
            'recipients.required' => 'El campo destinatarios es requerido.',
            'recipients.*' => 'El formato en una o más direcciones de correo es incorrecto.',
            'subject.required' => 'El campo asunto es requerido.',
            'message.required' => 'El campo mensaje es requerido.',
            'type.required' => 'El campo tipo es requerido.',
            'elapsed_days.required' => 'El campo cantidad de días es requerido.',
            'supplies_sets_status_id.required' => 'El campo estatus de partida es requerido.'
        ];
        
        $validator = Validator::make($data, [
            'title' => 'required',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'email',
            'subject' => 'required',
            'message' => 'required',
            'type' => 'required'
        ], $messages);

        $validator->sometimes('elapsed_days', 'required', function($data){
            return $data['type'] == 1;
        });
        $validator->sometimes('supplies_sets_status_id', 'required', function($data){
            return $data['type'] == 2;
        });

        return $validator;
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
