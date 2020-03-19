<div class="modal fade bs-modal" id="quotation_request_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Enviar solicitud de cotización</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.send-suppliers-quotation', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'quotation_request_form']) !!}
                <input type="hidden" name="documents_supplies_id" id="documents_supplies_id">
                <div id="quotation_request_error_messages"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" id="quotation_request_manufacturer"></label>
                            <input type="hidden" id="quotation_request_manufacturer_hidden" name="manufacturer" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" id="supply_number" style="font-weight: bold">Proveedores: </label>
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
                            <label class="control-label" id="supply_number" style="font-weight: bold">Partes: </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="radio-list" id="left_supplies"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="radio-list" id="right_supplies"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="other_emails_1" class="control-label">Proveedores Español</label>
                            <select multiple name="custom_emails_1[]" class="form-control input-large" data-role="tagsinput" id="other_emails_1"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="other_emails_2" class="control-label">Proveedores Inglés</label>
                            <select multiple name="custom_emails_2[]" class="form-control input-large" data-role="tagsinput" id="other_emails_2"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="other_emails_3" class="control-label">Proveedores Portugués</label>
                            <select multiple name="custom_emails_3[]" class="form-control input-large" data-role="tagsinput" id="other_emails_3"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::select('message_id', $messages, null, 
                            ['class' => 'form-control', 'placeholder' => 'Mensaje...', 'id' => "quotation_request_messages_select"]) !!}
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