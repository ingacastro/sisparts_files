<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="name">Título</label>
                {!! Form::text('user[name]', null, ['class' => 'form-control', 'id' => 'name',
                'autocomplete' => 'off'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="name">Asunto</label>
                {!! Form::text('user[name]', null, ['class' => 'form-control', 'id' => 'name',
                'autocomplete' => 'off'])!!}
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="wysiwyg_toolbar"></div>
            <div name="body" id="message_body"></div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('message.index') }}" class="btn btn-circle default">Cancelar</a>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>