<div class="modal fade bs-modal" id="set_rejection_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Rechazar partida</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.reject-set', 'method' => 'post', 'class' => 'horizontal-form', 
                'id' => 'set_rejection_form']) !!}
                <input type="hidden" name="documents_supplies_id" id="rejection_modal_set_id" value="">
                <div id="set_rejection_modal_error_messages"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rejection_reasons_id" class="control-label">Motivo</label>
                            {!! Form::select('rejection_reasons_id', $rejection_reasons, null, 
                            ['class' => 'form-control drop-down', 'id' => 'rejection_reasons_id', 'placeholder' => 'Seleccionar...']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comments" class="control-label">Comentarios</label>
                            {!! Form::textarea('comments', null, ['class' => 'form-control', 'autocomplete' => 'off',
                            'style' => 'resize: vertical; height: 180px',]) !!}
                        </div>
                    </div>
                </div>
                <div style="text-align: right">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-circle blue">Enviar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>