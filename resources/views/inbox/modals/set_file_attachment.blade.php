<div class="modal fade bs-modal" id="set_file_attachment_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Archivos adjuntos</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.sets-file-attachment', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'set_file_attachment_form']) !!}
                <input type="hidden" name="supplies[]" id="set_file_attachment_modal_supply_id" value="">
                <div id="set_file_attachment_error_messages"></div>
                <div id="set_file_attachment_success_message"></div>
                <div class="form-group">
                    <label class="control-label" id="current_dealership"></label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::text('supplier', null, ['class' => 'form-control', 'placeholder' => 'Nombre proveedor...']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pull-right">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                        <span class="fileinput-filename"> </span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Seleccionar archivo </span>
                                        <span class="fileinput-exists"> Cambiar </span>
                                        <input type="file" name="file"> </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Quitar </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::select('type', [1 => 'Cotización', 2 => 'Ficha técnica'], null, ['class' => 'form-control', 'placeholder' => 'Tipo...']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                        {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'URL...']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-circle green">Subir</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>