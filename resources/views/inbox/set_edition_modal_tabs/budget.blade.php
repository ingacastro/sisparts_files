<div class="row modal-content-row">
    <div class="col-md-8">
        {!! Form::open(['route' => ['inbox.update-set-budget', $set->documents_id . '_' . $set->supplies_id], 
        'method' => 'post', 'id' => 'edit_budget_form']) !!}
        <input type="hidden" id="set_id" value="{{ $set->documents_id . '_' . $set->supplies_id }}">
        <div class="row modal-content-border">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            {!! Form::select('set[suppliers_id]', $suppliers, $set->suppliers_id, ['class' => 'form-control',
                            'placeholder' => 'Proveedor...']) !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::select('set[currencies_id]', $currencies, $set->currencies_id, ['class' => 'form-control',
                            'placeholder' => 'Moneda...']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('set[sale_unit_cost]', $set->sale_unit_cost, ['class' => 'form-control currency-mask', 'placeholder' => 'Costo unitario']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('set[importation_cost]', $set->importation_cost, ['class' => 'form-control currency-mask', 'placeholder' => 'Importación']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('set[warehouse_shipment_cost]', $set->warehouse_shipment_cost, ['class' => 'form-control currency-mask', 'placeholder' => 'Envío al almacen']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('set[customer_shipment_cost]', $set->customer_shipment_cost, ['class' => 'form-control currency-mask', 'placeholder' => 'Envío al cliente']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('set[extra_charges]', $set->extra_charges, ['class' => 'form-control currency-mask', 'placeholder' => 'Gastos extra']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('set[notes]', $set->notes, ['class' => 'form-control', 'placeholder' => 'Notas']) !!}
                        </div>
                    </div>
                </div>
                <h5 class="form-section">Peso voulmen *kg</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[cm1]', $measurement->cm1, ['class' => 'form-control numeric-mask', 'placeholder' => 'cm']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[cm2]', $measurement->cm2, ['class' => 'form-control numeric-mask', 'placeholder' => 'cm']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[cm3]', $measurement->cm3, ['class' => 'form-control numeric-mask', 'placeholder' => 'cm']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[kgs]', $measurement->kgs, ['class' => 'form-control numeric-mask', 'placeholder' => 'kgs']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[in1]', $measurement->in1, ['class' => 'form-control numeric-mask', 'placeholder' => 'in']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[in2]', $measurement->in2, ['class' => 'form-control numeric-mask', 'placeholder' => 'in']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('measurement[in3]', $measurement->in3, ['class' => 'form-control numeric-mask', 'placeholder' => 'in']) !!}
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
                                    {!! Form::select('set[source_country_id]', $countries, $set->source_country_id, ['class' => 'form-control', 'placeholder' => 'País de origen...']) !!}
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
                                            {{ $utility_percentage->id == $set->utility_percentages_id ? 'checked' : '' }}> 
                                            {{ $utility_percentage->name }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::text(null, $set->custom_utility_percentage == 0 ? null : $set->custom_utility_percentage, 
                                        ['class' => 'form-control numeric-mask', 'id' => 'custom_utility_percentage', 'autocomplete' => 'off']) !!}
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
            <button type="submit" class="btn btn-circle blue">Guardar</button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-4">
        @include('inbox.set_edition_modal_tabs.includes.checklist')
    </div>
</div>
