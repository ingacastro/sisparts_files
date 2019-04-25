{!! Form::open(['route' => ['inbox.update-set-budget', $set->documents_id . '_' . $set->supplies_id], 'method' => 'post', 'id' => 'edit_budget_form']) !!}
    <input type="hidden" id="set_id" value="{{ $set->documents_id . '_' . $set->supplies_id }}">
    <div class="row modal-content-row">
        <div class="col-md-8">
            <div class="row modal-content-border">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                {!! Form::select('set[manufacturers_id]', $manufacturers, $set->manufacturers_id, ['class' => 'form-control']) !!}
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
        </div>
        <div class="col-md-4">
            <div class="row modal-content-border" style="background: #f1f4f7;">
                <div class="col-md-12 checklist-container">                            
                    <h4 class="form-section">Checklist</h4>
                    <div class="form-group">
                        <div class="radio-list">
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar especificaciones del material
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar cantidades cotizadas
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar moneda de la cotización
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar el precio unitario
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar el tiempo de entrega
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar las condiciones de entrega
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar la condición del producto
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar costos de flete entrada
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar cálculo del peso
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar procedencia del material
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar incoterm
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar mínimo de compra
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                            <label>
                                <input type="checkbox" name="" id="" value="1"> Revisar gastos extra
                                <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="checklist-buttons-container">
                        <button type="submit" class="btn btn-circle btn-sm green-meadow">Aprobar</button>
                        <button type="button" class="btn btn-circle btn-sm yellow">Rechazar</button>
                    </div>
                </div>                          
            </div>
        </div>
    </div>
    <div class="modal-footer" style="text-align: center;">
        <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-circle blue">Guardar</button>
    </div>
{!! Form::close() !!}