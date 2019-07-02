<div class="modal fade bs-modal" id="replacement_observation_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="replacement_observation_modal_title"></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['class' => 'horizontal-form', 'id' => 'replacement_observation_form', 'data-type' => '1']) !!}
                <input type="hidden" name="supplies_id" id="replacement_observation_modal_supplies_id">
                <input type="hidden" name="replacement_id" id="replacement_observation_modal_replacement_id" value="">
                <input type="hidden" name="observation_id" id="replacement_observation_modal_observation_id" value="">
                <div id="replacement_observation_error_messages"></div>
                <div id="replacement_observation_success_message"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="replacement_observation_form_description">Descripción</label>
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id'  => 'replacement_observation_form_description',
                                'autocomplete' => 'off', 'style' => 'resize: vertical; height: 180px']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: right">
                            <button type="button" class="btn btn-circle default" id="replacement_observation_cancel_btn" style="display: none">Cancelar</button>
                            <button type="submit" class="btn btn-circle green" id="replacement_observation_save_btn">Guardar</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="row" style="padding: 0 15px 0 15px">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="replacement_observation_table">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>