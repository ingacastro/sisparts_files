<?php $is_create = !isset($model->id) ?>
<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="title"><span class="required">*</span>Título</label>
                {!! Form::text('title', $model->title, ['class' => 'form-control', 'id' => 'title',
                'autocomplete' => 'off'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="type"><span class="required">* </span>Tipo de condición</label>
                {!! Form::select('type', $types, $model->type, ['placeholder' => 'Seleccionar...', 'class' => 'form-control',
                'id' => 'type']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" id="condition_type_elapsed_days" style="display: none">
                <label class="control-label" for="elapsed_days"><span class="required">* </span>Cantidad de días</label>
                {!! Form::text('elapsed_days', $model->elapsed_days, ['class' => 'form-control integer-mask', 'autocomplete' => 'off',
                'id' => 'elapsed_days']) !!}
            </div>
            <div class="form-group" id="condition_type_status_change" style="display: none">
                <label class="control-label" for="supplies_sets_status_id"><span class="required">* </span>Estatus de partida</label>
                {!! Form::select('supplies_sets_status_id', $set_status, $model->supplies_sets_status_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'supplies_sets_status_id']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="recipients"><span class="required">* </span>Destinatarios</label>
                {!! Form::text('recipients', $model->recipients, ['class' => 'form-control input-large', 
                'id' => 'recipients', 'autocomplete' => 'off', 'data-role' => 'tagsinput'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="subject"><span class="required">* </span>Asunto del correo</label>
                {!! Form::text('subject', $model->subject, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="message">Mensaje del correo</label>
                {!! Form::textarea('message', $model->message, ['class' => 'form-control', 'autocomplete' => 'off',
                'style' => 'resize: vertical; height: 180px',]) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('user.index') }}" class="btn btn-circle default">Cancelar</a>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>