<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="trade_name"><span class="required">* </span>Titulo</label>
                {!! Form::text('name', $model->name, ['class' => 'form-control', 'id' => 'name',
                'autocomplete' => 'off']) !!}

                {!! Form::token() !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="country"><span class="required">* </span>Descripción de ayuda</label>
                {!! Form::text('help', $model->help, ['class' => 'form-control', 'id' => 'help']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="email"><span class="required">* </span>Estatus</label>
                {!! Form::select('status', array('Visible' => 'Visible', 'No Visible' => 'No Visible'), 'Visible', ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('checklistauth.index') }}" class="btn btn-circle default">{{ $cancel_btn }}</a>
    @if(!$is_edit)
    <button type="button" class="btn btn-circle blue" onclick="$('#basic_form').submit()">
        <i class="fa fa-check"></i> Continuar</button>
    @else
    <button type="button" class="btn btn-circle blue" onclick="$('#basic_form').submit()">
    <i class="fa fa-check"></i> Guardar</button>
    @endif
</div>
