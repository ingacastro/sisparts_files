<div class="row modal-content-row">
    <div class="col-md-8">
        <div class="row modal-content-border">
            <div id="files_table_container" style="display: none; margin: 0 10px">
                <input type="hidden" id="set_supplies_id" value="{{ $set->supplies_id }}">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="set_edit_files_table">
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
    {{-- An admin user and set status as in authorization or set status as budget registered or rejected status --}}
    @if((Auth::user()->hasRole('Administrador') && $set->status == 6) || (Auth::user()->hasRole('Cotizador') && ($set->status == 5 || $set->status == 7)))
    <div class="col-md-4">
        @include('inbox.set_edition_modal_tabs.includes.checklist')
    </div>
    @endif
</div>
