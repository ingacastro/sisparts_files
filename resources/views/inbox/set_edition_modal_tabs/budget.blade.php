<div class="row modal-content-row">
    <div class="col-md-8">
        <div class="row modal-content-border">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            {!! Form::select('manufacturers_id', $manufacturers, null, ['class' => 'form-control', 'id' => 'dealerships_select2', 'style' =>'width: 100%', 'placeholder' => 'Proveedor elegido...']) !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::select('employees_users_id', [], null, ['class' => 'form-control', 'id' => 'dealerships_select2',
                            'style' =>'width: 100%', 'placeholder' => 'Moneda...']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control currency-mask', 'placeholder' => 'Costo unitario']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control currency-mask', 'placeholder' => 'Importación']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control currency-mask', 'placeholder' => 'Envío al almacen']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control currency-mask', 'placeholder' => 'Envío al cliente']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control currency-mask', 'placeholder' => 'Gastos extra']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => 'Notas']) !!}
                        </div>
                    </div>
                </div>
                <h5 class="form-section">Peso voulmen *kg</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'cm']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'cm']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'cm']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'kgs']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'in']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'in']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('wtv', null, ['class' => 'form-control numeric-mask', 'placeholder' => 'in']) !!}
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
                                    {!! Form::select('employees_users_id', [], null, ['class' => 'form-control', 'id' => 'dealerships_select2',
                                    'style' =>'width: 100%', 'placeholder' => 'País de origen...']) !!}
                                </div>
                            </div>                          
                        </div>
                        <div class="row">
                            <div class="col-md-12">                            
                                <h5 class="form-section">Porcentaje de utilidad: </h4>
                                <div class="form-group">
                                    <div class="radio-list">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1"> Nacional
                                        </label>
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Internacional
                                        </label>
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Remplazo
                                        </label>
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Pieza usada
                                        </label>
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Otro
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::text('wtv', null, ['class' => 'form-control']) !!}
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
                                        <td>
                                            Costo total: 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="budget-currency-data detail-title">
                                            $ 0.00 USD
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Precio total: 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="budget-currency-data detail-title">
                                            $ 0.00 USD
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Precio unitario: 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="budget-currency-data detail-title">
                                            $ 0.00 USD
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Ganancia total: 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="budget-currency-data detail-title">
                                            $ 0.00 USD
                                        </td>
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