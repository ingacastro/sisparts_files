<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="trade_name"><span class="required">* </span>Nombre comercial</label>
                {!! Form::text('trade_name', $model->trade_name, ['class' => 'form-control', 'id' => 'trade_name',
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="country"><span class="required">* </span>Country</label>
                {!! Form::select(null, $selects_options['countries'], $model->countries_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control drop-down', 'id' => 'country']) !!}
                <input type="hidden" name="countries_id" value="{{ $model->countries_id }}" id="country_hidden">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="email">Correo electrónico</label>
                {!! Form::text('email', $model->email, ['class' => 'form-control', 'id' => 'email',
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="language"><span class="required">* </span>Idioma</label>
                {!! Form::select(null, $selects_options['languages'], $model->languages_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control drop-down', 'id' => 'language']) !!}
                <input type="hidden" name="languages_id" value="{{ $model->languages_id }}" id="language_hidden">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="landline">Teléfono fijo</label>
                {!! Form::text('landline', $model->landline, ['class' => 'form-control phone-mask', 'id' => 'landline',
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="currency">Moneda</label>
                {!! Form::select(null, $selects_options['currencies'], $model->currencies_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control drop-down', 'id' => 'currency']) !!}
                <input type="hidden" name="currencies_id" value="{{ $model->currencies_id }}" id="currency_hidden">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="landline">Teléfono móvil</label>
                {!! Form::text('mobile', $model->landline, ['class' => 'form-control phone-mask', 'id' => 'landline',
                'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="margin: 15px 0 0 0">
                <input type="checkbox" value="1" name="marketplace" {{$model->marketplace == 1 ? 'checked' : ''}} />
                <label style="margin: 20px 0 0 0">Marketplace </label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('supplier.index') }}" class="btn btn-circle default">{{ $cancel_btn }}</a>
    @if(!$is_edit)
    <button type="button" class="btn btn-circle blue" onclick="$('#tab_1').trigger('click')">
        <i class="fa fa-check"></i> Continuar</button>
    @else
    <button type="button" class="btn btn-circle blue" onclick="$('#fiscal_form').submit()">
    <i class="fa fa-check"></i> Guardar</button>
    @endif
</div>
