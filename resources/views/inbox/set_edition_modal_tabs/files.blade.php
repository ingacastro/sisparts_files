<div class="row modal-content-row">
    <div class="col-md-12">
        <div class="row modal-content-border">
            <div id="files_table_container" style="display: none; margin: 0 10px">
                <input type="hidden" id="set_supplies_id" value="{{ $set->supplies_id }}">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <a class="btn btn-circle btn-icon-only default blue set-file-attachment" href="#set_file_attachment_modal" data-target="#set_file_attachment_modal" data-toggle="modal" data-supply_id="{{ $set->supplies_id }}" style="position: fixed;"><i class="fa fa-paperclip"></i></a>
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
    
</div>
