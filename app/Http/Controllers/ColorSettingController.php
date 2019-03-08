<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\ColorSetting;
use IParts\ColorSettingEmail;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Validator;

class ColorSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $color_settings_data = $request->get('settings');

        try {            
            foreach($color_settings_data as $setting_data) {

                $validation_result = $this->settingValidations($setting_data);
                
                if($validation_result['errors']) {
                    return response()->json(
                        ['errors' => true,
                        'errors_fragment' => \View::make('color_settings.error_messages')
                        ->withErrors($validation_result['validator'])->render()]);
                }

                $model = ColorSetting::find($setting_data['id']);
                DB::transaction(function() use ($model, $setting_data){
                    $model->fill($setting_data)->update();
                });
            }
            Session::flash('message', 'Configuración correctamente actualizada.');
        } catch(\Exception $e) {
            return response()->json(
                        ['errors' => true,
                        'errors_fragment' => \View::make('color_settings.error_messages')
                        ->withErrors($e->getMessage())->render()]);
        }

        return response()->json(['errors' => false]);
    }

    private function settingValidations($setting_data)
    {
        $exploded_emails = explode(',', $setting_data['emails']);
        $setting_data['emails'] = $exploded_emails;

        $messages = [
            'days.required' => 'Se debe especificar la cantidad de días en cada campo.',
            'emails.*.email' => 'El formato en una o más direcciones de correo es incorrecto.'
        ];

        $validator = Validator::make($setting_data, [
            'days' => 'required',
            'emails.*' => 'nullable|email'
        ], $messages);
        
        if($validator->fails())
            return array('errors' => true, 'validator' => $validator);
        
        return array('errors' => false, 'data' => $setting_data);
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
    public function edit()
    {
        $color_settings = ColorSetting::all();
        return view('color_settings.edit', compact('color_settings'));
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
