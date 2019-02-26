{!! Form::open(['route' => 'supplier.store', 'class' => 'horizontal-form']) !!}
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="trade_name">Nombre comercial</label>
                {!! Form::text('trade_name', $model->trade_name, ['class' => 'form-control', 'id' => 'trade_name']) !!}
            </div>
        </div>
        <!--/span-->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="">Country</label>
                {!! Form::select('countries_id', [1, 2], $model->countries_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'countries_id']) !!}
            </div>
        </div>
        <!--/span-->
    </div>
    <!--/row-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="email">Correo electrónico</label>
                {!! Form::text('email', $model->email, ['class' => 'form-control', 'id' => 'email']) !!}
            </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="language">Idioma</label>
                    {!! Form::select('languages_id', [1, 2], $model->languages_id, 
                    ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'languages_id']) !!}
            </div>
            <!--/span-->
        </div>
    </div>
    <!--/row-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="landline">Teléfono fijo</label>
                {!! Form::text('landline', $model->landline, ['class' => 'form-control', 'id' => 'landline']) !!}
            </div>
        </div>
        <!--/span-->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="currencies_id">Moneda</label>
                {!! Form::select('currencies_id', [1, 2], $model->currencies_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'currencies_id']) !!}
            </div>
        </div>
        <!--/span-->
    </div>
    <!--/row-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="landline">Teléfono móvil</label>
                {!! Form::text('landline', $model->landline, ['class' => 'form-control', 'id' => 'landline']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="mt-checkbox"> Checkbox 1
                    <input type="checkbox" value="1" name="test" />
                    <span></span>
                </label>
            </div>
        </div>
    </div>
<div class="form-actions right">
    <button type="button" class="btn default">Cancelar</button>
    <button type="submit" class="btn blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>
{!! Form::close() !!}