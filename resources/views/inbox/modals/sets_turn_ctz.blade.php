<div class="modal bs-modal" id="sets_turn_ctz_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Convertir a CTZ</h4>
                Selecciona las partidas que deseas convertir a CTZ (solo se podrán convertir las partidas que estén autorizadas y no hayan sido convertidas antes)
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.sets-turn-ctz', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'sets_turn_ctz_form']) !!}
                <div id="sets_turn_ctz_error_messages"></div>
                <div id="sets_turn_ctz_success_message"></div>
                <div class="row" style="padding: 0 10px 0 10px">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sets_turn_ctz_table">
                        <thead>
                            <tr role="row" class="heading">
                                <th></th>
                                <th>Número parte</th>
                                <th>Proveedor</th>
                                <th>Cant</th>
                                <th>U. Medida</th>
                                <th>Costo total</th>
                                <th>Precio total</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-circle blue">Convertir</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>