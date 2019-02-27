<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="business_name">Razón social</label>
                {!! Form::text('business_name', $model->business_name, ['class' => 'form-control', 'id' => 'business_name']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="">Tipo de proveedor</label>
                {!! Form::select('type', [1 => 'Persona física', 2 => 'Persona moral', 3 => 'Extranjero'], $model->type, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'countries_id']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="states_id">Estado</label>
                {!! Form::select('states_id', [1, 2], $model->states_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'states_id']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="rfc">RFC</label>
                {!! Form::text('rfc', $model->rfc, ['class' => 'form-control', 'id' => 'rfc']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="city">Ciudad</label>
                {!! Form::text('city', $model->city, ['class' => 'form-control', 'id' => 'city']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="post_code">Código postal</label>
                {!! Form::text('post_code', $model->post_code, ['class' => 'form-control', 'id' => 'post_code']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="street">Calle</label>
                {!! Form::text('street', $model->street, ['class' => 'form-control', 'id' => 'street']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="contact_name">Contacto</label>
                {!! Form::text('contact_name', $model->contact_name, ['class' => 'form-control', 'id' => 'contact_name']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="street_number">Número exterior</label>
                        {!! Form::text('street_number', $model->street_number, ['class' => 'form-control', 'id' => 'street_number']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="unit_number">Número interior</label>
                        {!! Form::text('unit_number', $model->unit_number, ['class' => 'form-control', 'id' => 'unit_number']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="credit_days">Días de crédito</label>
                {!! Form::text('credit_days', $model->credit_days, ['class' => 'form-control', 'id' => 'credit_days']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="suburb">Colonia</label>
                {!! Form::text('suburb', $model->suburb, ['class' => 'form-control', 'id' => 'suburb']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="credit_amount">Monto de credito</label>
                {!! Form::text('credit_amount', $model->credit_amount, ['class' => 'form-control', 'id' => 'credit_amount']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <button type="button" class="btn default">Cancelar</button>
    <button type="submit" class="btn blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>
