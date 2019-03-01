<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="trade_name"><span class="required">* </span>Nombre comercial</label>
                {!! Form::text('trade_name', $model->trade_name, ['class' => 'form-control', 'id' => 'trade_name']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="country"><span class="required">* </span>Country</label>
                {!! Form::select(null, $countries, $model->countries_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control drop-down', 'id' => 'country']) !!}
                <input type="hidden" name="countries_id" value="{{ $model->countries_id }}" id="country_hidden">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="email"><span class="required">* </span>Correo electrónico</label>
                {!! Form::text('email', $model->email, ['class' => 'form-control', 'id' => 'email']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="language"><span class="required">* </span>Idioma</label>
                {!! Form::select(null, $languages, $model->languages_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control drop-down', 'id' => 'language']) !!}
                <input type="hidden" name="languages_id" value="{{ $model->languages_id }}" id="language_hidden">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="landline"><span class="required">* </span>Teléfono fijo</label>
                {!! Form::text('landline', $model->landline, ['class' => 'form-control phone-mask', 'id' => 'landline']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="currency"><span class="required">* </span>Moneda</label>
                {!! Form::select(null, $currencies, $model->currencies_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control drop-down', 'id' => 'currency']) !!}
                <input type="hidden" name="currencies_id" value="{{ $model->currencies_id }}" id="currency_hidden">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="landline"><span class="required">* </span>Teléfono móvil</label>
                {!! Form::text('mobile', $model->landline, ['class' => 'form-control phone-mask', 'id' => 'landline']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="margin: 15px 0 0 0">
                <label class="mt-checkbox" style="margin: 15px 0 0 0">Marketplace
                    <input type="checkbox" value="1" name="marketplace" />
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('supplier.index') }}" class="btn default">Cancelar</a>
    <button type="button" class="btn blue" onclick="$('#tab_1').trigger('click')">
        <i class="fa fa-check"></i> Continuar</button>
</div>
