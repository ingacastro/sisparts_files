<div class="modal fade bs-modal" id="quotation_request_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Enviar solicitud de cotización</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.sets-file-attachment', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'file_attachment_form']) !!}
                <div id="file_attachment_error_messages"></div>
                <div id="file_attachment_success_message"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" id="supply_number"></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" id="supply_number">Proveedores: </label>
                            <div class="radio-list">
                                <label>
                                    <input class="material-specifications" type="checkbox" name="material_specifications" value="checked" {{ $checklist->material_specifications }}> Revisar especificaciones del material
                                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::select('message', [], null, 
                            ['class' => 'form-control', 'id' => "quotation_request_messages_select2"]) !!}
                        </div>
                    </div>
                </div>
                <div style="text-align: right; padding: 10px">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-circle blue">Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>