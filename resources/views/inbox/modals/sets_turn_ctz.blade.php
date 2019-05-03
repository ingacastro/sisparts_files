<div class="modal bs-modal" id="sets_turn_ctz_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Convertir a CTZ</h4>
                Selecciona las partidas que deseas convertir a CTZ (solo se podrán convertir las partidas que estén autorizadas y no hayan sido convertidas antes)
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.sets-file-attachment', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'file_attachment_form']) !!}
                <div id="file_attachment_error_messages"></div>
                <div id="file_attachment_success_message"></div>
                <div class="row" style="padding: 0 10px 0 10px">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sets_turn_ctz_table">
                        <thead>
                            <tr>
                                <th>Número parte</th>
                                <th>Proveedor</th>
                                <th>Cant</th>
                                <th>U. Medida</th>
                                <th>Costo total</th>
                                <th>Precio total</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>