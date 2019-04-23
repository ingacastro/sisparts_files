<div class="row modal-content-row">
    <div class="col-md-8">
        <div class="row modal-content-border">
            <div class="col-md-6 checklist-container">
                <div class="form-group">
                    <div class="radio-list">
                        <label>
                            <input type="checkbox" name="" id="" value="1"> Salvo previa venta
                            {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </label>
                        <label>
                            <input type="checkbox" name="" id="" value="1"> Precios válidos
                            {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </label>
                        <label>
                            <input type="checkbox" name="" id="" value="1"> Remplazo
                            {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </label>
                        <label>
                            <input type="checkbox" name="" id="" value="1"> Remplazo de fabrica
                            {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </label>
                        <label>
                            <input type="checkbox" name="" id="" value="1"> Condición: USADO
                            {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 checklist-container">
                <div class="form-group">
                    <div class="radio-list">
		                <label>
		                    <input type="checkbox" name="" id="" value="1"> Mínimo de compra
		                    {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
		                </label>
		                <label>
		                    <input type="checkbox" name="" id="" value="1"> Ex-works
		                    {!! Form::text('wtv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
		                </label>
		                <label>
		                	<input type="checkbox" style="visibility: hidden;">
		                	{!! Form::textarea('wtv', null, ['class' => 'form-control', 'style' => 'resize: vertical; height: 155px',
		                	'placeholder' => 'Descripción...']) !!}
		                </label>
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