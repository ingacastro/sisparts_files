@if(Auth::user()->hasRole('Cotizador') && $set->status == 7)
<?php $last_rejection = $set->rejections->last(); ?>
<strong style="color: red">Motivo de rechazo: </strong>{{ $last_rejection->title }}</br>
{{ $last_rejection->pivot->comments }}
@endif

@if(Auth::user()->hasRole('Cotizador') && ($set->status == 5 || $set->status == 7))
<div class="row modal-content-border" style="background: #f1f4f7;">
    <div class="col-md-12 checklist-container">                            
        <h4 class="form-section">Checklist</h4>
        <form id="checklist_form">
            <div class="form-group">
                <div class="radio-list">
                    @php
                        $i = 0;
                    @endphp
                    @foreach($checklist as $key => $value)
                        @if($key == 'id')
                            @php
                                $i = $value;
                            @endphp
                        @endif
                        @foreach($checklistauth as $check)
                            @if($check->checklist_column == $key)
                                @if($check->status == 'Visible')
                    <label>
                        <input class="set-checklist {{ $key }}" data-set_id="{{ $i }}" data-field="{{ $key }}" type="checkbox" name="{{ $key }}" value="checked" {{ $value }}> {{ $check->name }}
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark" 
                        title="Revisar a detalle las especificaciones del material y revisar la descripción que nos ofrece el proveedor coincida con lo que estamos ofreciendo al cliente."></span>
                    </label>
                                    
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </form>
        <div class="checklist-buttons-container">
            <button type="submit" class="btn btn-circle btn-sm green-meadow set-status-change"
            data-set_id="{{$set->id}}" data-document_id="{{ $doc_id }}" data-status="6" id="in_authorization_btn"
            style="display: {{ Auth::user()->hasRole('Cotizador') && ($set->status == 5 || $set->status == 7) ? 'inline-block' : 'none' }}">Enviar a autorización</button>

            @role('Administrador')
            <div id="authorization_btns_container" style="display: {{ $set->status == 6 ? 'block' : 'none'}}">
                <button type="submit" class="btn btn-circle btn-sm green-meadow set-status-change" data-set_id="{{$set->id}}" 
                    data-status="8" data-document_id="{{ $doc_id }}">Autorizar</button>
                <button type="button" class="btn btn-circle btn-sm yellow set-rejection" data-set_id="{{$set->id}}" 
                    data-status="7" data-document_id="{{ $doc_id }}" data-target="#set_rejection_modal" data-toggle="modal">Rechazar</button>
            </div>
            @endrole
        </div>
    </div>                          
</div>
@endif

@role('Administrador')
@if($set->status == 5 || $set->status == 7 || $set->status == 6)
<div class="row modal-content-border" style="background: #f1f4f7;">
    <div class="col-md-12 checklist-container">                            
        <h4 class="form-section">Checklist</h4>
        <form id="checklist_form">
            <div class="form-group">
                <div class="radio-list">
                    @php
                        $i = 0;
                    @endphp
                    @foreach($checklist as $key => $value)
                        @if($key == 'id')
                            @php
                                $i = $value;
                            @endphp
                        @endif
                        @foreach($checklistauth as $check)
                            @if($check->checklist_column == $key)
                                @if($check->status == 'Visible')
                    <label>
                        <input class="set-checklist {{ $key }}" data-set_id="{{ $i }}" data-field="{{ $key }}" type="checkbox" name="{{ $key }}" value="checked" {{ $value }}> {{ $check->name }}
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark" 
                        title="Revisar a detalle las especificaciones del material y revisar la descripción que nos ofrece el proveedor coincida con lo que estamos ofreciendo al cliente."></span>
                    </label>
                                    
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </form>
        <div class="checklist-buttons-container">
            <button type="submit" class="btn btn-circle btn-sm green-meadow set-status-change"
            data-set_id="{{$set->id}}" data-document_id="{{ $doc_id }}" data-status="6" id="in_authorization_btn"
            style="display: {{ Auth::user()->hasRole('Cotizador') && ($set->status == 5 || $set->status == 7) ? 'inline-block' : 'none' }}">Enviar a autorización</button>

            @role('Administrador')
            <div id="authorization_btns_container" style="display: {{ $set->status == 6 ? 'block' : 'none'}}">
                <button type="submit" class="btn btn-circle btn-sm green-meadow set-status-change" data-set_id="{{$set->id}}" 
                    data-status="8" data-document_id="{{ $doc_id }}">Autorizar</button>
                <button type="button" class="btn btn-circle btn-sm yellow set-rejection" data-set_id="{{$set->id}}" 
                    data-status="7" data-document_id="{{ $doc_id }}" data-target="#set_rejection_modal" data-toggle="modal">Rechazar</button>
            </div>
            @endrole
        </div>
    </div>                          
</div>
@endif
@endrole