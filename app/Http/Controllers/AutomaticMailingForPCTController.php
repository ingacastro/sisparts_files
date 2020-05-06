<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\NumberOfAutomaticEmail;
class AutomaticMailingForPCTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quantity = NumberOfAutomaticEmail::find(1);
        return view('automatic-emails.index', compact('quantity'));
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
        if (! $request->ajax())
            abort(403, 'Unauthorized action.');

        NumberOfAutomaticEmail::where('id', 1)->update([
            'quantity' => $request->input('quantity')
        ]);
        
        return response()->json([
            'mensaje' => 'Cantidad actualizada correctamente',
            'quantity' => $request->input('quantity')
        ]);
    }
}
