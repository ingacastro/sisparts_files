<div class="modal fade bs-modal" id="quotation_request_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Enviar solicitud de cotización</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.send-suppliers-quotation', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'file_attachment_form']) !!}
                <input type="hidden" name="documents_supplies_id" id="documents_supplies_id">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="radio-list" id="left_suppliers"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="radio-list" id="right_suppliers"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::select('message_id', $messages, null, 
                            ['class' => 'form-control', 'placeholder' => 'Seleccionar...', 'id' => "quotation_request_messages_select"]) !!}
                        </div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-circle blue">Enviar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>