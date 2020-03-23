<div class="modal fade bs-modal" id="custom_binnacle_entry_modal" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Nueva entrada de seguimiento</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'inbox.binnacle-entry', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'binnacle_entry_form']) !!}
                <input type="hidden" name="documents_id" value="{{ $document->id }}">
                <div id="binnacle_entry_error_messages"></div>
                <div id="binnacle_entry_success_message"></div>
                <div class="row">
                    <div class="col-md-12 checklist-container">
                        <div class="form-group">
                            <div class="radio-list">
                                <label>
                                    <input class="set-checklist material-specifications" name="entity" type="radio" value="2"
                                    onchange="initBinnacleEntryDataTable()"> Item 
                                </label>
                                <label>
                                    <input class="set-checklist quoted-amounts" name="entity" onchange="destroyBinnacleEntryDataTable()" type="radio" value="1"> PCT
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 0 10px 0 10px">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="new_binnacle_entry_supplies_table" style="display: none">
                        <thead>
                            <tr role="row" class="heading">
                                <th></th>
                                <th>Número parte</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control" name="type" >
                                <option value="">Tipo</option>
                                @foreach ($selectlist as $select)                                     
                                <option value="{{$select->id}}">{{$select->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::textarea('comments', null, ['class' => 'form-control', 
                            'style' => 'resize: vertical; height: 155px','placeholder' => 'Comentarios...']) !!}
                        </div>
                    </div>
                </div>
                <div style="text-align: right; padding: 10px">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button id="form-submit" type="submit" class="btn btn-circle blue">Enviar</button>
                </div>
               
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>