<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="business_name">Razón social</label>
                {!! Form::text('business_name', $model->business_name, ['class' => 'form-control', 'id' => 'business_name', 
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for=""><span class="required">* </span>Tipo de proveedor</label>
                {!! Form::select('type', [1 => 'Persona física', 2 => 'Persona moral', 3 => 'Extranjero'], $model->type, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'type']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Estado</label>
                {!! Form::select('states_id', $states, $model->states_id, ['class' => 'form-control', 'id' => 'states_id',
                'placeholder' => 'Seleccionar...', 'style' => 'display: none', 'disabled']) !!}
                {!! Form::text('state', $model->state, ['class' => 'form-control', 'style' => 'display: none',
                'id' => 'state_name', 'autocomplete' => 'off', 'disabled']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="rfc">RFC</label>
                {!! Form::text('rfc', $model->rfc, ['class' => 'form-control', 'id' => 'rfc',
                'maxlength' => '13', 'style' => 'text-transform: uppercase', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="city">Ciudad</label>
                {!! Form::text('city', $model->city, ['class' => 'form-control', 'id' => 'city', 
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="post_code"><span class="required">* </span>Código postal</label>
                {!! Form::text('post_code', $model->post_code, ['class' => 'form-control integer-mask', 'id' => 'post_code',
                'maxlength' => '5', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="street">Calle</label>
                {!! Form::text('street', $model->street, ['class' => 'form-control', 'id' => 'street', 
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="contact_name">Contacto</label>
                {!! Form::text('contact_name', $model->contact_name, ['class' => 'form-control', 'id' => 'contact_name', 
                'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="street_number">Número exterior</label>
                        {!! Form::text('street_number', $model->street_number, ['class' => 'form-control', 'id' => 'street_number', 
                        'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="unit_number">Número interior</label>
                        {!! Form::text('unit_number', $model->unit_number, ['class' => 'form-control', 'id' => 'unit_number', 
                        'autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="credit_days">Días de crédito</label>
                {!! Form::text('credit_days', $model->credit_days, ['class' => 'form-control integer-mask', 'id' => 'credit_days', 
                'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="suburb">Colonia</label>
                {!! Form::text('suburb', $model->suburb, ['class' => 'form-control', 'id' => 'suburb', 
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="credit_amount">Monto de credito</label>
                {!! Form::text('credit_amount', $model->credit_amount, ['class' => 'form-control currency-mask', 
                'id' => 'credit_amount', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('supplier.index') }}" class="btn btn-circle default">{{ $cancel_btn }}</a>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>
