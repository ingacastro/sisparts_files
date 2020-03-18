<?php $set_edit_inputs_status = $set->document->status < 3 ? null : 'disabled' ?>
<div class="row modal-content-row">
    <div class="col-md-12">
        {!! Form::open(['route' => ['inbox.update-set-budget', $set->documents_id . '_' . $set->id], 
        'method' => 'post', 'id' => 'edit_budget_form']) !!}
        <input type="hidden" id="set_id" value="{{ $set->documents_id . '_' . $set->id }}">
        <div class="row modal-content-border">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            {!! Form::select('set[suppliers_id]', $suppliers, $set->suppliers_id, ['class' => 'form-control',
                                'style' => 'width: 100%', 'id' => 'budget_tab_suppliers_select', 
                                'placeholder' => 'Proveedor...', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::select('set[currencies_id]', $currencies, $set->currencies_id, ['class' => 'form-control',
                            'placeholder' => 'Moneda...', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sale_unit_cost">Costo unitario</label>
                            {!! Form::text('set[sale_unit_cost]', $set->sale_unit_cost, ['class' => 'form-control currency-mask', 'id' => 'sale_unit_cost', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="importation_cost">Importación</label>
                            {!! Form::text('set[importation_cost]', $set->importation_cost, ['class' => 'form-control currency-mask', 'id' => 'importation_cost', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="warehouse_shipment_cost">Envío al almacen</label>
                            {!! Form::text('set[warehouse_shipment_cost]', $set->warehouse_shipment_cost, ['class' => 'form-control currency-mask', 'id' => 'warehouse_shipment_cost', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customer_shipment_cost">Envío al cliente</label>
                            {!! Form::text('set[customer_shipment_cost]', $set->customer_shipment_cost, ['class' => 'form-control currency-mask', 'id' => 'customer_shipment_cost', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="extra_charges">Gastos extra</label>
                            {!! Form::text('set[extra_charges]', $set->extra_charges, ['class' => 'form-control currency-mask', 'id' => 'extra_charges', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">Notas</label>
                            {!! Form::text('set[notes]', $set->notes, ['class' => 'form-control', 'id' => 'notes', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="form-section" style="font-weight: bold">Medidas y peso</h4>
                    </div>
                    <div class="col-md-6">
                        <?php
                            $measurement_unit  = '';
                            $measurement_length = '';
                            $measurement_width = '';
                            $measurement_height = '';
                            $measurement_weight = '';
                            $measurement_real_weight = '';

                            if($measurement) {
                                $measurement_unit = $measurement->unit;
                                $measurement_length = $measurement->length;
                                $measurement_width = $measurement->width;
                                $measurement_height = $measurement->height;
                                $measurement_weight = $measurement->weight;
                                $measurement_real_weight = $measurement->real_weight;
                            }

                            $cm_checked = 'checked';
                            $in_checked = '';
                            if($measurement_unit == 1) {
                                $cm_checked = 'checked';    
                                $in_checked = '';
                            } else if($measurement_unit == 2) {
                                $cm_checked = '';    
                                $in_checked = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="measurement[unit]" class="budget-measurement-unit" value="1" 
                                    {{$cm_checked . ' ' . $set_edit_inputs_status}}> Centimetros </label>
                                <label class="radio-inline">
                                    <input type="radio" name="measurement[unit]" class="budget-measurement-unit" value="2" 
                                    {{$in_checked . ' ' . $set_edit_inputs_status}}> Pulgadas </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if(!isset($set_edit_inputs_status))
                        <div class="btn-group-circle btn-group-sm btn-group-solid pull-right">
                            <button type="button" id="calculate_volumetric_weight" class="btn btn-circle green-meadow">Calcular</button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 measurements-weight-fields" style="padding-left: 15px">
                        <div class="form-group">
                            <label for="measurement_length'">Largo</label>
                            {!! Form::text('measurement[length]', $measurement_length, ['class' => 'form-control numeric-mask', 
                            'id' => 'measurement_length', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 measurements-weight-fields">
                        <div class="form-group">
                            <label for="measurement_width']">Ancho</label>
                            {!! Form::text('measurement[width]', $measurement_width, ['class' => 'form-control numeric-mask', 
                            'id' => 'measurement_width', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 measurements-weight-fields">
                        <div class="form-group">
                            <label for="measurement_height">Alto</label>
                            {!! Form::text('measurement[height]', $measurement_height, ['class' => 'form-control numeric-mask', 
                            'id' => 'measurement_height', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                    <div class="col-md-6" style="width: 40%">
                        <div class="form-group">
                            <label for="measurement_vol_weight">Peso volumétrico (Kg)</label>
                            {!! Form::text(null, $measurement_weight, ['class' => 'form-control numeric-mask', 
                            'id' => 'measurement_vol_weight', 'disabled']) !!}
                            <input type="hidden" name="measurement[weight]" id="measurement_vol_weight_hidden">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="real_weight">Peso real (Kg)</label>
                            {!! Form::text('measurement[real_weight]', $measurement_real_weight, ['class' => 'form-control', 'id' => 'real_weight', $set_edit_inputs_status]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12">                            
                                <div class="form-group">
                                    {!! Form::select('set[source_country_id]', $countries, $set->source_country_id, ['class' => 'form-control', 'placeholder' => 'País de origen...', $set_edit_inputs_status]) !!}
                                </div>
                            </div>                          
                        </div>
                        <div class="row">
                            <div class="col-md-12">                            
                                <h5 class="form-section">Porcentaje de utilidad: </h4>
                                <div class="form-group">
                                    <div class="radio-list">
                                        @foreach($utility_percentages as $utility_percentage)
                                        <label>
                                            <input type="radio" id="utility_checkbox_{{ $utility_percentage->id }}" 
                                            name="utility_percentage" 
                                            value="{{ $utility_percentage->id }}_{{ $utility_percentage->percentage }}"
                                            {{ $utility_percentage->id == $set->utility_percentages_id ? 'checked' : '' }}
                                            {{' ' . $set_edit_inputs_status}}> 
                                            {{ $utility_percentage->name }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::text(null, $set->custom_utility_percentage == 0 ? null : $set->custom_utility_percentage, 
                                        ['class' => 'form-control numeric-mask', 'id' => 'custom_utility_percentage', 'autocomplete' => 'off',
                                        $set_edit_inputs_status]) !!}
                                </div>
                            </div>                          
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div style="background: #f1f4f7;">  
                            <table class='table borderless'>
                                <thead>
                                    <tr>
                                        <th><td></td></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Costo total: </td>
                                    </tr>
                                    <tr>
                                        <td id="budget_total_cost" class="budget-currency-data detail-title"></td>
                                    </tr>
                                    <tr>
                                        <td>Precio total: </td>
                                    </tr>
                                    <tr>
                                        <td id="budget_total_price" class="budget-currency-data detail-title"></td>
                                    </tr>
                                    <tr>
                                        <td>Precio unitario: </td>
                                    </tr>
                                    <tr>
                                        <td id="budget_unit_price" class="budget-currency-data detail-title"></td>
                                    </tr>
                                    <tr>
                                        <td>Ganancia total: </td>
                                    </tr>
                                    <tr>
                                        <td id="budget_total_profit" class="budget-currency-data detail-title"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-circle default" id="close_set_edition_modal" data-dismiss="modal">Cerrar</button>
            @if(!isset($set_edit_inputs_status) && Auth::user()->hasRole('Cotizador') || Auth::user()->hasRole('Administrador') && !$set->status == 8)
            <button type="submit" class="btn btn-circle blue" id="buttonBudgetSave">Guardar</button>
            @endif
        </div>
        {!! Form::close() !!}
    </div>
</div>
