<div class="row modal-content-row">
    <div class="col-md-8">
        {!! Form::open(['route' => ['inbox.update-set-conditions', $set->id], 'method' => 'post', 'id' => 'edit_conditions_form']) !!}
        <input type="hidden" id="conditions_id" value="{{ $set->id }}">
        <div class="row modal-content-border">
            <div class="col-md-6 checklist-container">
                <div class="form-group">
                    <div class="radio-list">
                        <label>
                            <input type="checkbox" {{ $set_conditions->previous_sale == $conditions->previous_sale ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="previous_sale" class="condition-checkbox"> Salvo previa venta
                            {!! Form::text('previous_sale', $set_conditions->previous_sale, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'previous_sale_input']) !!}
                        </label>
                        <label>
                            <input type="checkbox" {{ $set_conditions->valid_prices == $conditions->valid_prices ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="valid_prices" class="condition-checkbox"> Precios válidos
                            {!! Form::text('valid_prices', $set_conditions->valid_prices, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'valid_prices_input']) !!}
                        </label>
                        <label>
                            <input type="checkbox" {{ $set_conditions->replacement == $conditions->replacement ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="replacement" class="condition-checkbox"> Remplazo
                            {!! Form::text('replacement', $set_conditions->replacement, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'replacement_input']) !!}
                        </label>
                        <label>
                            <input type="checkbox" {{ $set_conditions->factory_replacement == $conditions->factory_replacement ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="factory_replacement" class="condition-checkbox"> Remplazo de fabrica
                            {!! Form::text('factory_replacement', $set_conditions->factory_replacement, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'factory_replacement_input']) !!}
                        </label>
                        <label>
                            <input type="checkbox" {{ $set_conditions->condition == $conditions->condition ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="condition" class="condition-checkbox"> Condición: USADO
                            {!! Form::text('condition', $set_conditions->condition, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'condition_input']) !!}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 checklist-container">
                <div class="form-group">
                    <div class="radio-list">
		                <label>
		                    <input type="checkbox" {{ $set_conditions->minimum_purchase == $conditions->minimum_purchase ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="minimum_purchase" class="condition-checkbox"> Mínimo de compra
		                    {!! Form::text('minimum_purchase', $set_conditions->minimum_purchase, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'minimum_purchase_input']) !!}
		                </label>
		                <label>
		                    <input type="checkbox" {{ $set_conditions->exworks == $conditions->exworks ? 'checked' : ''}}
                            data-id="{{ $conditions->id }}" data-field="exworks" class="condition-checkbox"> Ex-works
		                    {!! Form::text('exworks', $set_conditions->exworks, ['class' => 'form-control', 'placeholder' => '',
                            'id' => 'exworks_input']) !!}
		                </label>
		                <label>
		                	<input type="checkbox" style="visibility: hidden;">
		                	{!! Form::textarea('description', $set_conditions->description, ['class' => 'form-control', 'style' => 'resize: vertical; height: 155px',
		                	'placeholder' => 'Descripción...']) !!}
		                </label>
					</div>
				</div>
            </div>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-circle blue">Guardar</button>
        </div>
        {!! Form::close() !!}
    </div>
    {{-- An admin user and set status as in authorization or set status as budget registered or rejected status --}}
    @if((Auth::user()->hasRole('Administrador') && $set->status == 6) || (Auth::user()->hasRole('Cotizador') && ($set->status == 5 || $set->status == 7)))
    <div class="col-md-4">
        @include('inbox.set_edition_modal_tabs.includes.checklist')
    </div>
    @endif
</div>