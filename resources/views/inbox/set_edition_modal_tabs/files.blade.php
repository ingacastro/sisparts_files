<div class="row modal-content-row">
    <div class="col-md-8">
        <div class="row modal-content-border">
            <div id="files_table_container" style="display: none; margin: 0 10px">
                <input type="hidden" id="set_auto_id" value="{{ $set->id }}">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="files_table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        {!! Form::open(['route' => ['inbox.update-set-checklist', $set->id], 
        'method' => 'post', 'id' => 'edit_checklist_form']) !!}
        <input type="hidden" id="checklist_id" value="{{ $set->id }}">
        @include('inbox.set_edition_modal_tabs.includes.checklist')
        {!! Form::close() !!}
    </div>
</div>
